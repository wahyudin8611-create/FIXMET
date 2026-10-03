<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\RepairImage;
use App\Models\RepairReport;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepairReportController extends Controller
{
    public function __construct(private BookingService $bookingService) {}

    public function create(Booking $booking)
    {
        if ($redirect = $this->guardReportable($booking)) {
            return $redirect;
        }

        return view('technician.repair-reports.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        if ($redirect = $this->guardReportable($booking)) {
            return $redirect;
        }

        $request->validate([
            'actual_diagnosis' => ['required', 'string', 'max:255'],
            'repair_action' => ['required', 'string'],
            'parts_used' => ['nullable', 'string'],
            'additional_cost' => ['nullable', 'numeric', 'min:0'],
            'repair_result' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'images_before' => ['nullable', 'array', 'max:3'],
            'images_before.*' => ['file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'images_after' => ['nullable', 'array', 'max:3'],
            'images_after.*' => ['file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        DB::transaction(function () use ($request, $booking) {
            $report = RepairReport::create([
                'booking_id' => $booking->id,
                'actual_diagnosis' => $request->actual_diagnosis,
                'repair_action' => $request->repair_action,
                'parts_used' => $request->parts_used,
                'additional_cost' => $request->additional_cost ?? 0,
                'repair_result' => $request->repair_result,
                'notes' => $request->notes,
            ]);

            $this->storeReportImages($request, $report, 'images_before', 'before');
            $this->storeReportImages($request, $report, 'images_after', 'after');

            $this->bookingService->complete($booking);
        });

        return redirect()->route('technician.bookings.show', $booking->id)
            ->with('success', 'Laporan perbaikan tersimpan dan booking selesai.');
    }

    /**
     * Only the assigned technician may report, and only on work in progress.
     * A booking that already has a report is completed instead of reported twice.
     */
    private function guardReportable(Booking $booking): ?RedirectResponse
    {
        if ($booking->technician_id !== auth()->user()->technician->id) {
            abort(403);
        }

        if ($booking->status !== 'in_progress') {
            return redirect()->route('technician.bookings.show', $booking->id)
                ->with('error', 'Laporan hanya bisa dibuat untuk booking yang sedang dikerjakan.');
        }

        if ($booking->repairReport()->exists()) {
            $this->bookingService->complete($booking);

            return redirect()->route('technician.bookings.show', $booking->id)
                ->with('success', 'Laporan perbaikan sudah ada, booking ditandai selesai.');
        }

        return null;
    }

    private function storeReportImages(Request $request, RepairReport $report, string $field, string $type): void
    {
        if (! $request->hasFile($field)) {
            return;
        }

        foreach ($request->file($field) as $image) {
            $path = $image->store('repair-reports/'.date('Y/m'), 'public');
            RepairImage::create([
                'repair_report_id' => $report->id,
                'image_path' => $path,
                'image_type' => $type,
                'created_at' => now(),
            ]);
        }
    }
}

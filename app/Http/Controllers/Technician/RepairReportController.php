<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\RepairImage;
use App\Models\RepairReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RepairReportController extends Controller
{
    public function create(Booking $booking)
    {
        if ($booking->technician_id !== auth()->user()->technician->id) abort(403);
        return view('technician.repair-reports.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        if ($booking->technician_id !== auth()->user()->technician->id) abort(403);

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

        return redirect()->route('technician.bookings.show', $booking->id)
            ->with('success', 'Laporan perbaikan berhasil disimpan.');
    }

    private function storeReportImages(Request $request, RepairReport $report, string $field, string $type): void
    {
        if (!$request->hasFile($field)) return;

        foreach ($request->file($field) as $image) {
            $path = $image->store('repair-reports/' . date('Y/m'), 'public');
            RepairImage::create([
                'repair_report_id' => $report->id,
                'image_path' => $path,
                'image_type' => $type,
                'created_at' => now(),
            ]);
        }
    }
}

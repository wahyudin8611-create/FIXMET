<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Consultation;
use App\Models\Technician;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(private BookingService $bookingService) {}

    public function index()
    {
        $bookings = auth()->user()->bookings()
            ->with('technician.user', 'consultation.device')
            ->latest()
            ->paginate(10);

        return view('user.bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $technician = Technician::with('user')->findOrFail($request->technician_id);
        $consultation = null;
        if ($request->consultation_id) {
            $consultation = Consultation::findOrFail($request->consultation_id);
        }

        return view('user.bookings.create', compact('technician', 'consultation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'technician_id' => ['required', 'exists:technicians,id'],
            'consultation_id' => ['nullable', 'exists:consultations,id'],
            'service_date' => ['required', 'date', 'after_or_equal:today'],
            'service_time' => ['required'],
            'service_address' => ['required', 'string', 'max:500'],
            'problem_description' => ['required', 'string', 'max:1000'],
        ]);

        $booking = $this->bookingService->create([
            'user_id' => auth()->id(),
            'technician_id' => $request->technician_id,
            'consultation_id' => $request->consultation_id,
            'service_date' => $request->service_date,
            'service_time' => $request->service_time,
            'service_address' => $request->service_address,
            'problem_description' => $request->problem_description,
            'estimated_fee' => Technician::find($request->technician_id)->service_fee,
        ]);

        return redirect()->route('user.bookings.show', $booking->id)
            ->with('success', 'Booking berhasil dibuat! Menunggu konfirmasi teknisi.');
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        $booking->load('technician.user', 'consultation.device', 'messages.sender', 'repairReport.images', 'review');

        return view('user.bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('update', $booking);

        if (!in_array($booking->status, ['pending', 'accepted'])) {
            return back()->with('error', 'Booking tidak dapat dibatalkan pada status ini.');
        }

        $this->bookingService->cancel($booking);
        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}

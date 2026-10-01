<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(private BookingService $bookingService) {}

    public function index()
    {
        $technician = auth()->user()->technician;
        $bookings = $technician->bookings()
            ->with('user', 'consultation.device.category')
            ->latest()
            ->paginate(10);

        return view('technician.bookings.index', compact('bookings'));
    }

    public function requests()
    {
        $technician = auth()->user()->technician;
        $bookings = $technician->bookings()
            ->where('status', 'pending')
            ->with('user', 'consultation.device', 'consultation.images')
            ->latest()
            ->get();

        return view('technician.requests', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $this->ensureOwnBooking($booking);
        $booking->load('user', 'consultation.device', 'consultation.images', 'consultation.answers.symptom', 'messages.sender', 'repairReport.images');
        return view('technician.bookings.show', compact('booking'));
    }

    public function accept(Booking $booking)
    {
        $this->ensureOwnBooking($booking);
        $this->bookingService->accept($booking);
        return back()->with('success', 'Booking diterima.');
    }

    public function reject(Request $request, Booking $booking)
    {
        $this->ensureOwnBooking($booking);
        $request->validate(['reason' => ['required', 'string', 'max:500']]);
        $this->bookingService->reject($booking, $request->reason);
        return back()->with('success', 'Booking ditolak.');
    }

    public function startWork(Booking $booking)
    {
        $this->ensureOwnBooking($booking);
        $this->bookingService->startWork($booking);
        return back()->with('success', 'Status diubah ke Sedang Dikerjakan.');
    }

    public function complete(Booking $booking)
    {
        $this->ensureOwnBooking($booking);
        $this->bookingService->complete($booking);
        return back()->with('success', 'Booking ditandai selesai.');
    }

    private function ensureOwnBooking(Booking $booking): void
    {
        if ($booking->technician_id !== auth()->user()->technician->id) {
            abort(403);
        }
    }
}

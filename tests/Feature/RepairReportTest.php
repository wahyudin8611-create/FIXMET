<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepairReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_submitting_a_repair_report_completes_the_booking(): void
    {
        $booking = $this->bookingInStatus('in_progress');

        $this->actingAs($booking->technician->user)
            ->post(route('technician.repair-reports.store', $booking), $this->reportFields())
            ->assertRedirect(route('technician.bookings.show', $booking));

        $this->assertSame('completed', $booking->refresh()->status);
        $this->assertSame(1, $booking->repairReport()->count());
        $this->assertSame(1, $booking->technician->refresh()->completed_jobs);
    }

    public function test_user_can_review_the_booking_once_the_report_is_submitted(): void
    {
        $booking = $this->bookingInStatus('in_progress');
        $this->actingAs($booking->technician->user)
            ->post(route('technician.repair-reports.store', $booking), $this->reportFields());

        $this->actingAs($booking->user)
            ->get(route('user.bookings.show', $booking))
            ->assertOk()
            ->assertSee('Berikan Ulasan');
    }

    public function test_booking_that_already_has_a_report_is_completed_without_a_second_report(): void
    {
        $booking = $this->bookingInStatus('in_progress');
        $booking->repairReport()->create(['actual_diagnosis' => 'Freon habis', 'repair_result' => 'Berhasil']);

        $this->actingAs($booking->technician->user)
            ->get(route('technician.repair-reports.create', $booking))
            ->assertRedirect(route('technician.bookings.show', $booking));

        $this->assertSame('completed', $booking->refresh()->status);
        $this->assertSame(1, $booking->repairReport()->count());
    }

    public function test_report_cannot_be_submitted_before_work_has_started(): void
    {
        $booking = $this->bookingInStatus('accepted');

        $this->actingAs($booking->technician->user)
            ->post(route('technician.repair-reports.store', $booking), $this->reportFields())
            ->assertRedirect(route('technician.bookings.show', $booking));

        $this->assertSame('accepted', $booking->refresh()->status);
        $this->assertSame(0, $booking->repairReport()->count());
    }

    public function test_other_technician_cannot_report_on_the_booking(): void
    {
        $booking = $this->bookingInStatus('in_progress');
        $otherTechnician = $this->technician();

        $this->actingAs($otherTechnician->user)
            ->post(route('technician.repair-reports.store', $booking), $this->reportFields())
            ->assertForbidden();

        $this->assertSame('in_progress', $booking->refresh()->status);
    }

    private function bookingInStatus(string $status): Booking
    {
        return Booking::create([
            'user_id' => User::factory()->create()->id,
            'technician_id' => $this->technician()->id,
            'booking_code' => 'BK-'.fake()->unique()->bothify('????####'),
            'service_date' => now()->addDay()->toDateString(),
            'service_time' => '09:00',
            'service_address' => 'Karawang',
            'problem_description' => 'AC tidak dingin',
            'status' => $status,
        ]);
    }

    private function technician(): Technician
    {
        return Technician::create([
            'user_id' => User::factory()->technician()->create()->id,
            'specialization' => 'AC',
            'service_area' => 'Karawang',
            'status' => 'verified',
            'is_verified' => true,
        ]);
    }

    /**
     * @return array{actual_diagnosis: string, repair_action: string, repair_result: string}
     */
    private function reportFields(): array
    {
        return [
            'actual_diagnosis' => 'Freon habis',
            'repair_action' => 'Isi ulang freon dan cek kebocoran',
            'repair_result' => 'Berhasil',
        ];
    }
}

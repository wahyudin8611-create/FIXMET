<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageNotificationTest extends TestCase
{
    use RefreshDatabase;

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

    private function booking(Technician $technician, User $user): Booking
    {
        return Booking::create([
            'user_id' => $user->id,
            'technician_id' => $technician->id,
            'booking_code' => 'BK-'.fake()->unique()->bothify('????####'),
            'service_date' => now()->addDay()->toDateString(),
            'service_time' => '09:00',
            'service_address' => 'Karawang',
            'problem_description' => 'AC tidak dingin',
            'status' => 'accepted',
        ]);
    }

    public function test_unread_count_tallies_incoming_messages_only(): void
    {
        $technician = $this->technician();
        $user = User::factory()->create(['name' => 'Budi Pengguna']);
        $booking = $this->booking($technician, $user);

        // Dua pesan dari pengguna (masuk) + satu pesan dari teknisi (keluar).
        $booking->messages()->create(['sender_id' => $user->id, 'message' => 'Halo pak']);
        $booking->messages()->create(['sender_id' => $user->id, 'message' => 'Kapan bisa datang?']);
        $booking->messages()->create(['sender_id' => $technician->user_id, 'message' => 'Besok ya']);

        $response = $this->actingAs($technician->user)
            ->getJson(route('technician.messages.unread'));

        $response->assertOk()
            ->assertJsonPath('count', 2)
            ->assertJsonPath('latest.sender_name', 'Budi Pengguna')
            ->assertJsonPath('latest.booking_id', $booking->id);
    }

    public function test_opening_the_chat_marks_messages_read_and_clears_the_badge(): void
    {
        $technician = $this->technician();
        $user = User::factory()->create();
        $booking = $this->booking($technician, $user);

        $booking->messages()->create(['sender_id' => $user->id, 'message' => 'Halo']);

        $this->actingAs($technician->user);

        $this->getJson(route('technician.messages.unread'))->assertJsonPath('count', 1);

        // Membuka ruang obrolan (getMessages) menandai pesan terbaca.
        $this->getJson(route('technician.messages.list', $booking))->assertOk();

        $this->getJson(route('technician.messages.unread'))->assertJsonPath('count', 0);
    }

    public function test_user_also_has_an_unread_count_endpoint(): void
    {
        $technician = $this->technician();
        $user = User::factory()->create();
        $booking = $this->booking($technician, $user);

        $booking->messages()->create(['sender_id' => $technician->user_id, 'message' => 'Saya OTW']);

        $this->actingAs($user)
            ->getJson(route('user.messages.unread'))
            ->assertOk()
            ->assertJsonPath('count', 1);
    }
}

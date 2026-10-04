<?php

namespace Tests\Feature;

use App\Models\Technician;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TechnicianProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_technician_can_change_their_name_from_the_profile_page(): void
    {
        $technician = $this->verifiedTechnician();

        $this->actingAs($technician->user)
            ->get(route('technician.profile.edit'))
            ->assertOk()
            ->assertSee('name="name"', false);

        $this->actingAs($technician->user)
            ->put(route('technician.profile.update'), $this->profileFields(['name' => 'Ahmad Servis Laptop']))
            ->assertRedirect()
            ->assertSessionHas('success', 'Profil teknisi berhasil disimpan.');

        $this->assertSame('Ahmad Servis Laptop', $technician->user->refresh()->name);
    }

    public function test_name_is_required(): void
    {
        $technician = $this->verifiedTechnician();

        $this->actingAs($technician->user)
            ->put(route('technician.profile.update'), $this->profileFields(['name' => '']))
            ->assertSessionHasErrors('name');
    }

    private function verifiedTechnician(): Technician
    {
        return Technician::create([
            'user_id' => User::factory()->technician()->create(['name' => 'Ahmad Teknisi'])->id,
            'specialization' => 'Laptop & Komputer',
            'service_area' => 'Jakarta',
            'service_fee' => 100000,
            'experience_years' => 7,
            'status' => 'verified',
            'is_verified' => true,
        ]);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function profileFields(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Ahmad Teknisi',
            'specialization' => 'Laptop & Komputer',
            'description' => 'Spesialis perbaikan laptop.',
            'service_fee' => 100000,
            'experience_years' => 7,
            'service_area' => 'Jakarta, Bekasi',
        ], $overrides);
    }
}

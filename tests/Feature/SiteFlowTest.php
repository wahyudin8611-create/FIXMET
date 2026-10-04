<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Device;
use App\Models\Diagnosis;
use App\Models\RepairGuide;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_technician_verified_by_admin_appears_in_the_public_technician_list(): void
    {
        $technician = Technician::create([
            'user_id' => User::factory()->create(['name' => 'Rudi Servis'])->id,
            'specialization' => 'AC',
            'service_area' => 'Bandung',
            'status' => 'pending',
        ]);
        $this->get(route('technicians.index'))->assertDontSee('Rudi Servis');

        $this->actingAs($this->admin())->patch(route('admin.technicians.verify', $technician));

        $this->assertSame('technician', $technician->user->refresh()->role);
        $this->get(route('technicians.index'))->assertSee('Rudi Servis');
    }

    public function test_suspended_technician_disappears_from_the_public_technician_list(): void
    {
        $technician = Technician::create([
            'user_id' => User::factory()->technician()->create(['name' => 'Rudi Servis'])->id,
            'specialization' => 'AC',
            'service_area' => 'Bandung',
            'status' => 'verified',
            'is_verified' => true,
        ]);

        $this->actingAs($this->admin())->patch(route('admin.technicians.suspend', $technician));

        $this->get(route('technicians.index'))->assertDontSee('Rudi Servis');
    }

    public function test_logging_out_returns_to_the_home_page(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }

    public function test_guest_sees_the_login_link_on_the_home_page(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('href="'.route('login').'"', false);
    }

    public function test_signed_in_user_sees_their_dashboard_instead_of_login_on_the_home_page(): void
    {
        $this->actingAs(User::factory()->create(['name' => 'Budi Santoso']))
            ->get(route('home'))
            ->assertOk()
            ->assertDontSee('href="'.route('login').'"', false)
            ->assertSee('href="'.route('user.dashboard').'"', false)
            ->assertSee('Budi');
    }

    public function test_signed_in_technician_is_offered_the_technician_dashboard_instead_of_login(): void
    {
        $this->actingAs(User::factory()->technician()->create())
            ->get(route('technicians.index'))
            ->assertOk()
            ->assertDontSee('href="'.route('login').'"', false)
            ->assertSee('href="'.route('technician.dashboard').'"', false);
    }

    public function test_every_role_can_reach_their_dashboard_and_sign_out_from_public_pages(): void
    {
        $accounts = [
            'user.dashboard' => User::factory()->create(),
            'technician.dashboard' => User::factory()->technician()->create(),
            'admin.dashboard' => $this->admin(),
        ];

        foreach ($accounts as $dashboardRoute => $account) {
            foreach (['home', 'technicians.index'] as $page) {
                $this->actingAs($account)
                    ->get(route($page))
                    ->assertOk()
                    ->assertSee('href="'.route($dashboardRoute).'"', false)
                    ->assertSee('action="'.route('logout').'"', false);
            }
        }
    }

    public function test_admin_can_open_the_repair_guide_edit_page(): void
    {
        $category = Category::create(['name' => 'Smartphone']);
        $device = Device::create(['category_id' => $category->id, 'name' => 'HP Android']);
        $diagnosis = Diagnosis::create(['device_id' => $device->id, 'name' => 'Port Charger Kotor', 'severity' => 'low', 'repairability' => 'self_repair']);
        $guide = RepairGuide::create(['diagnosis_id' => $diagnosis->id, 'title' => 'Membersihkan Port Charger']);
        $guide->steps()->create(['step_number' => 1, 'title' => 'Matikan HP', 'description' => 'Matikan HP sepenuhnya.', 'warning' => 'Jangan pakai jarum "logam"']);

        $this->actingAs($this->admin())
            ->get(route('admin.repair-guides.edit', $guide))
            ->assertOk()
            ->assertSee('Membersihkan Port Charger');
    }

    private function admin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }
}

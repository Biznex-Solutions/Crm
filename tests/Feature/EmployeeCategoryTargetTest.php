<?php

namespace Tests\Feature;

use App\Models\CategoryTarget;
use App\Models\LeadSource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeCategoryTargetTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_assign_multiple_category_targets_to_employee(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $cat1 = CategoryTarget::create(['name' => 'Real Estate', 'target_deals' => 30, 'status' => 'active']);
        $cat2 = CategoryTarget::create(['name' => 'Construction', 'target_deals' => 20, 'status' => 'active']);

        $response = $this->actingAs($admin)->post(route('users.store'), [
            'name' => 'Multi Employee',
            'email' => 'multi@biznex.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'employee',
            'category_target_ids' => [$cat1->id, $cat2->id],
            'status' => 'active',
        ]);

        $response->assertRedirect(route('users.index'));

        $user = User::where('email', 'multi@biznex.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->categoryTargets->contains('id', $cat1->id));
        $this->assertTrue($user->categoryTargets->contains('id', $cat2->id));
    }

    public function test_employee_sees_all_assigned_category_targets_on_lead_create(): void
    {
        $cat1 = CategoryTarget::create(['name' => 'Real Estate', 'target_deals' => 30, 'status' => 'active']);
        $cat2 = CategoryTarget::create(['name' => 'Travel Companies', 'target_deals' => 25, 'status' => 'active']);
        $cat3 = CategoryTarget::create(['name' => 'Automobile', 'target_deals' => 20, 'status' => 'active']);

        $employee = User::factory()->create(['role' => 'employee']);
        $employee->categoryTargets()->sync([$cat1->id, $cat2->id]);

        $response = $this->actingAs($employee)->get(route('leads.create'));

        $response->assertStatus(200);
        $response->assertSee('Real Estate');
        $response->assertSee('Travel Companies');
        $response->assertDontSee('Automobile');
    }

    public function test_admin_sees_all_active_category_targets_on_lead_create(): void
    {
        CategoryTarget::create(['name' => 'Real Estate', 'target_deals' => 30, 'status' => 'active']);
        CategoryTarget::create(['name' => 'Automobile', 'target_deals' => 20, 'status' => 'active']);

        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('leads.create'));

        $response->assertStatus(200);
        $response->assertSee('Real Estate');
        $response->assertSee('Automobile');
    }

    public function test_lead_created_by_employee_succeeds_with_assigned_category(): void
    {
        $cat1 = CategoryTarget::create(['name' => 'Real Estate', 'target_deals' => 30, 'status' => 'active']);
        $cat2 = CategoryTarget::create(['name' => 'Construction', 'target_deals' => 20, 'status' => 'active']);
        $source = LeadSource::create(['name' => 'WhatsApp', 'icon' => 'fa-brands fa-whatsapp', 'status' => 'active']);

        $employee = User::factory()->create(['role' => 'employee']);
        $employee->categoryTargets()->sync([$cat1->id, $cat2->id]);

        $response = $this->actingAs($employee)->post(route('leads.store'), [
            'name' => 'Prospect John',
            'phone' => '+92 300 1234567',
            'lead_source_id' => $source->id,
            'category_target_id' => $cat2->id,
        ]);

        $this->assertDatabaseHas('leads', [
            'name' => 'Prospect John',
            'user_id' => $employee->id,
            'category_target_id' => $cat2->id,
        ]);
    }

    public function test_lead_created_by_employee_fails_with_unassigned_category(): void
    {
        $cat1 = CategoryTarget::create(['name' => 'Real Estate', 'target_deals' => 30, 'status' => 'active']);
        $unassignedCat = CategoryTarget::create(['name' => 'Automobile', 'target_deals' => 20, 'status' => 'active']);
        $source = LeadSource::create(['name' => 'WhatsApp', 'icon' => 'fa-brands fa-whatsapp', 'status' => 'active']);

        $employee = User::factory()->create(['role' => 'employee']);
        $employee->categoryTargets()->sync([$cat1->id]);

        $response = $this->actingAs($employee)->post(route('leads.store'), [
            'name' => 'Prospect John',
            'phone' => '+92 300 1234567',
            'lead_source_id' => $source->id,
            'category_target_id' => $unassignedCat->id,
        ]);

        $response->assertSessionHasErrors('category_target_id');
    }
}

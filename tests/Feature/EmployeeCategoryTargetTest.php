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

    public function test_admin_can_assign_category_target_to_employee(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = CategoryTarget::create([
            'name' => 'Real Estate',
            'target_deals' => 30,
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->post(route('users.store'), [
            'name' => 'Test Employee',
            'email' => 'employee@biznex.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'employee',
            'category_target_id' => $category->id,
            'status' => 'active',
        ]);

        $response->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'employee@biznex.com',
            'category_target_id' => $category->id,
            'role' => 'employee',
        ]);
    }

    public function test_employee_sees_only_assigned_category_target_on_lead_create(): void
    {
        $category1 = CategoryTarget::create(['name' => 'Real Estate', 'target_deals' => 30, 'status' => 'active']);
        $category2 = CategoryTarget::create(['name' => 'Automobile', 'target_deals' => 20, 'status' => 'active']);

        $employee = User::factory()->create([
            'role' => 'employee',
            'category_target_id' => $category1->id,
        ]);

        $response = $this->actingAs($employee)->get(route('leads.create'));

        $response->assertStatus(200);
        $response->assertSee('Real Estate');
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

    public function test_lead_created_by_employee_uses_assigned_category_target(): void
    {
        $category1 = CategoryTarget::create(['name' => 'Real Estate', 'target_deals' => 30, 'status' => 'active']);
        $category2 = CategoryTarget::create(['name' => 'Automobile', 'target_deals' => 20, 'status' => 'active']);
        $source = LeadSource::create(['name' => 'WhatsApp', 'icon' => 'fa-brands fa-whatsapp', 'status' => 'active']);

        $employee = User::factory()->create([
            'role' => 'employee',
            'category_target_id' => $category1->id,
        ]);

        $response = $this->actingAs($employee)->post(route('leads.store'), [
            'name' => 'Prospect John',
            'phone' => '+92 300 1234567',
            'lead_source_id' => $source->id,
            'category_target_id' => $category2->id, // Even if requested with category2, controller enforces employee's category1
        ]);

        $this->assertDatabaseHas('leads', [
            'name' => 'Prospect John',
            'user_id' => $employee->id,
            'category_target_id' => $category1->id,
        ]);
    }
}

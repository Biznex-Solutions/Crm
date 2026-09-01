<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('password.change'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_change_password_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('password.change'));
        $response->assertStatus(200);
        $response->assertSee('Update Account Password');
    }

    public function test_user_can_change_password_successfully(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-secret-password'),
        ]);

        $response = $this->actingAs($user)->put(route('password.update'), [
            'current_password' => 'old-secret-password',
            'password' => 'new-secret-password-123',
            'password_confirmation' => 'new-secret-password-123',
        ]);

        $response->assertSessionHas('success');
        $this->assertTrue(Hash::check('new-secret-password-123', $user->fresh()->password));
    }

    public function test_user_cannot_change_password_with_incorrect_current_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-secret-password'),
        ]);

        $response = $this->actingAs($user)->put(route('password.update'), [
            'current_password' => 'wrong-password',
            'password' => 'new-secret-password-123',
            'password_confirmation' => 'new-secret-password-123',
        ]);

        $response->assertSessionHasErrors('current_password');
        $this->assertTrue(Hash::check('old-secret-password', $user->fresh()->password));
    }

    public function test_user_cannot_change_password_with_unmatched_confirmation(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-secret-password'),
        ]);

        $response = $this->actingAs($user)->put(route('password.update'), [
            'current_password' => 'old-secret-password',
            'password' => 'new-secret-password-123',
            'password_confirmation' => 'mismatched-password-456',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertTrue(Hash::check('old-secret-password', $user->fresh()->password));
    }

    public function test_user_cannot_change_password_with_same_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-secret-password'),
        ]);

        $response = $this->actingAs($user)->put(route('password.update'), [
            'current_password' => 'old-secret-password',
            'password' => 'old-secret-password',
            'password_confirmation' => 'old-secret-password',
        ]);

        $response->assertSessionHasErrors('password');
    }
}

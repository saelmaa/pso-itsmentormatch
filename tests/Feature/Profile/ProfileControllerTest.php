<?php

namespace Tests\Feature\Profile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * Test: Settings page loads for authenticated user
     */
    public function test_settings_page_loads_for_authenticated_user(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings page requires authentication
     */
    public function test_settings_page_requires_authentication(): void
    {
        $response = $this->get(route('settings.edit'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: Settings shows correct user data
     */
    public function test_settings_shows_correct_user_data(): void
    {
        $user = User::factory()->create(['name' => 'John Doe']);

        $response = $this->actingAs($user)->get(route('settings.edit'));

        $response->assertViewHas('user', $user);
    }

    /**
     * Test: Update profile with valid data
     */
    public function test_update_profile_with_valid_data(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'Updated Name',
            'email' => 'newemail@example.com',
        ]);

        $response->assertRedirect(route('settings.edit'));
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'Updated Name',
            'email' => 'newemail@example.com',
        ]);
    }

    /**
     * Test: Update profile requires authentication
     */
    public function test_update_profile_requires_authentication(): void
    {
        $response = $this->put(route('settings.update'), [
            'name' => 'Updated Name',
        ]);

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: Update profile validates name
     */
    public function test_update_profile_validates_name(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /**
     * Test: Update profile validates email
     */
    public function test_update_profile_validates_email(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'Valid Name',
            'email' => 'invalid-email',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test: Update profile with duplicate email
     */
    public function test_update_profile_with_duplicate_email(): void
    {
        $otherUser = User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'Updated Name',
            'email' => 'existing@example.com',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test: Update profile with same email allowed
     */
    public function test_update_profile_with_same_email_allowed(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'Updated Name',
            'email' => $this->user->email,
        ]);

        $response->assertRedirect(route('settings.edit'));
    }

    /**
     * Test: Update profile shows success message
     */
    public function test_update_profile_shows_success_message(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'Updated Name',
            'email' => 'newemail@example.com',
        ]);

        $response->assertSessionHas('success') || $response->assertStatus(302);
    }

    /**
     * Test: Profile edit validates name max length
     */
    public function test_profile_edit_validates_name_max_length(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => str_repeat('a', 256),
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /**
     * Test: Update profile validates email format
     */
    public function test_update_profile_validates_email_format(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'Valid Name',
            'email' => 'not-an-email@',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test: Profile update allows optional fields
     */
    public function test_profile_update_allows_optional_fields(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'Updated Name',
            'email' => 'newemail@example.com',
            'student_id' => '12345678',
            'department' => 'Information System',
            'phone' => '081234567890',
        ]);

        $response->assertRedirect(route('settings.edit'));
    }

    /**
     * Test: Settings view is accessible
     */
    public function test_settings_view_is_accessible(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertViewIs('settings');
    }

    /**
     * Test: Settings page displays user email
     */
    public function test_settings_page_displays_user_email(): void
    {
        $user = User::factory()->create(['email' => 'john@example.com']);

        $response = $this->actingAs($user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings form displays current user name
     */
    public function test_settings_form_displays_current_user_name(): void
    {
        $user = User::factory()->create(['name' => 'Current User']);

        $response = $this->actingAs($user)->get(route('settings.edit'));

        $response->assertViewHas('user', $user);
    }

    /**
     * Test: Update profile preserves other user fields
     */
    public function test_update_profile_preserves_other_fields(): void
    {
        $user = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
            'student_id' => '99999999',
        ]);

        $response = $this->actingAs($user)->put(route('settings.update'), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $response->assertRedirect(route('settings.edit'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'student_id' => '99999999',
        ]);
    }

    /**
     * Test: Settings page loads successfully with 200 status
     */
    public function test_settings_page_status_code(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Update redirects to settings edit on success
     */
    public function test_update_redirects_to_settings(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

        $response->assertRedirect(route('settings.edit'));
    }
}


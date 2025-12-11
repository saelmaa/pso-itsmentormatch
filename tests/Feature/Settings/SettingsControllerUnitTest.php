<?php

namespace Tests\Feature\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SettingsControllerUnitTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => 'STU001',
            'department' => 'Computer Science',
            'phone' => '1234567890',
            'password' => Hash::make('password123'),
        ]);
    }

    // ==================== EDIT TESTS ====================

    /**
     * Test: Unauthenticated user cannot access settings edit
     */
    public function test_unauthenticated_user_cannot_access_settings_edit(): void
    {
        $response = $this->get(route('settings.edit'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: Authenticated user can access settings edit
     */
    public function test_authenticated_user_can_access_settings_edit(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('settings.edit');
    }

    /**
     * Test: Settings edit shows user data
     */
    public function test_settings_edit_shows_user_data(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertViewHas('user');
        $user = $response->viewData('user');
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
    }

    // ==================== UPDATE TESTS ====================

    /**
     * Test: Unauthenticated user cannot update settings
     */
    public function test_unauthenticated_user_cannot_update_settings(): void
    {
        $response = $this->put(route('settings.update'), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: Settings update validates name is required
     */
    public function test_settings_update_validates_name_is_required(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => '',
            'email' => 'updated@example.com',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /**
     * Test: Settings update validates name max length
     */
    public function test_settings_update_validates_name_max_length(): void
    {
        $longName = str_repeat('a', 256);

        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => $longName,
            'email' => 'updated@example.com',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /**
     * Test: Settings update validates email is required
     */
    public function test_settings_update_validates_email_is_required(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'John Doe',
            'email' => '',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test: Settings update validates email format
     */
    public function test_settings_update_validates_email_format(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'John Doe',
            'email' => 'invalid-email',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test: Settings update validates email is unique
     */
    public function test_settings_update_validates_email_is_unique(): void
    {
        $otherUser = User::factory()->create(['email' => 'other@example.com']);

        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'John Doe',
            'email' => 'other@example.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test: Settings update allows same email as current user
     */
    public function test_settings_update_allows_same_email(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertRedirect(route('settings.edit'));
    }

    /**
     * Test: Settings update updates name successfully
     */
    public function test_settings_update_updates_name_successfully(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'Jane Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertRedirect(route('settings.edit'));
        $this->user->refresh();
        $this->assertEquals('Jane Doe', $this->user->name);
    }

    /**
     * Test: Settings update updates email successfully
     */
    public function test_settings_update_updates_email_successfully(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'John Doe',
            'email' => 'newemail@example.com',
        ]);

        $response->assertRedirect(route('settings.edit'));
        $this->user->refresh();
        $this->assertEquals('newemail@example.com', $this->user->email);
    }

    /**
     * Test: Settings update validates student id max length
     */
    public function test_settings_update_validates_student_id_max_length(): void
    {
        $longId = str_repeat('a', 21);

        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => $longId,
        ]);

        $response->assertSessionHasErrors('student_id');
    }

    /**
     * Test: Settings update allows null phone
     */
    public function test_settings_update_allows_null_phone(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => null,
        ]);

        $response->assertRedirect(route('settings.edit'));
    }

    /**
     * Test: Settings update updates phone
     */
    public function test_settings_update_updates_phone(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '9876543210',
        ]);

        $response->assertRedirect(route('settings.edit'));
        $this->user->refresh();
        $this->assertEquals('9876543210', $this->user->phone);
    }

    /**
     * Test: Settings update validates phone max length
     */
    public function test_settings_update_validates_phone_max_length(): void
    {
        $longPhone = str_repeat('1', 21);

        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => $longPhone,
        ]);

        $response->assertSessionHasErrors('phone');
    }

    /**
     * Test: Settings update validates password is min 6
     */
    public function test_settings_update_validates_new_password_min_length(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'new_password' => 'short',
            'new_password_confirmation' => 'short',
        ]);

        $response->assertSessionHasErrors('new_password');
    }

    /**
     * Test: Settings update validates password confirmation
     */
    public function test_settings_update_validates_password_confirmation(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'differentpassword',
        ]);

        $response->assertSessionHasErrors('new_password');
    }

    /**
     * Test: Settings update hashes new password
     */
    public function test_settings_update_hashes_new_password(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('settings.edit'));
        $this->user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $this->user->password));
    }

    /**
     * Test: Settings update allows omitting new password
     */
    public function test_settings_update_allows_omitting_new_password(): void
    {
        $originalPassword = $this->user->password;

        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertRedirect(route('settings.edit'));
        $this->user->refresh();
        $this->assertEquals($originalPassword, $this->user->password);
    }

    /**
     * Test: Settings update shows success message
     */
    public function test_settings_update_shows_success_message(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'Jane Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertSessionHas('success');
    }

    /**
     * Test: Settings update redirects to settings edit
     */
    public function test_settings_update_redirects_to_settings_edit(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'Jane Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertRedirect(route('settings.edit'));
    }

    /**
     * Test: Settings update updates multiple fields at once
     */
    public function test_settings_update_updates_multiple_fields_at_once(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'student_id' => 'STU999',
            'department' => 'Physics',
            'phone' => '5555555555',
        ]);

        $response->assertRedirect(route('settings.edit'));
        $this->user->refresh();
        $this->assertEquals('Jane Doe', $this->user->name);
        $this->assertEquals('jane@example.com', $this->user->email);
        $this->assertEquals('STU999', $this->user->student_id);
        $this->assertEquals('Physics', $this->user->department);
        $this->assertEquals('5555555555', $this->user->phone);
    }

    /**
     * Test: Settings update is case-insensitive for email
     */
    public function test_settings_update_email_case_insensitive(): void
    {
        $response = $this->actingAs($this->user)->put(route('settings.update'), [
            'name' => 'John Doe',
            'email' => 'JOHN@EXAMPLE.COM',
        ]);

        // Email update should handle case
        $response->assertRedirect(route('settings.edit'));
    }
}

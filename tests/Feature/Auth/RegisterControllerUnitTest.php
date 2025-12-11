<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterControllerUnitTest extends TestCase
{
    use RefreshDatabase;

    // ==================== SHOW REGISTRATION FORM TESTS ====================

    /**
     * Test: Guest can access registration form
     */
    public function test_guest_can_access_registration_form(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    /**
     * Test: Authenticated user is redirected from registration form
     */
    public function test_authenticated_user_is_redirected_from_registration_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('register'));

        // Should be redirected because of 'guest' middleware to dashboard
        $response->assertRedirect(route('dashboard'));
    }

    // ==================== REGISTER TESTS ====================

    /**
     * Test: Register with valid data creates user
     */
    public function test_register_with_valid_data_creates_user(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => 'STU001',
            'department' => 'Computer Science',
            'phone' => '1234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => 'STU001',
            'department' => 'Computer Science',
        ]);
    }

    /**
     * Test: Register validates name is required
     */
    public function test_register_validates_name_is_required(): void
    {
        $response = $this->post(route('register'), [
            'name' => '',
            'email' => 'john@example.com',
            'student_id' => 'STU001',
            'department' => 'CS',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /**
     * Test: Register validates name max length
     */
    public function test_register_validates_name_max_length(): void
    {
        $longName = str_repeat('a', 256);

        $response = $this->post(route('register'), [
            'name' => $longName,
            'email' => 'john@example.com',
            'student_id' => 'STU001',
            'department' => 'CS',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /**
     * Test: Register validates email is required
     */
    public function test_register_validates_email_is_required(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => '',
            'student_id' => 'STU001',
            'department' => 'CS',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test: Register validates email format
     */
    public function test_register_validates_email_format(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'student_id' => 'STU001',
            'department' => 'CS',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test: Register validates email is unique
     */
    public function test_register_validates_email_is_unique(): void
    {
        User::factory()->create(['email' => 'john@example.com']);

        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => 'STU002',
            'department' => 'CS',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test: Register validates student_id is required
     */
    public function test_register_validates_student_id_is_required(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '',
            'department' => 'CS',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('student_id');
    }

    /**
     * Test: Register validates student_id is unique
     */
    public function test_register_validates_student_id_is_unique(): void
    {
        User::factory()->create(['student_id' => 'STU001']);

        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => 'STU001',
            'department' => 'CS',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('student_id');
    }

    /**
     * Test: Register validates student_id max length
     */
    public function test_register_validates_student_id_max_length(): void
    {
        $longId = str_repeat('a', 21);

        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => $longId,
            'department' => 'CS',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('student_id');
    }

    /**
     * Test: Register validates department is required
     */
    public function test_register_validates_department_is_required(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => 'STU001',
            'department' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('department');
    }

    /**
     * Test: Register validates department max length
     */
    public function test_register_validates_department_max_length(): void
    {
        $longDept = str_repeat('a', 256);

        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => 'STU001',
            'department' => $longDept,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('department');
    }

    /**
     * Test: Register validates password is required
     */
    public function test_register_validates_password_is_required(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => 'STU001',
            'department' => 'CS',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test: Register validates password confirmation
     */
    public function test_register_validates_password_confirmation(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => 'STU001',
            'department' => 'CS',
            'password' => 'password123',
            'password_confirmation' => 'different_password',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test: Register validates password minimum length
     */
    public function test_register_validates_password_minimum_length(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => 'STU001',
            'department' => 'CS',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test: Register allows null phone
     */
    public function test_register_allows_null_phone(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => 'STU001',
            'department' => 'CS',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/');
    }

    /**
     * Test: Register stores phone when provided
     */
    public function test_register_stores_phone_when_provided(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => 'STU001',
            'department' => 'CS',
            'phone' => '5551234567',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'phone' => '5551234567',
        ]);
    }

    /**
     * Test: Register validates phone max length
     */
    public function test_register_validates_phone_max_length(): void
    {
        $longPhone = str_repeat('1', 21);

        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => 'STU001',
            'department' => 'CS',
            'phone' => $longPhone,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('phone');
    }

    /**
     * Test: Register redirects to home on success
     */
    public function test_register_redirects_to_home_on_success(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => 'STU001',
            'department' => 'CS',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/');
    }

    /**
     * Test: Register shows success message
     */
    public function test_register_shows_success_message(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => 'STU001',
            'department' => 'CS',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHas('success');
    }

    /**
     * Test: Register hashes password
     */
    public function test_register_hashes_password(): void
    {
        $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => 'STU001',
            'department' => 'CS',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'john@example.com')->first();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('password123', $user->password));
    }

    /**
     * Test: Authenticated user cannot post register
     */
    public function test_authenticated_user_cannot_post_register(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => 'STU001',
            'department' => 'CS',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Should be redirected by guest middleware to dashboard
        $response->assertRedirect(route('dashboard'));
    }
}

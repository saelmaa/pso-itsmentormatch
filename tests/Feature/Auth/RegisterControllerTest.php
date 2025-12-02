<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test show registration form
     */
    public function test_registration_form_can_be_displayed(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    /**
     * Test registration with valid data
     */
    public function test_new_user_can_register_with_valid_data(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'phone' => '+62 812 3456 7890',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];

        $response = $this->post('/register', $userData);

        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'Registration successful. Please log in.');
    }

    /**
     * Test registration fails with missing required fields
     */
    public function test_registration_fails_with_missing_name(): void
    {
        $userData = [
            'name' => '',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];

        $response = $this->post('/register', $userData);

        $response->assertSessionHasErrors(['name']);
    }

    /**
     * Test registration fails with missing email
     */
    public function test_registration_fails_with_missing_email(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => '',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];

        $response = $this->post('/register', $userData);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test registration fails with invalid email format
     */
    public function test_registration_fails_with_invalid_email(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];

        $response = $this->post('/register', $userData);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test registration fails with missing student_id
     */
    public function test_registration_fails_with_missing_student_id(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];

        $response = $this->post('/register', $userData);

        $response->assertSessionHasErrors(['student_id']);
    }

    /**
     * Test registration fails with missing department
     */
    public function test_registration_fails_with_missing_department(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => '',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];

        $response = $this->post('/register', $userData);

        $response->assertSessionHasErrors(['department']);
    }

    /**
     * Test registration fails with missing password
     */
    public function test_registration_fails_with_missing_password(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => '',
            'password_confirmation' => '',
        ];

        $response = $this->post('/register', $userData);

        $response->assertSessionHasErrors(['password']);
    }

    /**
     * Test registration fails with short password
     */
    public function test_registration_fails_with_password_less_than_8_characters(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => 'Pass123',
            'password_confirmation' => 'Pass123',
        ];

        $response = $this->post('/register', $userData);

        $response->assertSessionHasErrors(['password']);
    }

    /**
     * Test registration fails with unmatched passwords
     */
    public function test_registration_fails_with_unmatched_passwords(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password456',
        ];

        $response = $this->post('/register', $userData);

        $response->assertSessionHasErrors(['password']);
    }

    /**
     * Test registration fails with duplicate email
     */
    public function test_registration_fails_with_duplicate_email(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];

        // First registration should succeed
        $this->post('/register', $userData);

        // Second registration with same email should fail
        $userData['student_id'] = '05111940000002';
        $response = $this->post('/register', $userData);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test registration fails with duplicate student_id
     */
    public function test_registration_fails_with_duplicate_student_id(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];

        // First registration should succeed
        $this->post('/register', $userData);

        // Second registration with same student_id should fail
        $userData['email'] = 'jane@example.com';
        $response = $this->post('/register', $userData);

        $response->assertSessionHasErrors(['student_id']);
    }

    /**
     * Test registration with phone number optional
     */
    public function test_registration_succeeds_without_phone_number(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];

        $response = $this->post('/register', $userData);

        $response->assertRedirect('/');
        $response->assertSessionHas('success');
    }

    /**
     * Test registered user redirects to home page
     */
    public function test_registered_user_redirects_to_home(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];

        $response = $this->post('/register', $userData);

        $response->assertRedirect('/');
    }

    /**
     * Test authenticated user cannot register again
     */
    public function test_authenticated_user_cannot_register(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/register');

        $response->assertRedirect('/');
    }

    /**
     * Test name field accepts max 255 characters
     */
    public function test_registration_fails_with_name_exceeding_255_characters(): void
    {
        $userData = [
            'name' => str_repeat('a', 256),
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];

        $response = $this->post('/register', $userData);

        $response->assertSessionHasErrors(['name']);
    }

    /**
     * Test student_id field accepts max 20 characters
     */
    public function test_registration_fails_with_student_id_exceeding_20_characters(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => str_repeat('a', 21),
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];

        $response = $this->post('/register', $userData);

        $response->assertSessionHasErrors(['student_id']);
    }

    /**
     * Test phone field accepts max 20 characters
     */
    public function test_registration_fails_with_phone_exceeding_20_characters(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'phone' => str_repeat('1', 21),
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];

        $response = $this->post('/register', $userData);

        $response->assertSessionHasErrors(['phone']);
    }
}

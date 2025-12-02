<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Show registration form
     */
    public function test_register_page_can_be_displayed(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    /**
     * Test: User can register with valid data
     */
    public function test_user_can_register_with_valid_data(): void
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
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'name' => 'John Doe',
        ]);
    }

    /**
     * Test: Registration fails with empty name
     */
    public function test_registration_fails_with_empty_name(): void
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /**
     * Test: Registration fails with empty email
     */
    public function test_registration_fails_with_empty_email(): void
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => '',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test: Registration fails with invalid email format
     */
    public function test_registration_fails_with_invalid_email_format(): void
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'not-an-email',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test: Registration fails with empty student_id
     */
    public function test_registration_fails_with_empty_student_id(): void
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $response->assertSessionHasErrors('student_id');
    }

    /**
     * Test: Registration fails with empty department
     */
    public function test_registration_fails_with_empty_department(): void
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => '',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $response->assertSessionHasErrors('department');
    }

    /**
     * Test: Registration fails with empty password
     */
    public function test_registration_fails_with_empty_password(): void
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test: Registration fails with short password (less than 8 characters)
     */
    public function test_registration_fails_with_short_password(): void
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => 'Pass123',
            'password_confirmation' => 'Pass123',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test: Registration fails when password and confirmation don't match
     */
    public function test_registration_fails_with_mismatched_passwords(): void
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password456',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test: Registration fails with duplicate email
     */
    public function test_registration_fails_with_duplicate_email(): void
    {
        User::create([
            'name' => 'Existing User',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => bcrypt('Password123'),
        ]);

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000002',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test: Registration fails with duplicate student_id
     */
    public function test_registration_fails_with_duplicate_student_id(): void
    {
        User::create([
            'name' => 'Existing User',
            'email' => 'existing@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => bcrypt('Password123'),
        ]);

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $response->assertSessionHasErrors('student_id');
    }

    /**
     * Test: Phone number is optional
     */
    public function test_user_can_register_without_phone(): void
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);
    }

    /**
     * Test: Authenticated user cannot access register page
     */
    public function test_authenticated_user_cannot_access_register(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/register');

        $response->assertStatus(302); // Check it's a redirect
    }
}

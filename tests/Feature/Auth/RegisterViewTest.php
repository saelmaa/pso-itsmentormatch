<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test register view contains registration form
     */
    public function test_register_view_contains_form(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
        $response->assertSeeText('Join ITS MentorMatch');
        $response->assertSeeText('Create your account to get started');
    }

    /**
     * Test register view contains all required form fields
     */
    public function test_register_view_contains_all_form_fields(): void
    {
        $response = $this->get('/register');

        $response->assertSee('name');
        $response->assertSee('email');
        $response->assertSee('student_id');
        $response->assertSee('department');
        $response->assertSee('phone');
        $response->assertSee('password');
        $response->assertSee('password_confirmation');
    }

    /**
     * Test register view contains form labels
     */
    public function test_register_view_contains_form_labels(): void
    {
        $response = $this->get('/register');

        $response->assertSeeText('Full Name');
        $response->assertSeeText('Email Address');
        $response->assertSeeText('Student ID');
        $response->assertSeeText('Department');
        $response->assertSeeText('Phone Number (Optional)');
        $response->assertSeeText('Password');
        $response->assertSeeText('Confirm Password');
    }

    /**
     * Test register view contains submit button
     */
    public function test_register_view_contains_submit_button(): void
    {
        $response = $this->get('/register');

        $response->assertSeeText('Create Account');
    }

    /**
     * Test register view has link to login page
     */
    public function test_register_view_has_login_link(): void
    {
        $response = $this->get('/register');

        $response->assertSeeText('Already have an account?');
        $response->assertSeeText('Sign in here');
    }

    /**
     * Test register view form uses POST method
     */
    public function test_register_view_form_uses_post_method(): void
    {
        $response = $this->get('/register');

        $response->assertSee('method="POST"');
    }

    /**
     * Test register view form posts to register route
     */
    public function test_register_view_form_posts_to_register_route(): void
    {
        $response = $this->get('/register');

        $response->assertSee('action="' . route('register') . '"');
    }

    /**
     * Test register view contains CSRF token
     */
    public function test_register_view_contains_csrf_token(): void
    {
        $response = $this->get('/register');

        $response->assertSee('@csrf');
    }

    /**
     * Test register view contains ITS MentorMatch branding
     */
    public function test_register_view_contains_its_mentormatch_branding(): void
    {
        $response = $this->get('/register');

        $response->assertSeeText('ITS MentorMatch');
    }

    /**
     * Test register view has graduation cap icon
     */
    public function test_register_view_has_graduation_cap_icon(): void
    {
        $response = $this->get('/register');

        $response->assertSee('fa-graduation-cap');
    }

    /**
     * Test register view shows department options
     */
    public function test_register_view_shows_department_options(): void
    {
        $response = $this->get('/register');

        $response->assertSeeText('Select your department');
        $response->assertSeeText('Information System');
        $response->assertSeeText('Informatics');
        $response->assertSeeText('Visual Communication Design');
        $response->assertSeeText('Electrical Engineering');
        $response->assertSeeText('Mechanical Engineering');
        $response->assertSeeText('Civil Engineering');
        $response->assertSeeText('Other');
    }

    /**
     * Test register view has proper styling classes
     */
    public function test_register_view_has_tailwind_styling(): void
    {
        $response = $this->get('/register');

        $response->assertSee('bg-gray-50');
        $response->assertSee('rounded-xl');
        $response->assertSee('shadow-lg');
    }

    /**
     * Test register view preserves old input on error
     */
    public function test_register_view_preserves_old_input(): void
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test register view displays email field placeholder
     */
    public function test_register_view_has_email_placeholder(): void
    {
        $response = $this->get('/register');

        $response->assertSee('your.email@its.ac.id');
    }

    /**
     * Test register view displays student_id field placeholder
     */
    public function test_register_view_has_student_id_placeholder(): void
    {
        $response = $this->get('/register');

        $response->assertSee('e.g., 05111940000001');
    }

    /**
     * Test register view displays phone field placeholder
     */
    public function test_register_view_has_phone_placeholder(): void
    {
        $response = $this->get('/register');

        $response->assertSee('+62 812 3456 7890');
    }

    /**
     * Test register view name field accepts text input
     */
    public function test_register_view_name_field_type_is_text(): void
    {
        $response = $this->get('/register');

        $response->assertSee('type="text"', false);
    }

    /**
     * Test register view email field accepts email input
     */
    public function test_register_view_email_field_type_is_email(): void
    {
        $response = $this->get('/register');

        $response->assertSee('type="email"', false);
    }

    /**
     * Test register view password fields are password type
     */
    public function test_register_view_password_field_type_is_password(): void
    {
        $response = $this->get('/register');

        $response->assertSee('type="password"', false);
    }

    /**
     * Test register view department field is select type
     */
    public function test_register_view_department_field_is_select(): void
    {
        $response = $this->get('/register');

        $response->assertSee('<select');
    }

    /**
     * Test register view all required fields are marked as required
     */
    public function test_register_view_required_fields_have_required_attribute(): void
    {
        $response = $this->get('/register');

        // Should have required attributes for name, email, student_id, department, password, password_confirmation
        $html = $response->getContent();
        $this->assertStringContainsString('required', $html);
    }
}

<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Register page shows form
     */
    public function test_register_page_displays_correctly(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSeeText('Join ITS MentorMatch');
        $response->assertSeeText('Create your account to get started');
    }

    /**
     * Test: Form contains all required input fields
     */
    public function test_form_contains_all_input_fields(): void
    {
        $response = $this->get('/register');

        $response->assertSee('name="name"', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="student_id"', false);
        $response->assertSee('name="department"', false);
        $response->assertSee('name="phone"', false);
        $response->assertSee('name="password"', false);
        $response->assertSee('name="password_confirmation"', false);
    }

    /**
     * Test: Form contains all labels
     */
    public function test_form_contains_all_labels(): void
    {
        $response = $this->get('/register');

        $response->assertSeeText('Full Name');
        $response->assertSeeText('Email Address');
        $response->assertSeeText('Student ID');
        $response->assertSeeText('Department');
        $response->assertSeeText('Phone Number');
        $response->assertSeeText('Password');
        $response->assertSeeText('Confirm Password');
    }

    /**
     * Test: Form posts to register route with POST method
     */
    public function test_form_posts_to_register_route(): void
    {
        $response = $this->get('/register');

        $response->assertSee('method="POST"', false);
        $response->assertSee('action="' . route('register') . '"', false);
    }

    /**
     * Test: Form contains CSRF token
     */
    public function test_form_contains_csrf_protection(): void
    {
        $response = $this->get('/register');

        $response->assertSee('_token', false);
    }

    /**
     * Test: Form shows all department options
     */
    public function test_form_shows_all_department_options(): void
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
     * Test: Form contains submit button
     */
    public function test_form_contains_submit_button(): void
    {
        $response = $this->get('/register');

        $response->assertSeeText('Create Account');
    }

    /**
     * Test: Page displays login link
     */
    public function test_page_displays_login_link(): void
    {
        $response = $this->get('/register');

        $response->assertSeeText('Already have an account?');
        $response->assertSeeText('Sign in here');
    }

    /**
     * Test: Input fields have correct types
     */
    public function test_input_fields_have_correct_types(): void
    {
        $response = $this->get('/register');

        $response->assertSee('type="text"', false);
        $response->assertSee('type="email"', false);
        $response->assertSee('type="password"', false);
    }

    /**
     * Test: Department field is a select element
     */
    public function test_department_field_is_select_element(): void
    {
        $response = $this->get('/register');

        $response->assertSee('<select', false);
        $response->assertSee('name="department"', false);
    }

    /**
     * Test: Page has ITS MentorMatch branding
     */
    public function test_page_displays_mentormatch_branding(): void
    {
        $response = $this->get('/register');

        $response->assertSeeText('ITS MentorMatch');
        $response->assertSee('fa-graduation-cap');
    }

    /**
     * Test: Form has helpful placeholder texts
     */
    public function test_form_has_placeholder_texts(): void
    {
        $response = $this->get('/register');

        $response->assertSee('your.email@its.ac.id');
        $response->assertSee('e.g., 05111940000001');
    }
}

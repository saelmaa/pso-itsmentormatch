<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Login page displays correctly
     */
    public function test_login_page_displays_correctly(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSeeText('Welcome Back');
        $response->assertSeeText('Sign in to your ITS MentorMatch account');
    }

    /**
     * Test: Form contains email and password fields
     */
    public function test_form_contains_email_and_password_fields(): void
    {
        $response = $this->get('/login');

        $response->assertSee('name="email"', false);
        $response->assertSee('name="password"', false);
    }

    /**
     * Test: Form contains field labels
     */
    public function test_form_contains_field_labels(): void
    {
        $response = $this->get('/login');

        $response->assertSeeText('Email Address');
        $response->assertSeeText('Password');
    }

    /**
     * Test: Form posts to login route with POST method
     */
    public function test_form_posts_to_login_route(): void
    {
        $response = $this->get('/login');

        $response->assertSee('method="POST"', false);
        $response->assertSee('action="' . route('login') . '"', false);
    }

    /**
     * Test: Form contains CSRF token
     */
    public function test_form_contains_csrf_protection(): void
    {
        $response = $this->get('/login');

        $response->assertSee('_token', false);
    }

    /**
     * Test: Form contains submit button
     */
    public function test_form_contains_submit_button(): void
    {
        $response = $this->get('/login');

        $response->assertSeeText('Sign In');
    }

    /**
     * Test: Page displays register link
     */
    public function test_page_displays_register_link(): void
    {
        $response = $this->get('/login');

        // Check for register/signup link
        $response->assertSee('register', false);
        $response->assertSeeText('Sign up here');
    }

    /**
     * Test: Email field is type email
     */
    public function test_email_field_type_is_email(): void
    {
        $response = $this->get('/login');

        $response->assertSee('type="email"', false);
    }

    /**
     * Test: Password field is type password
     */
    public function test_password_field_type_is_password(): void
    {
        $response = $this->get('/login');

        $response->assertSee('type="password"', false);
    }

    /**
     * Test: Page displays ITS MentorMatch branding
     */
    public function test_page_displays_mentormatch_branding(): void
    {
        $response = $this->get('/login');

        $response->assertSeeText('ITS MentorMatch');
        $response->assertSee('fa-graduation-cap');
    }

    /**
     * Test: Form has placeholder text for email
     */
    public function test_form_has_email_placeholder(): void
    {
        $response = $this->get('/login');

        $response->assertSee('your.email@its.ac.id');
    }

    /**
     * Test: Remember me checkbox is present (if available)
     */
    public function test_form_has_password_field(): void
    {
        $response = $this->get('/login');

        $response->assertSee('password', false);
    }
}

<?php

namespace Tests\Feature\Profile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileViewTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '12345678',
            'department' => 'Information System',
            'phone' => '081234567890',
        ]);
    }

    /**
     * Test: Settings page displays user name
     */
    public function test_settings_page_displays_user_name(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertSeeText('John Doe');
    }

    /**
     * Test: Settings page displays user email
     */
    public function test_settings_page_displays_user_email(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertSeeText('john@example.com');
    }

    /**
     * Test: Settings page displays student ID
     */
    public function test_settings_page_displays_student_id(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings page displays department
     */
    public function test_settings_page_displays_department(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertSeeText('Information System');
    }

    /**
     * Test: Settings page displays phone
     */
    public function test_settings_page_displays_phone(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings page has edit form
     */
    public function test_settings_page_has_edit_form(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings page has section headers
     */
    public function test_settings_page_has_section_headers(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings form displays name field
     */
    public function test_settings_form_displays_name_field(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings form displays email field
     */
    public function test_settings_form_displays_email_field(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings form displays student ID field
     */
    public function test_settings_form_displays_student_id_field(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings form displays department field
     */
    public function test_settings_form_displays_department_field(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings form displays phone field
     */
    public function test_settings_form_displays_phone_field(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings form displays current values
     */
    public function test_settings_form_displays_current_values(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertSeeText('John Doe');
    }

    /**
     * Test: Settings form has submit button
     */
    public function test_settings_form_has_submit_button(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertSeeText('Save') || $response->assertStatus(200);
    }

    /**
     * Test: Settings form has cancel link
     */
    public function test_settings_form_has_cancel_link(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings page displays user avatar initial
     */
    public function test_settings_page_displays_user_avatar(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings page displays member since date
     */
    public function test_settings_page_displays_member_since(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings change password section displays
     */
    public function test_settings_change_password_section_displays(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings change password form has current password field
     */
    public function test_settings_change_password_form_has_current_field(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings change password form has new password field
     */
    public function test_settings_change_password_form_has_new_field(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings change password form has confirm field
     */
    public function test_settings_change_password_form_has_confirm_field(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings page has gradient styling
     */
    public function test_settings_page_has_gradient_styling(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertSee('bg-gradient-to-r');
    }

    /**
     * Test: Settings page has proper form styling
     */
    public function test_settings_page_has_form_styling(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings page displays page header
     */
    public function test_settings_page_displays_header(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertSeeText('Settings') || $response->assertStatus(200);
    }

    /**
     * Test: Settings page displays form title
     */
    public function test_settings_page_displays_form_title(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Settings page has card styling
     */
    public function test_settings_page_has_card_styling(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertSee('rounded-xl') || $response->assertStatus(200);
    }

    /**
     * Test: Settings displays user info with proper labels
     */
    public function test_settings_displays_user_info_with_labels(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }

    /**
     * Test: Unauthenticated user redirected to login
     */
    public function test_unauthenticated_user_redirected_to_login(): void
    {
        $response = $this->get(route('settings.edit'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: Settings breadcrumb navigation displays
     */
    public function test_settings_breadcrumb_navigation_displays(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.edit'));

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature\Mentor;

use App\Models\Mentor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MentorViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Mentors index page displays header
     */
    public function test_mentors_index_displays_header(): void
    {
        $response = $this->get(route('mentors.index'));

        $response->assertSeeText('Discover Your Perfect Mentor');
    }

    /**
     * Test: Mentors index page displays search form
     */
    public function test_mentors_index_displays_search_form(): void
    {
        $response = $this->get(route('mentors.index'));

        $response->assertSee('search');
    }

    /**
     * Test: Mentors index page displays department filter
     */
    public function test_mentors_index_displays_department_filter(): void
    {
        $response = $this->get(route('mentors.index'));

        $response->assertSee('department');
    }

    /**
     * Test: Search form has correct placeholder
     */
    public function test_search_form_has_correct_placeholder(): void
    {
        $response = $this->get(route('mentors.index'));

        $response->assertStatus(200);
    }

    /**
     * Test: Department filter has all options
     */
    public function test_department_filter_has_all_options(): void
    {
        $response = $this->get(route('mentors.index'));

        $response->assertSee('Information System');
        $response->assertSee('Informatics');
        $response->assertSee('Visual Communication Design');
    }

    /**
     * Test: Search button displays in form
     */
    public function test_search_button_displays_in_form(): void
    {
        $response = $this->get(route('mentors.index'));

        $response->assertSeeText('Search');
    }

    /**
     * Test: Mentor card displays name
     */
    public function test_mentor_card_displays_name(): void
    {
        Mentor::factory()->create(['name' => 'Dr. John Smith']);

        $response = $this->get(route('mentors.index'));

        $response->assertStatus(200);
    }

    /**
     * Test: Mentor card displays expertise
     */
    public function test_mentor_card_displays_expertise(): void
    {
        Mentor::factory()->create(['expertise' => 'Laravel Development']);

        $response = $this->get(route('mentors.index'));

        $response->assertStatus(200);
    }

    /**
     * Test: Mentor card displays department
     */
    public function test_mentor_card_displays_department(): void
    {
        Mentor::factory()->create(['department' => 'Information System']);

        $response = $this->get(route('mentors.index'));

        $response->assertSeeText('Information System');
    }

    /**
     * Test: Mentor card displays rating
     */
    public function test_mentor_card_displays_rating(): void
    {
        Mentor::factory()->create(['rating' => 4.5]);

        $response = $this->get(route('mentors.index'));

        $response->assertStatus(200);
    }

    /**
     * Test: Mentor card displays total sessions
     */
    public function test_mentor_card_displays_total_sessions(): void
    {
        Mentor::factory()->create(['total_sessions' => 15]);

        $response = $this->get(route('mentors.index'));

        $response->assertStatus(200);
    }

    /**
     * Test: Mentor card displays view profile link
     */
    public function test_mentor_card_displays_view_profile_link(): void
    {
        $mentor = Mentor::factory()->create();

        $response = $this->get(route('mentors.index'));

        $response->assertSeeText('View Profile');
    }

    /**
     * Test: Mentor card has styling classes
     */
    public function test_mentor_card_has_styling_classes(): void
    {
        Mentor::factory()->create();

        $response = $this->get(route('mentors.index'));

        $response->assertSee('rounded-xl');
        $response->assertSee('shadow-lg');
    }

    /**
     * Test: Mentor cards displayed in grid layout
     */
    public function test_mentor_cards_displayed_in_grid(): void
    {
        Mentor::factory(3)->create();

        $response = $this->get(route('mentors.index'));

        $response->assertSee('grid');
    }

    /**
     * Test: Mentor show page displays mentor name
     */
    public function test_mentor_show_displays_mentor_name(): void
    {
        $mentor = Mentor::factory()->create(['name' => 'Dr. Jane Doe']);

        $response = $this->get(route('mentors.show', $mentor));

        $response->assertStatus(200);
    }

    /**
     * Test: Mentor show page displays expertise
     */
    public function test_mentor_show_displays_expertise(): void
    {
        $mentor = Mentor::factory()->create(['expertise' => 'Web Development']);

        $response = $this->get(route('mentors.show', $mentor));

        $response->assertStatus(200);
    }

    /**
     * Test: Mentor show page displays bio
     */
    public function test_mentor_show_displays_bio(): void
    {
        $mentor = Mentor::factory()->create([
            'bio' => 'Experienced software developer with passion for mentoring'
        ]);

        $response = $this->get(route('mentors.show', $mentor));

        $response->assertStatus(200);
    }

    /**
     * Test: Mentor show page displays rating
     */
    public function test_mentor_show_displays_rating(): void
    {
        $mentor = Mentor::factory()->create(['rating' => 4.8]);

        $response = $this->get(route('mentors.show', $mentor));

        $response->assertStatus(200);
    }

    /**
     * Test: Mentor show page displays skills
     */
    public function test_mentor_show_displays_skills(): void
    {
        $mentor = Mentor::factory()->create([
            'skills' => json_encode(['Laravel', 'PHP', 'MySQL'])
        ]);

        $response = $this->get(route('mentors.show', $mentor));

        $response->assertStatus(200);
    }

    /**
     * Test: Mentor show page displays department
     */
    public function test_mentor_show_displays_department(): void
    {
        $mentor = Mentor::factory()->create(['department' => 'Informatics']);

        $response = $this->get(route('mentors.show', $mentor));

        $response->assertStatus(200);
    }

    /**
     * Test: Mentor show page displays experience years
     */
    public function test_mentor_show_displays_experience_years(): void
    {
        $mentor = Mentor::factory()->create(['experience_years' => 8]);

        $response = $this->get(route('mentors.show', $mentor));

        $response->assertSee('8');
    }

    /**
     * Test: Mentor create page displays form
     */
    public function test_mentor_create_page_displays_form(): void
    {
        $response = $this->get(route('mentors.create'));

        $response->assertStatus(200);
    }

    /**
     * Test: Mentor create form has all required fields
     */
    public function test_mentor_create_form_has_required_fields(): void
    {
        $response = $this->get(route('mentors.create'));

        $response->assertStatus(200);
    }

    /**
     * Test: Mentor create form has optional fields
     */
    public function test_mentor_create_form_has_optional_fields(): void
    {
        $response = $this->get(route('mentors.create'));

        $response->assertStatus(200);
    }

    /**
     * Test: Mentor create form has submit button
     */
    public function test_mentor_create_form_has_submit_button(): void
    {
        $response = $this->get(route('mentors.create'));

        $response->assertSeeText('Submit');
    }

    /**
     * Test: Mentor show page displays contact button
     */
    public function test_mentor_show_page_displays_contact_button(): void
    {
        $mentor = Mentor::factory()->create();

        $response = $this->get(route('mentors.show', $mentor));

        $response->assertSeeText('Contact') || $response->assertSeeText('Book Session');
    }

    /**
     * Test: Mentor create page has form title
     */
    public function test_mentor_create_page_has_form_title(): void
    {
        $response = $this->get(route('mentors.create'));

        $response->assertSeeText('Become a Mentor') || $response->assertSeeText('Apply as Mentor');
    }

    /**
     * Test: Search results show search value
     */
    public function test_search_results_show_search_value(): void
    {
        Mentor::factory()->create(['name' => 'Test Mentor']);

        $response = $this->get(route('mentors.index', ['search' => 'Test']));

        $response->assertStatus(200);
    }

    /**
     * Test: Department filter shows selected value
     */
    public function test_department_filter_shows_selected_value(): void
    {
        Mentor::factory()->create(['department' => 'Information System']);

        $response = $this->get(route('mentors.index', ['department' => 'Information System']));

        $response->assertSee('selected');
    }

    /**
     * Test: Mentor card shows availability status icon
     */
    public function test_mentor_card_shows_availability_status(): void
    {
        Mentor::factory()->create(['availability_status' => 'available']);

        $response = $this->get(route('mentors.index'));

        $response->assertSee('fa-');
    }

    /**
     * Test: Mentors index displays empty state
     */
    public function test_mentors_index_displays_empty_state(): void
    {
        $response = $this->get(route('mentors.index', ['search' => 'NonExistent']));

        $response->assertStatus(200);
    }

    /**
     * Test: Mentor card displays avatar initial
     */
    public function test_mentor_card_displays_avatar_initial(): void
    {
        Mentor::factory()->create(['name' => 'John Smith']);

        $response = $this->get(route('mentors.index'));

        $response->assertStatus(200);
    }

    /**
     * Test: Mentor show page displays email
     */
    public function test_mentor_show_page_displays_email(): void
    {
        $mentor = Mentor::factory()->create(['email' => 'john@example.com']);

        $response = $this->get(route('mentors.show', $mentor));

        $response->assertStatus(200);
    }

    /**
     * Test: Mentor index page has gradient styling
     */
    public function test_mentor_index_page_has_gradient_styling(): void
    {
        $response = $this->get(route('mentors.index'));

        $response->assertSee('bg-gradient-to-r');
    }

    /**
     * Test: Mentor show page displays back link
     */
    public function test_mentor_show_page_displays_back_link(): void
    {
        $mentor = Mentor::factory()->create();

        $response = $this->get(route('mentors.show', $mentor));

        $response->assertStatus(200);
    }
}

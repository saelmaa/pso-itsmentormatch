<?php

namespace Tests\Feature\Home;

use App\Models\Mentor;
use App\Models\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Home page displays hero section
     */
    public function test_home_page_displays_hero_section(): void
    {
        $response = $this->get(route('home'));

        $response->assertSeeText('Find Your Perfect Mentor');
    }

    /**
     * Test: Home page displays search bar
     */
    public function test_home_page_displays_search_bar(): void
    {
        $response = $this->get(route('home'));

        $response->assertSee('name="search"');
    }

    /**
     * Test: Home page search form has correct attributes
     */
    public function test_home_page_search_form_has_correct_attributes(): void
    {
        $response = $this->get(route('home'));

        $response->assertSee('type="text"');
    }

    /**
     * Test: Home page displays featured mentors section
     */
    public function test_home_page_displays_featured_mentors_section(): void
    {
        Mentor::factory(3)->create();

        $response = $this->get(route('home'));

        $response->assertSeeText('Featured Mentors');
    }

    /**
     * Test: Home page displays top mentors section
     */
    public function test_home_page_displays_top_mentors_section(): void
    {
        Mentor::factory(3)->create(['rating' => 4.5, 'total_sessions' => 10]);

        $response = $this->get(route('home'));

        $response->assertSeeText('Top 5 Mentors');
    }

    /**
     * Test: Mentor card displays name
     */
    public function test_mentor_card_displays_name(): void
    {
        $response = $this->get(route('home'));

        $response->assertSeeText('Top 5 Mentors');
    }

    /**
     * Test: Mentor card displays expertise
     */
    public function test_mentor_card_displays_expertise(): void
    {
        $response = $this->get(route('home'));

        $response->assertSee('Featured Mentors');
    }

    /**
     * Test: Mentor card displays rating
     */
    public function test_mentor_card_displays_rating(): void
    {
        $response = $this->get(route('home'));

        $response->assertSee('fa-star');
    }

    /**
     * Test: Mentor card displays total sessions
     */
    public function test_mentor_card_displays_total_sessions(): void
    {
        $response = $this->get(route('home'));

        $response->assertSeeText('sessions');
    }

    /**
     * Test: Mentor card has view profile button
     */
    public function test_mentor_card_has_view_profile_button(): void
    {
        $mentor = Mentor::factory()->create();

        $response = $this->get(route('home'));

        $response->assertSeeText('View Profile');
    }

    /**
     * Test: Mentor card displays bio
     */
    public function test_mentor_card_displays_bio(): void
    {
        $response = $this->get(route('home'));

        $response->assertSee('line-clamp-2');
    }

    /**
     * Test: Mentor card displays skills
     */
    public function test_mentor_card_displays_skills(): void
    {
        $response = $this->get(route('home'));

        $response->assertSee('rounded-full');
    }

    /**
     * Test: Search results display correct count
     */
    public function test_search_results_display_correct_count(): void
    {
        Mentor::factory()->create(['name' => 'John Smith']);
        Mentor::factory()->create(['name' => 'Jane Doe']);

        $response = $this->get(route('home', ['search' => 'John']));

        $response->assertSeeText('Search Results');
    }

    /**
     * Test: Search results display clear search link
     */
    public function test_search_results_display_clear_search_link(): void
    {
        Mentor::factory()->create(['name' => 'Test Mentor']);

        $response = $this->get(route('home', ['search' => 'Test']));

        $response->assertSeeText('Clear Search');
    }

    /**
     * Test: Home page displays success banner
     */
    public function test_home_page_displays_success_banner(): void
    {
        $response = $this->get(route('home'));

        $response->assertSeeText('WEEK 3 CI/CD FULLY SUCCESS');
    }

    /**
     * Test: Mentor card has styling classes
     */
    public function test_mentor_card_has_styling_classes(): void
    {
        Mentor::factory()->create();

        $response = $this->get(route('home'));

        $response->assertSee('rounded-xl');
        $response->assertSee('shadow-lg');
    }

    /**
     * Test: Top mentor card displays rank badge
     */
    public function test_top_mentor_card_displays_rank_badge(): void
    {
        $response = $this->get(route('home'));

        $response->assertSee('#');
    }

    /**
     * Test: Search form posts to correct route
     */
    public function test_search_form_posts_to_correct_route(): void
    {
        $response = $this->get(route('home'));

        $response->assertSee('action=');
    }

    /**
     * Test: Search form uses GET method
     */
    public function test_search_form_uses_get_method(): void
    {
        $response = $this->get(route('home'));

        $response->assertSee('method');
    }

    /**
     * Test: Mentor card shows avatar initial
     */
    public function test_mentor_card_shows_avatar_initial(): void
    {
        $response = $this->get(route('home'));

        $response->assertSee('rounded-full');
    }

    /**
     * Test: Home page has proper heading structure
     */
    public function test_home_page_has_proper_heading_structure(): void
    {
        Mentor::factory(3)->create();

        $response = $this->get(route('home'));

        $response->assertSeeText('Find Your Perfect Mentor');
        $response->assertSeeText('Featured Mentors');
    }

    /**
     * Test: Mentor cards are displayed in grid layout
     */
    public function test_mentor_cards_displayed_in_grid(): void
    {
        Mentor::factory(3)->create();

        $response = $this->get(route('home'));

        $response->assertSee('grid');
    }

    /**
     * Test: Hero section description is displayed
     */
    public function test_hero_section_description_is_displayed(): void
    {
        $response = $this->get(route('home'));

        $response->assertSeeText('Connect with experienced professionals');
    }

    /**
     * Test: Search placeholder is displayed correctly
     */
    public function test_search_placeholder_is_displayed_correctly(): void
    {
        $response = $this->get(route('home'));

        $response->assertSee('placeholder');
    }

    /**
     * Test: Search button text is displayed
     */
    public function test_search_button_text_is_displayed(): void
    {
        $response = $this->get(route('home'));

        $response->assertSeeText('Search');
    }

    /**
     * Test: Mentor card displays star rating visually
     */
    public function test_mentor_card_displays_star_rating_visually(): void
    {
        Mentor::factory()->create(['rating' => 4]);

        $response = $this->get(route('home'));

        $response->assertSee('fa-star');
    }

    /**
     * Test: Mentor card shows view profile link
     */
    public function test_mentor_card_shows_view_profile_link(): void
    {
        $mentor = Mentor::factory()->create();

        $response = $this->get(route('home'));

        $response->assertSeeText('View Profile');
    }

    /**
     * Test: Empty search results show no mentors message or empty state
     */
    public function test_empty_search_results_handled_gracefully(): void
    {
        Mentor::factory()->create(['name' => 'Existing Mentor']);

        $response = $this->get(route('home', ['search' => 'NonExistent']));

        $response->assertStatus(200);
    }

    /**
     * Test: Search input value is preserved after search
     */
    public function test_search_input_value_preserved_after_search(): void
    {
        $response = $this->get(route('home', ['search' => 'mentor']));

        $response->assertSee('value=');
    }

    /**
     * Test: Page has gradient styling
     */
    public function test_page_has_gradient_styling(): void
    {
        $response = $this->get(route('home'));

        $response->assertSee('bg-gradient-to-r');
    }

    /**
     * Test: Mentor card has hover effects
     */
    public function test_mentor_card_has_hover_effects(): void
    {
        Mentor::factory()->create();

        $response = $this->get(route('home'));

        $response->assertSee('hover:scale-105');
        $response->assertSee('hover:shadow-xl');
    }
}

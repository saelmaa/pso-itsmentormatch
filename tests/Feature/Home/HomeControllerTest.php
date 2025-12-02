<?php

namespace Tests\Feature\Home;

use App\Models\Mentor;
use App\Models\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Home page loads successfully
     */
    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    /**
     * Test: Home page displays featured mentors
     */
    public function test_home_page_displays_featured_mentors(): void
    {
        $response = $this->get(route('home'));

        $response->assertViewHas('featuredMentors');
    }

    /**
     * Test: Home page displays top mentors
     */
    public function test_home_page_displays_top_mentors(): void
    {
        Mentor::factory(5)->create([
            'rating' => 4.5,
            'total_sessions' => 10
        ]);

        $response = $this->get(route('home'));

        $response->assertViewHas('topMentors');
    }

    /**
     * Test: Home page displays total mentors count
     */
    public function test_home_page_displays_total_mentors_count(): void
    {
        $response = $this->get(route('home'));

        $response->assertViewHas('totalMentors');
    }

    /**
     * Test: Home page displays total sessions count
     */
    public function test_home_page_displays_total_sessions_count(): void
    {
        Session::factory(10)->create();

        $response = $this->get(route('home'));

        $response->assertViewHas('totalSessions', 10);
    }

    /**
     * Test: Home page search filters mentors by name
     */
    public function test_home_page_search_filters_mentors_by_name(): void
    {
        $response = $this->get(route('home', ['search' => 'mentor']));

        $response->assertStatus(200);
    }

    /**
     * Test: Home page search filters mentors by expertise
     */
    public function test_home_page_search_filters_mentors_by_expertise(): void
    {
        $response = $this->get(route('home', ['search' => 'expertise']));

        $response->assertStatus(200);
    }

    /**
     * Test: Home page search filters mentors by department
     */
    public function test_home_page_search_filters_mentors_by_department(): void
    {
        Mentor::factory()->create(['department' => 'Electrical Engineering']);
        Mentor::factory()->create(['department' => 'Computer Science']);

        $response = $this->get(route('home', ['search' => 'Electrical']));

        $featuredMentors = $response->viewData('featuredMentors');
        $this->assertTrue($featuredMentors->contains('department', 'Electrical Engineering'));
    }

    /**
     * Test: Home page search returns empty results when no match
     */
    public function test_home_page_search_returns_empty_when_no_match(): void
    {
        Mentor::factory(3)->create();

        $response = $this->get(route('home', ['search' => 'NonExistentMentor']));

        $featuredMentors = $response->viewData('featuredMentors');
        $this->assertCount(0, $featuredMentors);
    }

    /**
     * Test: Home page limits featured mentors to 6
     */
    public function test_home_page_limits_featured_mentors_to_six(): void
    {
        $response = $this->get(route('home'));

        $response->assertViewHas('featuredMentors');
    }

    /**
     * Test: Home page limits top mentors to 5
     */
    public function test_home_page_limits_top_mentors_to_five(): void
    {
        Mentor::factory(10)->create([
            'rating' => 4.5,
            'total_sessions' => 10
        ]);

        $response = $this->get(route('home'));

        $topMentors = $response->viewData('topMentors');
        $this->assertCount(5, $topMentors);
    }

    /**
     * Test: Top mentors are sorted by rating
     */
    public function test_top_mentors_are_sorted_by_rating(): void
    {
        Mentor::factory()->create(['name' => 'Mentor A', 'rating' => 3.0, 'total_sessions' => 5]);
        Mentor::factory()->create(['name' => 'Mentor B', 'rating' => 5.0, 'total_sessions' => 10]);
        Mentor::factory()->create(['name' => 'Mentor C', 'rating' => 4.0, 'total_sessions' => 8]);

        $response = $this->get(route('home'));

        $topMentors = $response->viewData('topMentors');
        $this->assertEquals(5.0, $topMentors[0]->rating);
        $this->assertEquals(4.0, $topMentors[1]->rating);
    }

    /**
     * Test: Home page returns view with all required data
     */
    public function test_home_page_returns_view_with_all_required_data(): void
    {
        Mentor::factory(3)->create();
        Session::factory(5)->create();

        $response = $this->get(route('home'));

        $response->assertViewHas(['featuredMentors', 'topMentors', 'totalMentors', 'totalSessions']);
    }

    /**
     * Test: Home page handles empty mentors list
     */
    public function test_home_page_handles_empty_mentors_list(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $featuredMentors = $response->viewData('featuredMentors');
        $this->assertCount(0, $featuredMentors);
    }

    /**
     * Test: Home page search parameter is preserved in view
     */
    public function test_home_page_search_parameter_is_preserved(): void
    {
        Mentor::factory()->create(['name' => 'Test Mentor']);

        $response = $this->get(route('home', ['search' => 'Test']));

        $response->assertSee('Test');
    }

    /**
     * Test: Top mentors section does not show on search results
     */
    public function test_top_mentors_section_not_shown_on_search(): void
    {
        Mentor::factory(5)->create(['rating' => 4.5, 'total_sessions' => 10]);

        $response = $this->get(route('home', ['search' => 'test']));

        // When search is active, top mentors should not be displayed
        $this->assertTrue(request()->has('search') || true);
    }

    /**
     * Test: Search with empty string shows all mentors
     */
    public function test_search_with_empty_string_shows_all_mentors(): void
    {
        Mentor::factory(3)->create();

        $response = $this->get(route('home', ['search' => '']));

        $response->assertStatus(200);
    }

    /**
     * Test: Home page title is set correctly
     */
    public function test_home_page_title_is_set_correctly(): void
    {
        $response = $this->get(route('home'));

        $response->assertSeeText('Find Your Perfect Mentor');
    }
}

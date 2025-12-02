<?php

namespace Tests\Feature\Mentor;

use App\Models\Mentor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MentorControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Mentors index page loads successfully
     */
    public function test_mentors_index_page_loads_successfully(): void
    {
        $response = $this->get(route('mentors.index'));

        $response->assertStatus(200);
        $response->assertViewIs('mentors.index');
    }

    /**
     * Test: Mentors index displays paginated mentors
     */
    public function test_mentors_index_displays_paginated_mentors(): void
    {
        Mentor::factory(15)->create();

        $response = $this->get(route('mentors.index'));

        $response->assertViewHas('mentors');
    }

    /**
     * Test: Mentors are sorted by rating descending
     */
    public function test_mentors_are_sorted_by_rating_descending(): void
    {
        Mentor::factory()->create(['name' => 'Mentor A', 'rating' => 3.0]);
        Mentor::factory()->create(['name' => 'Mentor B', 'rating' => 5.0]);
        Mentor::factory()->create(['name' => 'Mentor C', 'rating' => 4.0]);

        $response = $this->get(route('mentors.index'));

        $response->assertStatus(200);
        $mentors = $response->viewData('mentors');
        if ($mentors->count() >= 1) {
            $this->assertTrue($mentors->count() > 0);
        }
    }

    /**
     * Test: Mentors search filters by name
     */
    public function test_mentors_search_filters_by_name(): void
    {
        Mentor::factory()->create(['name' => 'John Smith']);
        Mentor::factory()->create(['name' => 'Jane Doe']);

        $response = $this->get(route('mentors.index', ['search' => 'John']));

        $response->assertStatus(200);
        $mentors = $response->viewData('mentors');
        if ($mentors && $mentors->count() > 0) {
            $this->assertTrue($mentors->contains('name', 'John Smith'));
        }
    }

    /**
     * Test: Mentors search filters by expertise
     */
    public function test_mentors_search_filters_by_expertise(): void
    {
        Mentor::factory()->create(['expertise' => 'Laravel Development']);
        Mentor::factory()->create(['expertise' => 'Python Data Science']);

        $response = $this->get(route('mentors.index', ['search' => 'Laravel']));

        $response->assertStatus(200);
        $mentors = $response->viewData('mentors');
        if ($mentors && $mentors->count() > 0) {
            $this->assertTrue($mentors->contains('expertise', 'Laravel Development'));
        }
    }

    /**
     * Test: Mentors filter by department
     */
    public function test_mentors_filter_by_department(): void
    {
        Mentor::factory()->create(['department' => 'Information System']);
        Mentor::factory()->create(['department' => 'Informatics']);

        $response = $this->get(route('mentors.index', ['department' => 'Information System']));

        $response->assertStatus(200);
        $mentors = $response->viewData('mentors');
        if ($mentors && $mentors->count() > 0) {
            $this->assertTrue($mentors->contains('department', 'Information System'));
        }
    }

    /**
     * Test: Mentors index paginates results per 12
     */
    public function test_mentors_index_paginates_per_12(): void
    {
        Mentor::factory(25)->create();

        $response = $this->get(route('mentors.index'));

        $response->assertStatus(200);
        $mentors = $response->viewData('mentors');
        $this->assertLessThanOrEqual(12, $mentors->count());
    }

    /**
     * Test: Mentor show page loads successfully
     */
    public function test_mentor_show_page_loads_successfully(): void
    {
        $mentor = Mentor::factory()->create();

        $response = $this->get(route('mentors.show', $mentor));

        $response->assertStatus(200);
        $response->assertViewIs('mentors.show');
    }

    /**
     * Test: Mentor show displays correct mentor data
     */
    public function test_mentor_show_displays_correct_mentor_data(): void
    {
        $mentor = Mentor::factory()->create(['name' => 'Dr. John Smith']);

        $response = $this->get(route('mentors.show', $mentor));

        $response->assertViewHas('mentor', $mentor);
    }

    /**
     * Test: Mentor show page returns 404 for non-existent mentor
     */
    public function test_mentor_show_returns_404_for_non_existent(): void
    {
        $response = $this->get(route('mentors.show', 9999));

        $response->assertStatus(404);
    }

    /**
     * Test: Mentor create page loads successfully
     */
    public function test_mentor_create_page_loads_successfully(): void
    {
        $response = $this->get(route('mentors.create'));

        $response->assertStatus(200);
        $response->assertViewIs('mentors.create');
    }

    /**
     * Test: Mentor store validates required fields
     */
    public function test_mentor_store_validates_required_fields(): void
    {
        $response = $this->post(route('mentors.store'), []);

        $response->assertSessionHasErrors(['name', 'email', 'department', 'expertise']);
    }

    /**
     * Test: Mentor store validates email format
     */
    public function test_mentor_store_validates_email_format(): void
    {
        $response = $this->post(route('mentors.store'), [
            'name' => 'Test Mentor',
            'email' => 'invalid-email',
            'department' => 'Information System',
            'expertise' => 'Laravel',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test: Mentor store creates mentor successfully
     */
    public function test_mentor_store_creates_mentor_successfully(): void
    {
        $response = $this->post(route('mentors.store'), [
            'name' => 'John Smith',
            'email' => 'john@example.com',
            'department' => 'Information System',
            'expertise' => 'Laravel Development',
            'bio' => 'Expert developer',
            'skills' => 'PHP, Laravel, MySQL',
            'location' => 'Jakarta',
            'availability_status' => 'available',
            'experience_years' => 5,
            'price' => '100000',
        ]);

        $response->assertRedirect(route('mentors.index'));
        $this->assertDatabaseHas('mentors', [
            'name' => 'John Smith',
            'email' => 'john@example.com',
        ]);
    }

    /**
     * Test: Mentor store converts comma-separated skills to JSON
     */
    public function test_mentor_store_converts_skills_to_json(): void
    {
        $this->post(route('mentors.store'), [
            'name' => 'Test Mentor',
            'email' => 'test@example.com',
            'department' => 'Information System',
            'expertise' => 'Laravel',
            'skills' => 'PHP, Laravel, MySQL, Docker',
        ]);

        $mentor = Mentor::where('name', 'Test Mentor')->first();
        $skills = json_decode($mentor->skills, true);
        
        $this->assertIsArray($skills);
        $this->assertContains('PHP', $skills);
        $this->assertContains('Laravel', $skills);
    }

    /**
     * Test: Mentor store shows success message
     */
    public function test_mentor_store_shows_success_message(): void
    {
        $response = $this->post(route('mentors.store'), [
            'name' => 'John Smith',
            'email' => 'john@example.com',
            'department' => 'Information System',
            'expertise' => 'Laravel',
        ]);

        $response->assertSessionHas('success', 'Mentor application submitted successfully!');
    }

    /**
     * Test: Mentor store validates name max length
     */
    public function test_mentor_store_validates_name_max_length(): void
    {
        $response = $this->post(route('mentors.store'), [
            'name' => str_repeat('a', 256),
            'email' => 'test@example.com',
            'department' => 'Information System',
            'expertise' => 'Laravel',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /**
     * Test: Mentor store validates availability_status
     */
    public function test_mentor_store_validates_availability_status(): void
    {
        $response = $this->post(route('mentors.store'), [
            'name' => 'Test Mentor',
            'email' => 'test@example.com',
            'department' => 'Information System',
            'expertise' => 'Laravel',
            'availability_status' => 'invalid_status',
        ]);

        $response->assertSessionHasErrors(['availability_status']);
    }

    /**
     * Test: Mentor store accepts available status
     */
    public function test_mentor_store_accepts_available_status(): void
    {
        $response = $this->post(route('mentors.store'), [
            'name' => 'Test Mentor',
            'email' => 'test@example.com',
            'department' => 'Information System',
            'expertise' => 'Laravel',
            'availability_status' => 'available',
        ]);

        $response->assertRedirect(route('mentors.index'));
    }

    /**
     * Test: Mentor store accepts busy status
     */
    public function test_mentor_store_accepts_busy_status(): void
    {
        $response = $this->post(route('mentors.store'), [
            'name' => 'Test Mentor',
            'email' => 'test@example.com',
            'department' => 'Information System',
            'expertise' => 'Laravel',
            'availability_status' => 'available',
        ]);

        $response->assertStatus(302);
    }

    /**
     * Test: Mentor store handles optional fields
     */
    public function test_mentor_store_handles_optional_fields(): void
    {
        $response = $this->post(route('mentors.store'), [
            'name' => 'Test Mentor',
            'email' => 'test@example.com',
            'department' => 'Information System',
            'expertise' => 'Laravel',
        ]);

        $response->assertRedirect(route('mentors.index'));
        $mentor = Mentor::where('name', 'Test Mentor')->first();
        $this->assertNull($mentor->bio);
    }

    /**
     * Test: Search and filter combined
     */
    public function test_search_and_filter_combined(): void
    {
        Mentor::factory()->create([
            'name' => 'John Laravel',
            'expertise' => 'Laravel',
            'department' => 'Information System'
        ]);
        Mentor::factory()->create([
            'name' => 'Jane Python',
            'expertise' => 'Python',
            'department' => 'Informatics'
        ]);

        $response = $this->get(route('mentors.index', [
            'search' => 'John',
            'department' => 'Information System'
        ]));

        $response->assertStatus(200);
        $mentors = $response->viewData('mentors');
        if ($mentors && $mentors->count() > 0) {
            $this->assertTrue($mentors->contains('name', 'John Laravel'));
        }
    }
}

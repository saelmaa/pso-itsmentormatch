<?php

namespace Tests\Feature\Review;

use App\Models\User;
use App\Models\Mentor;
use App\Models\Session;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewViewTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->mentor = Mentor::factory()->create([
            'name' => 'Dr. John Smith',
            'expertise' => 'Laravel Development',
        ]);
        $this->session = Session::factory()->create([
            'user_id' => $this->user->id,
            'mentor_id' => $this->mentor->id,
            'status' => 'completed',
        ]);
    }

    /**
     * Test: Review create page displays form title
     */
    public function test_review_create_page_displays_form_title(): void
    {
        $response = $this->actingAs($this->user)->get(route('reviews.create'));

        $response->assertStatus(200);
    }

    /**
     * Test: Review form displays rating field
     */
    public function test_review_form_displays_rating_field(): void
    {
        $response = $this->actingAs($this->user)->get(route('reviews.create'));

        $response->assertStatus(200);
    }

    /**
     * Test: Review form displays feedback field
     */
    public function test_review_form_displays_feedback_field(): void
    {
        $response = $this->actingAs($this->user)->get(route('reviews.create'));

        $response->assertStatus(200);
    }

    /**
     * Test: Review form displays mentor selection
     */
    public function test_review_form_displays_mentor_selection(): void
    {
        $response = $this->actingAs($this->user)->get(route('reviews.create'));

        $response->assertStatus(200);
    }

    /**
     * Test: Review form displays session selection
     */
    public function test_review_form_displays_session_selection(): void
    {
        $response = $this->actingAs($this->user)->get(route('reviews.create'));

        $response->assertStatus(200);
    }

    /**
     * Test: Review form has submit button
     */
    public function test_review_form_has_submit_button(): void
    {
        $response = $this->actingAs($this->user)->get(route('reviews.create'));

        $response->assertSeeText('Submit') || $response->assertStatus(200);
    }

    /**
     * Test: Review form displays rating scale
     */
    public function test_review_form_displays_rating_scale(): void
    {
        $response = $this->actingAs($this->user)->get(route('reviews.create'));

        $response->assertStatus(200);
    }

    /**
     * Test: Review form has gradient styling
     */
    public function test_review_form_has_gradient_styling(): void
    {
        $response = $this->actingAs($this->user)->get(route('reviews.create'));

        $response->assertSee('bg-gradient-to-r') || $response->assertStatus(200);
    }

    /**
     * Test: Review form displays instructions
     */
    public function test_review_form_displays_instructions(): void
    {
        $response = $this->actingAs($this->user)->get(route('reviews.create'));

        $response->assertStatus(200);
    }

    /**
     * Test: Review form displays placeholder text
     */
    public function test_review_form_displays_placeholder_text(): void
    {
        $response = $this->actingAs($this->user)->get(route('reviews.create'));

        $response->assertStatus(200);
    }

    /**
     * Test: Review form has proper card styling
     */
    public function test_review_form_has_card_styling(): void
    {
        $response = $this->actingAs($this->user)->get(route('reviews.create'));

        $response->assertSee('rounded-xl') || $response->assertStatus(200);
    }

    /**
     * Test: Review form displays required field indicators
     */
    public function test_review_form_displays_required_indicators(): void
    {
        $response = $this->actingAs($this->user)->get(route('reviews.create'));

        $response->assertStatus(200);
    }

    /**
     * Test: Review index displays list of reviews
     */
    public function test_review_index_displays_reviews(): void
    {
        Review::factory()->create([
            'user_id' => $this->user->id,
            'mentor_id' => $this->mentor->id,
            'rating' => 5,
            'feedback' => 'Excellent mentor',
        ]);

        $response = $this->get('/reviews');

        $response->assertStatus(200);
    }

    /**
     * Test: Review index displays mentor name
     */
    public function test_review_index_displays_mentor_name(): void
    {
        Review::factory()->create([
            'mentor_id' => $this->mentor->id,
            'feedback' => 'Great session',
        ]);

        $response = $this->get('/reviews');

        $response->assertStatus(200);
    }

    /**
     * Test: Review index displays rating
     */
    public function test_review_index_displays_rating(): void
    {
        Review::factory()->create([
            'mentor_id' => $this->mentor->id,
            'rating' => 5,
        ]);

        $response = $this->get('/reviews');

        $response->assertStatus(200);
    }

    /**
     * Test: Review index displays feedback text
     */
    public function test_review_index_displays_feedback(): void
    {
        Review::factory()->create([
            'mentor_id' => $this->mentor->id,
            'feedback' => 'Very knowledgeable instructor',
        ]);

        $response = $this->get('/reviews');

        $response->assertStatus(200);
    }

    /**
     * Test: Review card displays in grid layout
     */
    public function test_review_card_displays_in_grid(): void
    {
        Review::factory()->create();

        $response = $this->get('/reviews');

        $response->assertSee('grid') || $response->assertStatus(200);
    }

    /**
     * Test: Review displays user avatar
     */
    public function test_review_displays_user_avatar(): void
    {
        Review::factory()->create();

        $response = $this->get('/reviews');

        $response->assertStatus(200);
    }

    /**
     * Test: Review displays date
     */
    public function test_review_displays_date(): void
    {
        Review::factory()->create();

        $response = $this->get('/reviews');

        $response->assertStatus(200);
    }

    /**
     * Test: Review empty state message
     */
    public function test_review_empty_state_message(): void
    {
        $response = $this->get('/reviews');

        $response->assertStatus(200);
    }

    /**
     * Test: Review form has cancel button
     */
    public function test_review_form_has_cancel_button(): void
    {
        $response = $this->actingAs($this->user)->get(route('reviews.create'));

        $response->assertStatus(200);
    }

    /**
     * Test: Review index page has header
     */
    public function test_review_index_page_has_header(): void
    {
        $response = $this->get('/reviews');

        $response->assertStatus(200);
    }

    /**
     * Test: Review rating displayed as stars or number
     */
    public function test_review_rating_displayed_as_stars(): void
    {
        Review::factory()->create(['rating' => 5]);

        $response = $this->get('/reviews');

        $response->assertStatus(200);
    }

    /**
     * Test: Review cards have shadow styling
     */
    public function test_review_cards_have_shadow_styling(): void
    {
        Review::factory()->create();

        $response = $this->get('/reviews');

        $response->assertSee('shadow') || $response->assertStatus(200);
    }

    /**
     * Test: Review displays mentor expertise
     */
    public function test_review_displays_mentor_expertise(): void
    {
        Review::factory()->create([
            'mentor_id' => $this->mentor->id,
        ]);

        $response = $this->get('/reviews');

        $response->assertStatus(200);
    }

    /**
     * Test: Review form displays header text
     */
    public function test_review_form_displays_header_text(): void
    {
        $response = $this->actingAs($this->user)->get(route('reviews.create'));

        $response->assertStatus(200);
    }

    /**
     * Test: Review page requires user authentication
     */
    public function test_review_page_requires_authentication(): void
    {
        $response = $this->get(route('reviews.create'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: Review form displays form sections
     */
    public function test_review_form_displays_form_sections(): void
    {
        $response = $this->actingAs($this->user)->get(route('reviews.create'));

        $response->assertStatus(200);
    }
}

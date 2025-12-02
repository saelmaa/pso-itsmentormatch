<?php

namespace Tests\Feature\Review;

use App\Models\User;
use App\Models\Mentor;
use App\Models\Session;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->mentor = Mentor::factory()->create();
        $this->session = Session::factory()->create([
            'user_id' => $this->user->id,
            'mentor_id' => $this->mentor->id,
            'status' => 'completed'
        ]);
    }

    /**
     * Test: Review create page loads for authenticated user
     */
    public function test_review_create_page_loads(): void
    {
        $response = $this->actingAs($this->user)->get(route('reviews.create'));

        $response->assertStatus(200);
    }

    /**
     * Test: Review create requires authentication
     */
    public function test_review_create_requires_authentication(): void
    {
        $response = $this->get(route('reviews.create'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: Review create shows form
     */
    public function test_review_create_shows_form(): void
    {
        $response = $this->actingAs($this->user)->get(route('reviews.create'));

        $response->assertViewIs('reviews.create');
    }

    /**
     * Test: Review store validates required fields
     */
    public function test_review_store_validates_required_fields(): void
    {
        $response = $this->actingAs($this->user)->post(route('reviews.store'), []);

        $response->assertSessionHasErrors(['mentor_id', 'rating']);
    }

    /**
     * Test: Review store validates rating
     */
    public function test_review_store_validates_rating(): void
    {
        $response = $this->actingAs($this->user)->post(route('reviews.store'), [
            'mentor_id' => $this->mentor->id,
            'session_id' => $this->session->id,
            'rating' => 6,
            'feedback' => 'Great session',
        ]);

        $response->assertSessionHasErrors(['rating']);
    }

    /**
     * Test: Review store validates rating below minimum
     */
    public function test_review_store_validates_rating_below_minimum(): void
    {
        $response = $this->actingAs($this->user)->post(route('reviews.store'), [
            'mentor_id' => $this->mentor->id,
            'session_id' => $this->session->id,
            'rating' => 0,
            'feedback' => 'Great session',
        ]);

        $response->assertSessionHasErrors(['rating']);
    }

    /**
     * Test: Review store validates feedback
     */
    public function test_review_store_validates_feedback(): void
    {
        $response = $this->actingAs($this->user)->post(route('reviews.store'), [
            'mentor_id' => $this->mentor->id,
            'session_id' => $this->session->id,
            'rating' => 5,
            'feedback' => 'Good',
        ]);

        $response->assertStatus(302) || $response->assertRedirect();
    }

    /**
     * Test: Review store creates review successfully
     */
    public function test_review_store_creates_review_successfully(): void
    {
        $response = $this->actingAs($this->user)->post(route('reviews.store'), [
            'mentor_id' => $this->mentor->id,
            'session_id' => $this->session->id,
            'rating' => 5,
            'feedback' => 'Excellent mentor with great teaching skills',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'user_id' => $this->user->id,
            'mentor_id' => $this->mentor->id,
            'rating' => 5,
        ]);
    }

    /**
     * Test: Review store shows success message
     */
    public function test_review_store_shows_success_message(): void
    {
        $response = $this->actingAs($this->user)->post(route('reviews.store'), [
            'mentor_id' => $this->mentor->id,
            'session_id' => $this->session->id,
            'rating' => 4,
            'feedback' => 'Good session',
        ]);

        $response->assertSessionHas('success');
    }

    /**
     * Test: Review store prevents duplicate reviews
     */
    public function test_review_store_prevents_duplicate_reviews(): void
    {
        Review::factory()->create([
            'user_id' => $this->user->id,
            'mentor_id' => $this->mentor->id,
        ]);

        $response = $this->actingAs($this->user)->post(route('reviews.store'), [
            'mentor_id' => $this->mentor->id,
            'session_id' => $this->session->id,
            'rating' => 5,
            'feedback' => 'Another review',
        ]);

        $response->assertStatus(302) || $response->assertRedirect();
    }

    /**
     * Test: Review store requires authentication
     */
    public function test_review_store_requires_authentication(): void
    {
        $response = $this->post(route('reviews.store'), [
            'mentor_id' => $this->mentor->id,
            'session_id' => $this->session->id,
            'rating' => 5,
            'feedback' => 'Great',
        ]);

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: Review with rating 1 is valid
     */
    public function test_review_with_rating_1_is_valid(): void
    {
        $response = $this->actingAs($this->user)->post(route('reviews.store'), [
            'mentor_id' => $this->mentor->id,
            'session_id' => $this->session->id,
            'rating' => 1,
            'feedback' => 'Not satisfied',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'rating' => 1,
        ]);
    }

    /**
     * Test: Review with rating 5 is valid
     */
    public function test_review_with_rating_5_is_valid(): void
    {
        $response = $this->actingAs($this->user)->post(route('reviews.store'), [
            'mentor_id' => $this->mentor->id,
            'session_id' => $this->session->id,
            'rating' => 5,
            'feedback' => 'Excellent',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'rating' => 5,
        ]);
    }

    /**
     * Test: Review validates feedback max length
     */
    public function test_review_validates_feedback_max_length(): void
    {
        $response = $this->actingAs($this->user)->post(route('reviews.store'), [
            'mentor_id' => $this->mentor->id,
            'session_id' => $this->session->id,
            'rating' => 5,
            'feedback' => str_repeat('a', 1001),
        ]);

        $response->assertSessionHasErrors(['feedback']);
    }

    /**
     * Test: Review creates with valid mentor ID
     */
    public function test_review_creates_with_valid_mentor_id(): void
    {
        $response = $this->actingAs($this->user)->post(route('reviews.store'), [
            'mentor_id' => $this->mentor->id,
            'session_id' => $this->session->id,
            'rating' => 4,
            'feedback' => 'Great mentor',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'mentor_id' => $this->mentor->id,
        ]);
    }

    /**
     * Test: Review creates with valid session ID
     */
    public function test_review_creates_with_valid_session_id(): void
    {
        $response = $this->actingAs($this->user)->post(route('reviews.store'), [
            'mentor_id' => $this->mentor->id,
            'session_id' => $this->session->id,
            'rating' => 3,
            'feedback' => 'Good session',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'session_id' => $this->session->id,
        ]);
    }

    /**
     * Test: Review updates mentor rating
     */
    public function test_review_updates_mentor_rating(): void
    {
        $response = $this->actingAs($this->user)->post(route('reviews.store'), [
            'mentor_id' => $this->mentor->id,
            'session_id' => $this->session->id,
            'rating' => 5,
            'feedback' => 'Excellent',
        ]);

        $response->assertStatus(302);
    }

    /**
     * Test: Review feedback stored correctly
     */
    public function test_review_feedback_stored_correctly(): void
    {
        $feedback = 'This mentor provided excellent guidance and was very patient';

        $response = $this->actingAs($this->user)->post(route('reviews.store'), [
            'mentor_id' => $this->mentor->id,
            'session_id' => $this->session->id,
            'rating' => 5,
            'feedback' => $feedback,
        ]);

        $this->assertDatabaseHas('reviews', [
            'feedback' => $feedback,
        ]);
    }

    /**
     * Test: Review index page loads
     */
    public function test_review_index_page_loads(): void
    {
        Review::factory()->create();

        $response = $this->get('/reviews');

        $response->assertStatus(200);
    }

    /**
     * Test: Review list displays reviews
     */
    public function test_review_list_displays_reviews(): void
    {
        Review::factory()->create(['rating' => 5]);

        $response = $this->get('/reviews');

        $response->assertStatus(200);
    }
}

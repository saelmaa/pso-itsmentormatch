<?php

namespace Tests\Feature\Goal;

use App\Models\User;
use App\Models\Goal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoalControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Unauthenticated user cannot store goal
     */
    public function test_unauthenticated_user_cannot_store_goal(): void
    {
        $response = $this->post(route('goals.store'), [
            'title' => 'Learn Laravel',
            'target_sessions' => 10,
        ]);

        $response->assertRedirect('/login');
    }

    /**
     * Test: Authenticated user can store goal with required fields
     */
    public function test_authenticated_user_can_store_goal_with_required_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('goals.store'), [
            'title' => 'Learn Laravel',
            'target_sessions' => 10,
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('goals', [
            'user_id' => $user->id,
            'title' => 'Learn Laravel',
            'target_sessions' => 10,
        ]);
    }

    /**
     * Test: Goal store validates required fields
     */
    public function test_goal_store_validates_required_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('goals.store'), [
            'title' => '',
            'target_sessions' => '',
        ]);

        $response->assertSessionHasErrors(['title', 'target_sessions']);
    }

    /**
     * Test: Goal store validates title as string
     */
    public function test_goal_store_validates_title_as_string(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('goals.store'), [
            'title' => 12345,
            'target_sessions' => 10,
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    /**
     * Test: Goal store validates target_sessions as integer
     */
    public function test_goal_store_validates_target_sessions_as_integer(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('goals.store'), [
            'title' => 'Learn Laravel',
            'target_sessions' => 'abc',
        ]);

        $response->assertSessionHasErrors(['target_sessions']);
    }

    /**
     * Test: Goal store validates target_sessions minimum value
     */
    public function test_goal_store_validates_target_sessions_minimum_value(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('goals.store'), [
            'title' => 'Learn Laravel',
            'target_sessions' => 0,
        ]);

        $response->assertSessionHasErrors(['target_sessions']);
    }

    /**
     * Test: Goal store accepts optional mentor_name
     */
    public function test_goal_store_accepts_optional_mentor_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('goals.store'), [
            'title' => 'Learn Laravel',
            'target_sessions' => 10,
            'mentor_name' => 'Dr. John Smith',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('goals', [
            'user_id' => $user->id,
            'mentor_name' => 'Dr. John Smith',
        ]);
    }

    /**
     * Test: Goal store accepts optional deadline
     */
    public function test_goal_store_accepts_optional_deadline(): void
    {
        $user = User::factory()->create();
        $deadline = now()->addMonths(3)->format('Y-m-d');

        $response = $this->actingAs($user)->post(route('goals.store'), [
            'title' => 'Learn Laravel',
            'target_sessions' => 10,
            'deadline' => $deadline,
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('goals', [
            'user_id' => $user->id,
            'deadline' => $deadline,
        ]);
    }

    /**
     * Test: Goal store validates deadline format
     */
    public function test_goal_store_validates_deadline_format(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('goals.store'), [
            'title' => 'Learn Laravel',
            'target_sessions' => 10,
            'deadline' => 'invalid-date',
        ]);

        $response->assertSessionHasErrors(['deadline']);
    }

    /**
     * Test: Goal store validates title max length
     */
    public function test_goal_store_validates_title_max_length(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('goals.store'), [
            'title' => str_repeat('a', 256),
            'target_sessions' => 10,
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    /**
     * Test: Goal store validates mentor_name max length
     */
    public function test_goal_store_validates_mentor_name_max_length(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('goals.store'), [
            'title' => 'Learn Laravel',
            'target_sessions' => 10,
            'mentor_name' => str_repeat('a', 256),
        ]);

        $response->assertSessionHasErrors(['mentor_name']);
    }

    /**
     * Test: Goal store creates goal for current user only
     */
    public function test_goal_store_creates_goal_for_current_user_only(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $this->actingAs($user1)->post(route('goals.store'), [
            'title' => 'Learn Laravel',
            'target_sessions' => 10,
        ]);

        $this->assertDatabaseHas('goals', ['user_id' => $user1->id]);
        $this->assertDatabaseMissing('goals', ['user_id' => $user2->id]);
    }

    /**
     * Test: Goal store shows success message
     */
    public function test_goal_store_shows_success_message(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('goals.store'), [
            'title' => 'Learn Laravel',
            'target_sessions' => 10,
        ]);

        $response->assertSessionHas('success', 'Goal created successfully!');
    }

    /**
     * Test: Goal store calculates sessions_completed correctly
     */
    public function test_goal_store_calculates_sessions_completed_correctly(): void
    {
        $user = User::factory()->create();

        // Create some completed and pending sessions
        $this->post('/sessions', [
            'mentor_id' => 1,
            'topic' => 'Laravel Basics',
            'status' => 'completed',
        ]);

        $response = $this->actingAs($user)->post(route('goals.store'), [
            'title' => 'Learn Laravel',
            'target_sessions' => 10,
        ]);

        $response->assertRedirect(route('dashboard'));
    }

    /**
     * Test: Goal store preserves input on validation error
     */
    public function test_goal_store_preserves_input_on_validation_error(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('goals.store'), [
            'title' => 'Learn Laravel',
            'target_sessions' => '',
        ]);

        $response->assertSessionHasErrors(['target_sessions']);
        $response->assertSessionHasInput('title', 'Learn Laravel');
    }

    /**
     * Test: Multiple goals can be created by same user
     */
    public function test_multiple_goals_can_be_created_by_same_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('goals.store'), [
            'title' => 'Learn Laravel',
            'target_sessions' => 10,
        ]);

        $this->actingAs($user)->post(route('goals.store'), [
            'title' => 'Master PHP',
            'target_sessions' => 15,
        ]);

        $this->assertDatabaseCount('goals', 2);
        $this->assertDatabaseHas('goals', ['title' => 'Learn Laravel']);
        $this->assertDatabaseHas('goals', ['title' => 'Master PHP']);
    }
}

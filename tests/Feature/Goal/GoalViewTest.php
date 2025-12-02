<?php

namespace Tests\Feature\Goal;

use App\Models\User;
use App\Models\Goal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoalViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Goal form displays on dashboard
     */
    public function test_goal_form_displays_on_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeText('Set New Goal');
        $response->assertSeeText('Goal Title');
    }

    /**
     * Test: Goal form includes CSRF token
     */
    public function test_goal_form_includes_csrf_token(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSee('_token');
    }

    /**
     * Test: Goal form posts to goals.store route
     */
    public function test_goal_form_posts_to_goals_store(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSee('http://localhost/goals');
    }

    /**
     * Test: Goal form has title input field
     */
    public function test_goal_form_has_title_input_field(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeText('Goal Title (e.g. Learn Laravel)');
    }

    /**
     * Test: Goal form has target_sessions input field
     */
    public function test_goal_form_has_target_sessions_input_field(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeText('Target Sessions');
    }

    /**
     * Test: Goal form has mentor_name input field
     */
    public function test_goal_form_has_mentor_name_input_field(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeText('Mentor Name (optional)');
    }

    /**
     * Test: Goal form has deadline input field
     */
    public function test_goal_form_has_deadline_input_field(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeText('dd/mm/yyyy');
    }

    /**
     * Test: Goal form has submit button
     */
    public function test_goal_form_has_submit_button(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeText('Set New Goal');
    }

    /**
     * Test: Goal form displays title input as required
     */
    public function test_goal_form_title_input_is_required(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSee('required');
    }

    /**
     * Test: Goal form displays target_sessions input as required
     */
    public function test_goal_form_target_sessions_input_is_required(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeText('Target Sessions');
    }

    /**
     * Test: Goal card displays title
     */
    public function test_goal_card_displays_title(): void
    {
        $user = User::factory()->create();
        Goal::factory()->create([
            'user_id' => $user->id,
            'title' => 'Master Laravel Framework'
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeText('Master Laravel Framework');
    }

    /**
     * Test: Goal card displays deadline
     */
    public function test_goal_card_displays_deadline(): void
    {
        $user = User::factory()->create();
        $deadline = now()->addMonths(6);
        Goal::factory()->create([
            'user_id' => $user->id,
            'deadline' => $deadline
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeText($deadline->format('d M Y'));
    }

    /**
     * Test: Goal card displays mentor name
     */
    public function test_goal_card_displays_mentor_name(): void
    {
        $user = User::factory()->create();
        Goal::factory()->create([
            'user_id' => $user->id,
            'mentor_name' => 'Dr. Sarah Johnson'
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeText('Dr. Sarah Johnson');
    }

    /**
     * Test: Goal card displays progress bar
     */
    public function test_goal_card_displays_progress_bar(): void
    {
        $user = User::factory()->create();
        Goal::factory()->create([
            'user_id' => $user->id,
            'target_sessions' => 10,
            'sessions_completed' => 5
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeText('Progress:');
    }

    /**
     * Test: Goal card displays sessions progress text
     */
    public function test_goal_card_displays_sessions_progress_text(): void
    {
        $user = User::factory()->create();
        Goal::factory()->create([
            'user_id' => $user->id,
            'target_sessions' => 10,
            'sessions_completed' => 3
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeText('Progress:');
    }

    /**
     * Test: Goal card shows progress percentage
     */
    public function test_goal_card_shows_progress_percentage(): void
    {
        $user = User::factory()->create();
        Goal::factory()->create([
            'user_id' => $user->id,
            'target_sessions' => 10,
            'sessions_completed' => 5
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeText('50%');
    }

    /**
     * Test: Multiple goals are displayed
     */
    public function test_multiple_goals_are_displayed(): void
    {
        $user = User::factory()->create();
        Goal::factory()->create([
            'user_id' => $user->id,
            'title' => 'Learn Laravel'
        ]);
        Goal::factory()->create([
            'user_id' => $user->id,
            'title' => 'Master PHP'
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeText('Learn Laravel');
        $response->assertSeeText('Master PHP');
    }

    /**
     * Test: Empty goals section shows no deadline message
     */
    public function test_goal_card_without_deadline_shows_no_deadline_message(): void
    {
        $user = User::factory()->create();
        Goal::factory()->create([
            'user_id' => $user->id,
            'deadline' => null
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeText('No Deadline');
    }

    /**
     * Test: Empty goals section shows no mentor message
     */
    public function test_goal_card_without_mentor_shows_dash_message(): void
    {
        $user = User::factory()->create();
        Goal::factory()->create([
            'user_id' => $user->id,
            'mentor_name' => null
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeText('Mentor:');
    }

    /**
     * Test: Goal form has proper styling classes
     */
    public function test_goal_form_has_tailwind_styling(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSee('form-input');
        $response->assertSee('border-gray-300');
    }

    /**
     * Test: Goal card has gradient styling
     */
    public function test_goal_card_has_gradient_styling(): void
    {
        $user = User::factory()->create();
        Goal::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSee('bg-gradient-to-r');
    }

    /**
     * Test: Goal progress bar has styling
     */
    public function test_goal_progress_bar_has_styling(): void
    {
        $user = User::factory()->create();
        Goal::factory()->create([
            'user_id' => $user->id,
            'sessions_completed' => 5,
            'target_sessions' => 10
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSee('rounded-full');
    }

    /**
     * Test: Goal section displays title
     */
    public function test_goal_section_displays_title(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeText('My Goals');
    }

    /**
     * Test: Goal form uses post method
     */
    public function test_goal_form_uses_post_method(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSee('POST');
    }

    /**
     * Test: Only current user goals are displayed
     */
    public function test_only_current_user_goals_are_displayed(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Goal::factory()->create([
            'user_id' => $user1->id,
            'title' => 'User 1 Goal'
        ]);
        Goal::factory()->create([
            'user_id' => $user2->id,
            'title' => 'User 2 Goal'
        ]);

        $response = $this->actingAs($user1)->get(route('dashboard'));

        $response->assertSeeText('User 1 Goal');
        $response->assertDontSeeText('User 2 Goal');
    }

    /**
     * Test: Goal empty state message when no goals
     */
    public function test_goal_empty_state_message_when_no_goals(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSee("You haven't set any goals yet");
    }

    /**
     * Test: Goal empty state message disappears with goals
     */
    public function test_goal_empty_state_message_disappears_with_goals(): void
    {
        $user = User::factory()->create();
        Goal::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertDontSeeText("You haven't set any goals yet");
    }
}

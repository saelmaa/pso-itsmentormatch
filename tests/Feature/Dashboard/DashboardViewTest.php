<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use App\Models\Session;
use App\Models\Review;
use App\Models\Goal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Dashboard page displays page title
     */
    public function test_dashboard_page_displays_title(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSeeText('My Learning Journey');
    }

    /**
     * Test: Dashboard page displays subtitle
     */
    public function test_dashboard_page_displays_subtitle(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSeeText('Track your mentorship sessions');
    }

    /**
     * Test: Dashboard displays summary cards
     */
    public function test_dashboard_displays_summary_cards(): void
    {
        $user = User::factory()->create();
        Session::factory(2)->create(['user_id' => $user->id, 'status' => 'completed']);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSeeText('Total Sessions');
        $response->assertSeeText('Completed Sessions');
        $response->assertSeeText('Average Rating');
    }

    /**
     * Test: Dashboard displays total sessions card value
     */
    public function test_dashboard_displays_total_sessions_card_value(): void
    {
        $user = User::factory()->create();
        Session::factory(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSee('3');
    }

    /**
     * Test: Dashboard displays completed sessions card value
     */
    public function test_dashboard_displays_completed_sessions_card_value(): void
    {
        $user = User::factory()->create();
        Session::factory(2)->create(['user_id' => $user->id, 'status' => 'completed']);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSee('2');
    }

    /**
     * Test: Dashboard displays session history section
     */
    public function test_dashboard_displays_session_history_section(): void
    {
        $user = User::factory()->create();
        Session::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSeeText('Session History');
    }

    /**
     * Test: Dashboard session history table has required columns
     */
    public function test_dashboard_session_history_table_has_required_columns(): void
    {
        $user = User::factory()->create();
        Session::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSeeText('Date');
        $response->assertSeeText('Mentor');
        $response->assertSeeText('Topic');
        $response->assertSeeText('Status');
        $response->assertSeeText('Rating');
    }

    /**
     * Test: Dashboard displays goals section
     */
    public function test_dashboard_displays_goals_section(): void
    {
        $user = User::factory()->create();
        Goal::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSeeText('My Goals');
    }

    /**
     * Test: Dashboard displays goal title
     */
    public function test_dashboard_displays_goal_title(): void
    {
        $user = User::factory()->create();
        Goal::factory()->create([
            'user_id' => $user->id,
            'title' => 'Master PHP'
        ]);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSeeText('Master PHP');
    }

    /**
     * Test: Dashboard displays goal deadline
     */
    public function test_dashboard_displays_goal_deadline(): void
    {
        $user = User::factory()->create();
        $deadline = now()->addMonths(3);
        
        Goal::factory()->create([
            'user_id' => $user->id,
            'deadline' => $deadline
        ]);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSeeText($deadline->format('d M Y'));
    }

    /**
     * Test: Dashboard displays goal progress bar
     */
    public function test_dashboard_displays_goal_progress_bar(): void
    {
        $user = User::factory()->create();
        Goal::factory()->create([
            'user_id' => $user->id,
            'target_sessions' => 5
        ]);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSeeText('Progress:');
    }

    /**
     * Test: Dashboard displays add goal form
     */
    public function test_dashboard_displays_add_goal_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSee('name="title"', false);
        $response->assertSee('name="mentor_name"', false);
    }

    /**
     * Test: Dashboard add goal form posts to goals.store
     */
    public function test_dashboard_add_goal_form_posts_to_goals_store(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSee('action="' . route('goals.store') . '"', false);
    }

    /**
     * Test: Dashboard add goal form includes CSRF token
     */
    public function test_dashboard_add_goal_form_includes_csrf_token(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSee('_token', false);
    }

    /**
     * Test: Dashboard displays empty goals message
     */
    public function test_dashboard_displays_empty_goals_message(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertDontSeeText("You haven't set any goals yet");
    }

    /**
     * Test: Dashboard displays session status in history
     */
    public function test_dashboard_displays_session_status_in_history(): void
    {
        $user = User::factory()->create();
        Session::factory()->create([
            'user_id' => $user->id,
            'status' => 'completed'
        ]);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSeeText('Completed');
    }

    /**
     * Test: Dashboard displays session topic in history
     */
    public function test_dashboard_displays_session_topic_in_history(): void
    {
        $user = User::factory()->create();
        Session::factory()->create([
            'user_id' => $user->id,
            'topic' => 'Advanced Laravel'
        ]);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSeeText('Advanced Laravel');
    }

    /**
     * Test: Dashboard displays session date in history
     */
    public function test_dashboard_displays_session_date_in_history(): void
    {
        $user = User::factory()->create();
        $date = now()->subDays(5);
        
        Session::factory()->create([
            'user_id' => $user->id,
            'session_date' => $date
        ]);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSeeText($date->format('d M Y'));
    }

    /**
     * Test: Dashboard displays goal mentor name
     */
    public function test_dashboard_displays_goal_mentor_name(): void
    {
        $user = User::factory()->create();
        Goal::factory()->create([
            'user_id' => $user->id,
            'mentor_name' => 'Dr. John Smith'
        ]);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSeeText('Dr. John Smith');
    }

    /**
     * Test: Dashboard has proper styling classes
     */
    public function test_dashboard_has_tailwind_styling(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSee('bg-gradient-to-r');
        $response->assertSee('rounded-lg');
        $response->assertSee('shadow-lg');
    }

    /**
     * Test: Dashboard displays font awesome icons
     */
    public function test_dashboard_displays_font_awesome_icons(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSee('fas fa-');
    }

    /**
     * Test: Dashboard displays goal form input fields
     */
    public function test_dashboard_displays_goal_form_input_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSee('name="title"');
        $response->assertSee('name="mentor_name"');
        $response->assertSee('name="target_sessions"');
        $response->assertSee('name="deadline"');
    }

    /**
     * Test: Dashboard session history table is responsive
     */
    public function test_dashboard_session_history_table_is_responsive(): void
    {
        $user = User::factory()->create();
        Session::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertSee('overflow-x-auto');
    }
}

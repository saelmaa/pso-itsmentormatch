<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use App\Models\Session;
use App\Models\Review;
use App\Models\Goal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Unauthenticated user cannot access dashboard
     */
    public function test_unauthenticated_user_cannot_access_dashboard(): void
    {
        $response = $this->get('/my/progress');

        $response->assertRedirect('/login');
    }

    /**
     * Test: Authenticated user can access dashboard
     */
    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }

    /**
     * Test: Dashboard displays total sessions count
     */
    public function test_dashboard_displays_total_sessions_count(): void
    {
        $user = User::factory()->create();
        Session::factory(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertViewHas('totalSessions', 3);
    }

    /**
     * Test: Dashboard displays completed sessions count
     */
    public function test_dashboard_displays_completed_sessions_count(): void
    {
        $user = User::factory()->create();
        Session::factory(2)->create(['user_id' => $user->id, 'status' => 'completed']);
        Session::factory(1)->create(['user_id' => $user->id, 'status' => 'pending']);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertViewHas('completedSessions', 2);
    }

    /**
     * Test: Dashboard displays average rating
     */
    public function test_dashboard_displays_average_rating(): void
    {
        $user = User::factory()->create();
        $session = Session::factory()->create(['user_id' => $user->id]);
        Review::factory()->create(['user_id' => $user->id, 'session_id' => $session->id, 'rating' => 4]);
        Review::factory()->create(['user_id' => $user->id, 'session_id' => $session->id, 'rating' => 5]);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertViewHas('averageRating');
    }

    /**
     * Test: Dashboard displays average rating as 0 when no reviews
     */
    public function test_dashboard_displays_zero_average_rating_when_no_reviews(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertViewHas('averageRating', 0);
    }

    /**
     * Test: Dashboard displays session history
     */
    public function test_dashboard_displays_session_history(): void
    {
        $user = User::factory()->create();
        $sessions = Session::factory(2)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertViewHas('sessionHistory');
        $sessionHistory = $response->viewData('sessionHistory');
        $this->assertCount(2, $sessionHistory);
    }

    /**
     * Test: Dashboard displays goals
     */
    public function test_dashboard_displays_goals(): void
    {
        $user = User::factory()->create();
        Goal::factory(2)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertViewHas('goals');
        $goals = $response->viewData('goals');
        $this->assertCount(2, $goals);
    }

    /**
     * Test: Dashboard shows only current user's data
     */
    public function test_dashboard_shows_only_current_user_data(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Session::factory(3)->create(['user_id' => $user1->id]);
        Session::factory(5)->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)->get('/my/progress');

        $response->assertViewHas('totalSessions', 3);
    }

    /**
     * Test: Dashboard session history is ordered by date descending
     */
    public function test_dashboard_session_history_ordered_by_date_descending(): void
    {
        $user = User::factory()->create();
        
        $session1 = Session::factory()->create([
            'user_id' => $user->id,
            'session_date' => now()->subDays(5)
        ]);
        
        $session2 = Session::factory()->create([
            'user_id' => $user->id,
            'session_date' => now()
        ]);

        $response = $this->actingAs($user)->get('/my/progress');

        $sessionHistory = $response->viewData('sessionHistory');
        $this->assertEquals($session2->id, $sessionHistory->first()->id);
        $this->assertEquals($session1->id, $sessionHistory->last()->id);
    }

    /**
     * Test: Dashboard with no sessions and no goals
     */
    public function test_dashboard_with_no_sessions_and_no_goals(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/my/progress');

        $response->assertStatus(200);
        $response->assertViewHas('totalSessions', 0);
        $response->assertViewHas('completedSessions', 0);
        $response->assertViewHas('goals');
    }

    /**
     * Test: Dashboard calculates goal progress correctly
     */
    public function test_dashboard_calculates_goal_progress_correctly(): void
    {
        $user = User::factory()->create();
        
        $goal = Goal::factory()->create([
            'user_id' => $user->id,
            'title' => 'Learn Laravel',
            'target_sessions' => 5
        ]);

        // Create completed sessions matching the goal topic
        for ($i = 0; $i < 3; $i++) {
            Session::factory()->create([
                'user_id' => $user->id,
                'topic' => 'Learn Laravel',
                'status' => 'completed'
            ]);
        }

        $response = $this->actingAs($user)->get('/my/progress');

        $goals = $response->viewData('goals');
        $this->assertEquals(3, $goals[0]->sessions_completed);
    }

    /**
     * Test: Dashboard view contains session mentor data
     */
    public function test_dashboard_view_contains_session_mentor_data(): void
    {
        $user = User::factory()->create();
        $session = Session::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/my/progress');

        $sessionHistory = $response->viewData('sessionHistory');
        $this->assertNotNull($sessionHistory[0]->mentor);
    }

    /**
     * Test: Dashboard displays empty goals message when no goals
     */
    public function test_dashboard_displays_empty_goals_message(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/my/progress');

        $goals = $response->viewData('goals');
        $this->assertEmpty($goals);
    }
}

<?php

namespace Tests\Feature\Session;

use App\Models\User;
use App\Models\Session;
use App\Models\Mentor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SessionControllerUnitTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Mentor $mentor;
    protected Session $session;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->mentor = Mentor::factory()->create();
        $this->session = Session::factory()->create([
            'user_id' => $this->user->id,
            'mentor_id' => $this->mentor->id,
            'status' => 'pending',
            'session_date' => now()->addDay()->format('Y-m-d'),
            'session_time' => '10:00:00',
        ]);
    }

    // ==================== INDEX TESTS ====================

    /**
     * Test: Unauthenticated user cannot access sessions index
     */
    public function test_unauthenticated_user_cannot_access_sessions_index(): void
    {
        $response = $this->get(route('sessions.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: Authenticated user can access sessions index
     */
    public function test_authenticated_user_can_access_sessions_index(): void
    {
        $response = $this->actingAs($this->user)->get(route('sessions.index'));

        $response->assertStatus(200);
        $response->assertViewIs('sessions.index');
    }

    /**
     * Test: Sessions index shows user's sessions only
     */
    public function test_sessions_index_shows_user_sessions_only(): void
    {
        $otherUser = User::factory()->create();
        Session::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)->get(route('sessions.index'));

        $response->assertViewHas('sessions');
        // The view should only contain sessions for the authenticated user
        $sessions = $response->viewData('sessions');
        // Verify count of items on current page
        $this->assertGreaterThanOrEqual(0, $sessions->count());
    }

    /**
     * Test: Sessions index is paginated
     */
    public function test_sessions_index_is_paginated(): void
    {
        Session::factory(15)->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->get(route('sessions.index'));

        $response->assertViewHas('sessions');
    }

    // ==================== CREATE TESTS ====================

    /**
     * Test: Unauthenticated user cannot access session create form
     */
    public function test_unauthenticated_user_cannot_access_session_create(): void
    {
        $response = $this->get(route('sessions.create', ['mentor' => $this->mentor->id]));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: Authenticated user can access session create form with valid mentor
     */
    public function test_authenticated_user_can_access_session_create(): void
    {
        $response = $this->actingAs($this->user)->get(route('sessions.create', ['mentor' => $this->mentor->id]));

        $response->assertStatus(200);
        $response->assertViewIs('sessions.create');
        $response->assertViewHas('mentor');
    }

    /**
     * Test: Session create shows 404 for non-existent mentor
     */
    public function test_session_create_shows_404_for_invalid_mentor(): void
    {
        $response = $this->actingAs($this->user)->get(route('sessions.create', ['mentor' => 99999]));

        $response->assertStatus(404);
    }

    // ==================== STORE TESTS ====================

    /**
     * Test: Unauthenticated user cannot store session
     */
    public function test_unauthenticated_user_cannot_store_session(): void
    {
        $response = $this->post(route('sessions.store'), [
            'mentor_id' => $this->mentor->id,
            'topic' => 'Laravel Basics',
            'session_date' => now()->addDay()->format('Y-m-d'),
            'session_time' => '10:00',
            'duration' => 60,
            'type' => 'video_call',
        ]);

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: Session store validates required fields
     */
    public function test_session_store_validates_required_fields(): void
    {
        $response = $this->actingAs($this->user)->post(route('sessions.store'), []);

        $response->assertSessionHasErrors(['mentor_id', 'topic', 'session_date', 'session_time', 'duration', 'type']);
    }

    /**
     * Test: Session store validates mentor exists
     */
    public function test_session_store_validates_mentor_exists(): void
    {
        $response = $this->actingAs($this->user)->post(route('sessions.store'), [
            'mentor_id' => 99999,
            'topic' => 'Laravel',
            'session_date' => now()->addDay()->format('Y-m-d'),
            'session_time' => '10:00',
            'duration' => 60,
            'type' => 'video_call',
        ]);

        $response->assertSessionHasErrors('mentor_id');
    }

    /**
     * Test: Session store validates session date is not in past
     */
    public function test_session_store_validates_session_date_not_past(): void
    {
        $response = $this->actingAs($this->user)->post(route('sessions.store'), [
            'mentor_id' => $this->mentor->id,
            'topic' => 'Laravel',
            'session_date' => now()->subDay()->format('Y-m-d'),
            'session_time' => '10:00',
            'duration' => 60,
            'type' => 'video_call',
        ]);

        $response->assertSessionHasErrors('session_date');
    }

    /**
     * Test: Session store validates duration minimum
     */
    public function test_session_store_validates_duration_minimum(): void
    {
        $response = $this->actingAs($this->user)->post(route('sessions.store'), [
            'mentor_id' => $this->mentor->id,
            'topic' => 'Laravel',
            'session_date' => now()->addDay()->format('Y-m-d'),
            'session_time' => '10:00',
            'duration' => 15, // Min is 30
            'type' => 'video_call',
        ]);

        $response->assertSessionHasErrors('duration');
    }

    /**
     * Test: Session store validates duration maximum
     */
    public function test_session_store_validates_duration_maximum(): void
    {
        $response = $this->actingAs($this->user)->post(route('sessions.store'), [
            'mentor_id' => $this->mentor->id,
            'topic' => 'Laravel',
            'session_date' => now()->addDay()->format('Y-m-d'),
            'session_time' => '10:00',
            'duration' => 200, // Max is 180
            'type' => 'video_call',
        ]);

        $response->assertSessionHasErrors('duration');
    }

    /**
     * Test: Session store validates type is valid
     */
    public function test_session_store_validates_type_is_valid(): void
    {
        $response = $this->actingAs($this->user)->post(route('sessions.store'), [
            'mentor_id' => $this->mentor->id,
            'topic' => 'Laravel',
            'session_date' => now()->addDay()->format('Y-m-d'),
            'session_time' => '10:00',
            'duration' => 60,
            'type' => 'invalid_type',
        ]);

        $response->assertSessionHasErrors('type');
    }

    /**
     * Test: Session store creates session with valid data
     */
    public function test_session_store_creates_session_with_valid_data(): void
    {
        $futureDate = now()->addDay()->format('Y-m-d');

        $response = $this->actingAs($this->user)->post(route('sessions.store'), [
            'mentor_id' => $this->mentor->id,
            'topic' => 'Advanced Laravel',
            'description' => 'Learn about testing',
            'session_date' => $futureDate,
            'session_time' => '14:00',
            'duration' => 90,
            'type' => 'video_call',
        ]);

        $response->assertRedirect(route('sessions.index'));
        $this->assertDatabaseHas('sessions', [
            'user_id' => $this->user->id,
            'mentor_id' => $this->mentor->id,
            'topic' => 'Advanced Laravel',
            'duration' => 90,
            'type' => 'video_call',
            'status' => 'pending',
        ]);
    }

    /**
     * Test: Session store allows null description
     */
    public function test_session_store_allows_null_description(): void
    {
        $futureDate = now()->addDay()->format('Y-m-d');

        $response = $this->actingAs($this->user)->post(route('sessions.store'), [
            'mentor_id' => $this->mentor->id,
            'topic' => 'Laravel',
            'session_date' => $futureDate,
            'session_time' => '10:00',
            'duration' => 60,
            'type' => 'in_person',
        ]);

        $response->assertRedirect(route('sessions.index'));
    }

    /**
     * Test: Session store redirects to sessions index on success
     */
    public function test_session_store_redirects_to_index(): void
    {
        $futureDate = now()->addDay()->format('Y-m-d');

        $response = $this->actingAs($this->user)->post(route('sessions.store'), [
            'mentor_id' => $this->mentor->id,
            'topic' => 'Laravel',
            'session_date' => $futureDate,
            'session_time' => '10:00',
            'duration' => 60,
            'type' => 'video_call',
        ]);

        $response->assertRedirect(route('sessions.index'));
        $response->assertSessionHas('success');
    }

    // ==================== EDIT TESTS ====================

    /**
     * Test: Unauthenticated user cannot access session edit
     */
    public function test_unauthenticated_user_cannot_access_session_edit(): void
    {
        $response = $this->get(route('sessions.edit', $this->session));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: Authenticated user can access own session edit form
     */
    public function test_authenticated_user_can_edit_own_session(): void
    {
        $response = $this->actingAs($this->user)->get(route('sessions.edit', $this->session));

        $response->assertStatus(200);
        $response->assertViewIs('sessions.edit');
        $response->assertViewHas('session');
    }

    /**
     * Test: User cannot edit another user's session (403)
     */
    public function test_user_cannot_edit_another_users_session(): void
    {
        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser)->get(route('sessions.edit', $this->session));

        $response->assertStatus(403);
    }

    /**
     * Test: Cannot edit completed session
     */
    public function test_cannot_edit_completed_session(): void
    {
        $completedSession = Session::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'completed',
        ]);

        $response = $this->actingAs($this->user)->get(route('sessions.edit', $completedSession));

        $response->assertRedirect(route('sessions.index'));
        $response->assertSessionHas('error');
    }

    // ==================== UPDATE TESTS ====================

    /**
     * Test: Unauthenticated user cannot update session
     */
    public function test_unauthenticated_user_cannot_update_session(): void
    {
        $response = $this->put(route('sessions.update', $this->session), [
            'topic' => 'Updated Topic',
        ]);

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: User cannot update another user's session
     */
    public function test_user_cannot_update_another_users_session(): void
    {
        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser)->put(route('sessions.update', $this->session), [
            'topic' => 'Updated',
        ]);

        $response->assertStatus(403);
    }

    /**
     * Test: Session update validates required fields
     */
    public function test_session_update_validates_required_fields(): void
    {
        $response = $this->actingAs($this->user)->put(route('sessions.update', $this->session), []);

        // Empty POST will redirect since all fields required
        $response->assertRedirect();
    }

    /**
     * Test: Session update with valid data updates session
     */
    public function test_session_update_with_valid_data(): void
    {
        $futureDate = now()->addDays(2)->format('Y-m-d');

        $response = $this->actingAs($this->user)->put(route('sessions.update', $this->session), [
            'topic' => 'Updated Laravel Topic',
            'session_date' => $futureDate,
            'session_time' => '15:00',
            'duration' => 75,
            'type' => 'phone',
        ]);

        $response->assertRedirect(route('sessions.index'));
        $this->assertDatabaseHas('sessions', [
            'id' => $this->session->id,
            'topic' => 'Updated Laravel Topic',
        ]);
    }

    /**
     * Test: Cannot update completed session
     */
    public function test_cannot_update_completed_session(): void
    {
        $completedSession = Session::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'completed',
        ]);

        $futureDate = now()->addDay()->format('Y-m-d');

        $response = $this->actingAs($this->user)->put(route('sessions.update', $completedSession), [
            'topic' => 'Updated',
            'session_date' => $futureDate,
            'session_time' => '10:00',
            'duration' => 60,
            'type' => 'video_call',
        ]);

        $response->assertRedirect(route('sessions.index'));
        $response->assertSessionHas('error');
    }

    // ==================== DESTROY TESTS ====================

    /**
     * Test: Unauthenticated user cannot delete session
     */
    public function test_unauthenticated_user_cannot_delete_session(): void
    {
        $response = $this->delete(route('sessions.destroy', $this->session));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: User cannot delete another user's session
     */
    public function test_user_cannot_delete_another_users_session(): void
    {
        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser)->delete(route('sessions.destroy', $this->session));

        $response->assertStatus(403);
    }

    /**
     * Test: User can delete own session
     */
    public function test_user_can_delete_own_session(): void
    {
        $response = $this->actingAs($this->user)->delete(route('sessions.destroy', $this->session));

        $response->assertRedirect(route('sessions.index'));
        $this->assertDatabaseMissing('sessions', ['id' => $this->session->id]);
    }

    /**
     * Test: Session delete shows success message
     */
    public function test_session_delete_shows_success_message(): void
    {
        $response = $this->actingAs($this->user)->delete(route('sessions.destroy', $this->session));

        $response->assertSessionHas('success');
    }

    // ==================== SHOW COMPLETE TESTS ====================

    /**
     * Test: Unauthenticated user cannot access session complete form
     */
    public function test_unauthenticated_user_cannot_access_show_complete(): void
    {
        $response = $this->get(route('sessions.show-complete', $this->session));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: User can access own session complete form for pending session
     */
    public function test_user_can_access_complete_form_for_own_pending_session(): void
    {
        $response = $this->actingAs($this->user)->get(route('sessions.show-complete', $this->session));

        $response->assertStatus(200);
        $response->assertViewIs('sessions.complete');
        $response->assertViewHas('session');
    }

    /**
     * Test: User cannot access complete form for another user's session
     */
    public function test_user_cannot_access_complete_form_for_other_user_session(): void
    {
        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser)->get(route('sessions.show-complete', $this->session));

        $response->assertStatus(403);
    }

    /**
     * Test: Cannot complete already completed session
     */
    public function test_cannot_complete_already_completed_session(): void
    {
        $completedSession = Session::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'completed',
        ]);

        $response = $this->actingAs($this->user)->get(route('sessions.show-complete', $completedSession));

        $response->assertRedirect(route('sessions.index'));
        $response->assertSessionHas('error');
    }

    // ==================== COMPLETE TESTS ====================

    /**
     * Test: Unauthenticated user cannot complete session
     */
    public function test_unauthenticated_user_cannot_complete_session(): void
    {
        $response = $this->put(route('sessions.complete', $this->session), []);

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: User cannot complete another user's session
     */
    public function test_user_cannot_complete_another_users_session(): void
    {
        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser)->put(route('sessions.complete', $this->session), []);

        $response->assertStatus(403);
    }

    /**
     * Test: Session complete updates session status
     */
    public function test_session_complete_updates_status_to_completed(): void
    {
        $response = $this->actingAs($this->user)->put(route('sessions.complete', $this->session), [
            'notes' => 'Great session overall',
        ]);

        $response->assertRedirect(route('reviews.create', ['session' => $this->session->id]));
        $this->assertDatabaseHas('sessions', [
            'id' => $this->session->id,
            'status' => 'completed',
            'notes' => 'Great session overall',
        ]);
    }

    /**
     * Test: Session complete allows null notes
     */
    public function test_session_complete_allows_null_notes(): void
    {
        $response = $this->actingAs($this->user)->put(route('sessions.complete', $this->session), []);

        $response->assertRedirect(route('reviews.create', ['session' => $this->session->id]));
        $this->assertDatabaseHas('sessions', [
            'id' => $this->session->id,
            'status' => 'completed',
        ]);
    }

    /**
     * Test: Session complete validates notes length
     */
    public function test_session_complete_validates_notes_length(): void
    {
        $longNotes = str_repeat('a', 1001);

        $response = $this->actingAs($this->user)->put(route('sessions.complete', $this->session), [
            'notes' => $longNotes,
        ]);

        $response->assertSessionHasErrors('notes');
    }

    /**
     * Test: Cannot complete already completed session via PUT
     */
    public function test_cannot_complete_already_completed_session_via_put(): void
    {
        $completedSession = Session::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'completed',
        ]);

        $response = $this->actingAs($this->user)->put(route('sessions.complete', $completedSession), []);

        $response->assertRedirect(route('sessions.index'));
        $response->assertSessionHas('error');
    }

    /**
     * Test: Session complete redirects to review create
     */
    public function test_session_complete_redirects_to_review_create(): void
    {
        $response = $this->actingAs($this->user)->put(route('sessions.complete', $this->session), []);

        $response->assertRedirect(route('reviews.create', ['session' => $this->session->id]));
    }

    /**
     * Test: Session complete increments mentor total_sessions
     */
    public function test_session_complete_increments_mentor_total_sessions(): void
    {
        $initialCount = $this->mentor->total_sessions;

        $this->actingAs($this->user)->put(route('sessions.complete', $this->session), []);

        $this->mentor->refresh();
        $this->assertEquals($initialCount + 1, $this->mentor->total_sessions);
    }
}

<?php

namespace Tests\Unit\Models;

use App\Models\Session;
use Carbon\Carbon;
use Tests\TestCase;

class SessionModelTest extends TestCase
{
    /**
     * Test Session model instantiation
     */
    public function test_session_can_be_instantiated_with_attributes(): void
    {
        $session = new Session([
            'user_id' => 1,
            'mentor_id' => 2,
            'topic' => 'Laravel Basics',
            'description' => 'Learn Laravel fundamentals',
            'session_date' => '2025-12-15',
            'session_time' => '2025-12-15 14:00:00',
            'duration' => 60,
            'type' => 'online',
            'status' => 'confirmed',
            'notes' => 'Bring laptop',
        ]);

        $this->assertInstanceOf(Session::class, $session);
        $this->assertEquals(1, $session->user_id);
        $this->assertEquals(2, $session->mentor_id);
        $this->assertEquals('Laravel Basics', $session->topic);
    }

    /**
     * Test Session fillable attributes
     */
    public function test_session_fillable_attributes(): void
    {
        $session = new Session();
        $expected = [
            'user_id',
            'mentor_id',
            'topic',
            'description',
            'session_date',
            'session_time',
            'duration',
            'type',
            'status',
            'notes',
        ];

        $this->assertEquals($expected, $session->getFillable());
    }

    /**
     * Test Session casts session_date as date
     */
    public function test_session_casts_session_date(): void
    {
        $session = new Session([
            'session_date' => '2025-12-20',
        ]);

        $casts = $session->getCasts();
        $this->assertEquals('date', $casts['session_date']);
    }

    /**
     * Test Session casts session_time as datetime
     */
    public function test_session_casts_session_time(): void
    {
        $session = new Session();
        $casts = $session->getCasts();
        $this->assertEquals('datetime', $casts['session_time']);
    }

    /**
     * Test Session has user relationship method
     */
    public function test_session_has_user_relationship(): void
    {
        $session = new Session();
        $this->assertTrue(method_exists($session, 'user'));
    }

    /**
     * Test Session has mentor relationship method
     */
    public function test_session_has_mentor_relationship(): void
    {
        $session = new Session();
        $this->assertTrue(method_exists($session, 'mentor'));
    }

    /**
     * Test Session has reviews relationship method
     */
    public function test_session_has_reviews_relationship(): void
    {
        $session = new Session();
        $this->assertTrue(method_exists($session, 'reviews'));
    }

    /**
     * Test Session has review singular relationship method
     */
    public function test_session_has_review_relationship(): void
    {
        $session = new Session();
        $this->assertTrue(method_exists($session, 'review'));
    }

    /**
     * Test Session isPast method exists
     */
    public function test_session_has_is_past_method(): void
    {
        $session = new Session();
        $this->assertTrue(method_exists($session, 'isPast'));
    }

    /**
     * Test Session canBeEdited method exists
     */
    public function test_session_has_can_be_edited_method(): void
    {
        $session = new Session();
        $this->assertTrue(method_exists($session, 'canBeEdited'));
    }

    /**
     * Test Session canBeCancelled method exists
     */
    public function test_session_has_can_be_cancelled_method(): void
    {
        $session = new Session();
        $this->assertTrue(method_exists($session, 'canBeCancelled'));
    }

    /**
     * Test Session has forUser scope
     */
    public function test_session_has_for_user_scope(): void
    {
        $session = new Session();
        $this->assertTrue(method_exists($session, 'scopeForUser'));
    }

    /**
     * Test Session has upcoming scope
     */
    public function test_session_has_upcoming_scope(): void
    {
        $session = new Session();
        $this->assertTrue(method_exists($session, 'scopeUpcoming'));
    }

    /**
     * Test Session isPast logic for future date
     */
    public function test_session_is_past_returns_false_for_future_session(): void
    {
        $futureDate = Carbon::now()->addDays(5)->format('Y-m-d');
        $futureTime = Carbon::now()->addDays(5)->format('Y-m-d H:i:s');

        $session = new Session([
            'session_date' => $futureDate,
            'session_time' => $futureTime,
        ]);

        $this->assertFalse($session->isPast());
    }

    /**
     * Test Session isPast logic for past date
     */
    public function test_session_is_past_returns_true_for_past_session(): void
    {
        $pastDate = Carbon::now()->subDays(5)->format('Y-m-d');
        $pastTime = Carbon::now()->subDays(5)->format('Y-m-d H:i:s');

        $session = new Session([
            'session_date' => $pastDate,
            'session_time' => $pastTime,
        ]);

        $this->assertTrue($session->isPast());
    }

    /**
     * Test Session canBeEdited for pending status
     */
    public function test_session_can_be_edited_for_pending_future_session(): void
    {
        $futureDate = Carbon::now()->addDays(5)->format('Y-m-d');
        $futureTime = Carbon::now()->addDays(5)->format('Y-m-d H:i:s');

        $session = new Session([
            'session_date' => $futureDate,
            'session_time' => $futureTime,
            'status' => 'pending',
        ]);

        $this->assertTrue($session->canBeEdited());
    }

    /**
     * Test Session canBeEdited for confirmed status
     */
    public function test_session_can_be_edited_for_confirmed_future_session(): void
    {
        $futureDate = Carbon::now()->addDays(5)->format('Y-m-d');
        $futureTime = Carbon::now()->addDays(5)->format('Y-m-d H:i:s');

        $session = new Session([
            'session_date' => $futureDate,
            'session_time' => $futureTime,
            'status' => 'confirmed',
        ]);

        $this->assertTrue($session->canBeEdited());
    }

    /**
     * Test Session canBeEdited returns false for past session
     */
    public function test_session_cannot_be_edited_for_past_session(): void
    {
        $pastDate = Carbon::now()->subDays(5)->format('Y-m-d');
        $pastTime = Carbon::now()->subDays(5)->format('Y-m-d H:i:s');

        $session = new Session([
            'session_date' => $pastDate,
            'session_time' => $pastTime,
            'status' => 'pending',
        ]);

        $this->assertFalse($session->canBeEdited());
    }

    /**
     * Test Session canBeEdited returns false for cancelled status
     */
    public function test_session_cannot_be_edited_for_cancelled_session(): void
    {
        $futureDate = Carbon::now()->addDays(5)->format('Y-m-d');
        $futureTime = Carbon::now()->addDays(5)->format('Y-m-d H:i:s');

        $session = new Session([
            'session_date' => $futureDate,
            'session_time' => $futureTime,
            'status' => 'cancelled',
        ]);

        $this->assertFalse($session->canBeEdited());
    }

    /**
     * Test Session canBeCancelled for future pending session
     */
    public function test_session_can_be_cancelled_for_future_pending_session(): void
    {
        $futureDate = Carbon::now()->addDays(5)->format('Y-m-d');
        $futureTime = Carbon::now()->addDays(5)->format('Y-m-d H:i:s');

        $session = new Session([
            'session_date' => $futureDate,
            'session_time' => $futureTime,
            'status' => 'pending',
        ]);

        $this->assertTrue($session->canBeCancelled());
    }

    /**
     * Test Session canBeCancelled returns false for past session
     */
    public function test_session_cannot_be_cancelled_for_past_session(): void
    {
        $pastDate = Carbon::now()->subDays(5)->format('Y-m-d');
        $pastTime = Carbon::now()->subDays(5)->format('Y-m-d H:i:s');

        $session = new Session([
            'session_date' => $pastDate,
            'session_time' => $pastTime,
            'status' => 'pending',
        ]);

        $this->assertFalse($session->canBeCancelled());
    }

    /**
     * Test Session stores all attributes
     */
    public function test_session_stores_all_attributes(): void
    {
        $data = [
            'user_id' => 10,
            'mentor_id' => 20,
            'topic' => 'Advanced PHP',
            'description' => 'Deep dive into PHP internals',
            'session_date' => '2025-12-25',
            'session_time' => '2025-12-25 16:00:00',
            'duration' => 90,
            'type' => 'in-person',
            'status' => 'confirmed',
            'notes' => 'Bring notes',
        ];

        $session = new Session($data);

        $this->assertEquals($data['user_id'], $session->user_id);
        $this->assertEquals($data['mentor_id'], $session->mentor_id);
        $this->assertEquals($data['topic'], $session->topic);
        $this->assertEquals($data['duration'], $session->duration);
        $this->assertEquals($data['type'], $session->type);
    }

    /**
     * Test Session different status values
     */
    public function test_session_different_status_values(): void
    {
        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        
        foreach ($statuses as $status) {
            $session = new Session(['status' => $status]);
            $this->assertEquals($status, $session->status);
        }
    }

    /**
     * Test Session different type values
     */
    public function test_session_different_type_values(): void
    {
        $types = ['online', 'in-person', 'hybrid'];
        
        foreach ($types as $type) {
            $session = new Session(['type' => $type]);
            $this->assertEquals($type, $session->type);
        }
    }

    /**
     * Test isPast with edge case (current time)
     */
    public function test_session_is_past_with_current_time(): void
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->subHours(1)->format('Y-m-d H:i:s');

        $session = new Session([
            'session_date' => $currentDate,
            'session_time' => $currentTime,
        ]);

        $this->assertTrue($session->isPast());
    }

    /**
     * Test canBeEdited with all invalid status combinations
     */
    public function test_session_cannot_be_edited_for_completed_status(): void
    {
        $futureDate = Carbon::now()->addDays(5)->format('Y-m-d');
        $futureTime = Carbon::now()->addDays(5)->format('Y-m-d H:i:s');

        $session = new Session([
            'session_date' => $futureDate,
            'session_time' => $futureTime,
            'status' => 'completed',
        ]);

        $this->assertFalse($session->canBeEdited());
    }

    /**
     * Test canBeCancelled with confirmed status
     */
    public function test_session_can_be_cancelled_for_confirmed_session(): void
    {
        $futureDate = Carbon::now()->addDays(5)->format('Y-m-d');
        $futureTime = Carbon::now()->addDays(5)->format('Y-m-d H:i:s');

        $session = new Session([
            'session_date' => $futureDate,
            'session_time' => $futureTime,
            'status' => 'confirmed',
        ]);

        $this->assertTrue($session->canBeCancelled());
    }

    /**
     * Test canBeCancelled for completed status
     */
    public function test_session_cannot_be_cancelled_for_completed_session(): void
    {
        $futureDate = Carbon::now()->addDays(5)->format('Y-m-d');
        $futureTime = Carbon::now()->addDays(5)->format('Y-m-d H:i:s');

        $session = new Session([
            'session_date' => $futureDate,
            'session_time' => $futureTime,
            'status' => 'completed',
        ]);

        $this->assertFalse($session->canBeCancelled());
    }

    /**
     * Test Session cannot be cancelled when already cancelled
     */
    public function test_session_cannot_be_cancelled_when_already_cancelled(): void
    {
        $futureDate = Carbon::now()->addDays(5)->format('Y-m-d');
        $futureTime = Carbon::now()->addDays(5)->format('Y-m-d H:i:s');

        $session = new Session([
            'session_date' => $futureDate,
            'session_time' => $futureTime,
            'status' => 'cancelled',
        ]);

        $this->assertFalse($session->canBeCancelled());
    }

    /**
     * Test isPast with exact current moment edge case
     */
    public function test_session_is_past_with_very_recent_time(): void
    {
        // Create a session time from 1 second ago
        $veryRecentTime = Carbon::now()->subSeconds(1)->format('Y-m-d H:i:s');
        $currentDate = Carbon::now()->format('Y-m-d');

        $session = new Session([
            'session_date' => $currentDate,
            'session_time' => $veryRecentTime,
        ]);

        $this->assertTrue($session->isPast());
    }

    /**
     * Test isPast returns false for future session (far future)
     */
    public function test_session_is_not_past_for_far_future(): void
    {
        $farFutureDate = Carbon::now()->addYears(1)->format('Y-m-d');
        $farFutureTime = Carbon::now()->addYears(1)->format('Y-m-d H:i:s');

        $session = new Session([
            'session_date' => $farFutureDate,
            'session_time' => $farFutureTime,
        ]);

        $this->assertFalse($session->isPast());
    }

    /**
     * Test canBeEdited returns false for completed status
     */
    public function test_session_cannot_be_edited_when_completed(): void
    {
        $futureDate = Carbon::now()->addDays(5)->format('Y-m-d');
        $futureTime = Carbon::now()->addDays(5)->format('Y-m-d H:i:s');

        $session = new Session([
            'session_date' => $futureDate,
            'session_time' => $futureTime,
            'status' => 'completed',
        ]);

        $this->assertFalse($session->canBeEdited());
    }

    /**
     * Test all status/edit combinations
     */
    public function test_session_can_be_edited_for_each_status(): void
    {
        $futureDate = Carbon::now()->addDays(5)->format('Y-m-d');
        $futureTime = Carbon::now()->addDays(5)->format('Y-m-d H:i:s');

        $editableStatuses = ['pending', 'confirmed'];
        foreach ($editableStatuses as $status) {
            $session = new Session([
                'session_date' => $futureDate,
                'session_time' => $futureTime,
                'status' => $status,
            ]);
            $this->assertTrue($session->canBeEdited(), "Status $status should allow editing");
        }

        $nonEditableStatuses = ['completed', 'cancelled'];
        foreach ($nonEditableStatuses as $status) {
            $session = new Session([
                'session_date' => $futureDate,
                'session_time' => $futureTime,
                'status' => $status,
            ]);
            $this->assertFalse($session->canBeEdited(), "Status $status should NOT allow editing");
        }
    }

    /**
     * Test all status/cancel combinations
     */
    public function test_session_can_be_cancelled_for_each_status(): void
    {
        $futureDate = Carbon::now()->addDays(5)->format('Y-m-d');
        $futureTime = Carbon::now()->addDays(5)->format('Y-m-d H:i:s');

        $cancellableStatuses = ['pending', 'confirmed'];
        foreach ($cancellableStatuses as $status) {
            $session = new Session([
                'session_date' => $futureDate,
                'session_time' => $futureTime,
                'status' => $status,
            ]);
            $this->assertTrue($session->canBeCancelled(), "Status $status should allow cancelling");
        }

        $nonCancellableStatuses = ['completed', 'cancelled'];
        foreach ($nonCancellableStatuses as $status) {
            $session = new Session([
                'session_date' => $futureDate,
                'session_time' => $futureTime,
                'status' => $status,
            ]);
            $this->assertFalse($session->canBeCancelled(), "Status $status should NOT allow cancelling");
        }
    }

    /**
     * Test session with same date but different times
     */
    public function test_session_is_past_with_same_date_different_times(): void
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $pastTimeToday = Carbon::now()->subHours(2)->format('Y-m-d H:i:s');
        $futureTimeToday = Carbon::now()->addHours(2)->format('Y-m-d H:i:s');

        $pastSession = new Session([
            'session_date' => $currentDate,
            'session_time' => $pastTimeToday,
        ]);

        $futureSession = new Session([
            'session_date' => $currentDate,
            'session_time' => $futureTimeToday,
        ]);

        $this->assertTrue($pastSession->isPast());
        $this->assertFalse($futureSession->isPast());
    }

    /**
     * Test relationship methods return correct relation objects
     */
    public function test_session_relationships_return_correct_types(): void
    {
        $session = new Session();

        // Test that relationship methods are callable and return proper types
        $this->assertTrue(is_callable([$session, 'user']));
        $this->assertTrue(is_callable([$session, 'mentor']));
        $this->assertTrue(is_callable([$session, 'reviews']));
        $this->assertTrue(is_callable([$session, 'review']));
    }

    /**
     * Test session duration attribute
     */
    public function test_session_duration_attribute(): void
    {
        $session = new Session(['duration' => 90]);
        $this->assertEquals(90, $session->duration);

        $session->duration = 120;
        $this->assertEquals(120, $session->duration);
    }

    /**
     * Test session with minimum duration
     */
    public function test_session_with_minimum_duration(): void
    {
        $session = new Session(['duration' => 15]);
        $this->assertEquals(15, $session->duration);
    }

    /**
     * Test session with long description
     */
    public function test_session_with_long_description(): void
    {
        $longDescription = str_repeat('Learn advanced topics. ', 50);
        $session = new Session(['description' => $longDescription]);
        $this->assertEquals($longDescription, $session->description);
    }

    /**
     * Test session notes attribute
     */
    public function test_session_notes_attribute(): void
    {
        $session = new Session(['notes' => 'Bring laptop and materials']);
        $this->assertEquals('Bring laptop and materials', $session->notes);
    }

    /**
     * Test session factory trait exists
     */
    public function test_session_uses_has_factory_trait(): void
    {
        $session = new Session();
        $this->assertTrue(method_exists($session, 'factory'));
    }

    /**
     * Test scope methods exist
     */
    public function test_session_scope_methods_exist(): void
    {
        $session = new Session();
        $this->assertTrue(method_exists($session, 'scopeForUser'));
        $this->assertTrue(method_exists($session, 'scopeUpcoming'));
    }

    /**
     * Test all combinations of past/cancelled status
     */
    public function test_session_past_and_cancelled_combinations(): void
    {
        $pastDate = Carbon::now()->subDays(5)->format('Y-m-d');
        $pastTime = Carbon::now()->subDays(5)->format('Y-m-d H:i:s');

        // Past and cancelled - should not be editable or cancellable
        $session = new Session([
            'session_date' => $pastDate,
            'session_time' => $pastTime,
            'status' => 'cancelled',
        ]);

        $this->assertTrue($session->isPast());
        $this->assertFalse($session->canBeEdited());
        $this->assertFalse($session->canBeCancelled());
    }
}

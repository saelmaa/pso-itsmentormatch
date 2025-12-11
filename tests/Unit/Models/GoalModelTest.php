<?php

namespace Tests\Unit\Models;

use App\Models\Goal;
use Tests\TestCase;

class GoalModelTest extends TestCase
{
    /**
     * Test Goal model instantiation with attributes
     */
    public function test_goal_can_be_instantiated_with_attributes(): void
    {
        $goal = new Goal([
            'user_id' => 1,
            'title' => 'Learn Laravel',
            'mentor_name' => 'John Doe',
            'target_sessions' => 10,
            'deadline' => '2025-12-31',
            'sessions_completed' => 0,
        ]);

        $this->assertInstanceOf(Goal::class, $goal);
        $this->assertEquals(1, $goal->user_id);
        $this->assertEquals('Learn Laravel', $goal->title);
    }

    /**
     * Test Goal model has correct fillable attributes
     */
    public function test_goal_fillable_attributes(): void
    {
        $goal = new Goal();
        $expected = [
            'user_id',
            'title',
            'mentor_name',
            'target_sessions',
            'deadline',
            'sessions_completed',
        ];

        $this->assertEquals($expected, $goal->getFillable());
    }

    /**
     * Test Goal model stores all attributes correctly
     */
    public function test_goal_stores_all_attributes(): void
    {
        $data = [
            'user_id' => 5,
            'title' => 'Master PHP',
            'mentor_name' => 'Jane Smith',
            'target_sessions' => 15,
            'deadline' => '2026-06-30',
            'sessions_completed' => 3,
        ];

        $goal = new Goal($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $goal->$key);
        }
    }

    /**
     * Test Goal model initialization with empty attributes
     */
    public function test_goal_can_be_instantiated_empty(): void
    {
        $goal = new Goal();

        $this->assertInstanceOf(Goal::class, $goal);
        $this->assertNull($goal->user_id);
        $this->assertNull($goal->title);
    }

    /**
     * Test Goal model attribute assignment after creation
     */
    public function test_goal_attributes_can_be_assigned(): void
    {
        $goal = new Goal();
        $goal->user_id = 2;
        $goal->title = 'Learn Testing';
        $goal->target_sessions = 5;

        $this->assertEquals(2, $goal->user_id);
        $this->assertEquals('Learn Testing', $goal->title);
        $this->assertEquals(5, $goal->target_sessions);
    }
}

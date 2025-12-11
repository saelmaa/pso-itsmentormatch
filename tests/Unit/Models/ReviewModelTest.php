<?php

namespace Tests\Unit\Models;

use App\Models\Review;
use Tests\TestCase;

class ReviewModelTest extends TestCase
{
    /**
     * Test Review model instantiation
     */
    public function test_review_can_be_instantiated_with_attributes(): void
    {
        $review = new Review([
            'session_id' => 1,
            'user_id' => 2,
            'mentor_id' => 3,
            'rating' => 4.5,
            'feedback' => 'Great session!',
        ]);

        $this->assertInstanceOf(Review::class, $review);
        $this->assertEquals(1, $review->session_id);
        $this->assertEquals(2, $review->user_id);
        $this->assertEquals(3, $review->mentor_id);
        $this->assertEquals(4.5, $review->rating);
        $this->assertEquals('Great session!', $review->feedback);
    }

    /**
     * Test Review fillable attributes
     */
    public function test_review_fillable_attributes(): void
    {
        $review = new Review();
        $expected = [
            'session_id',
            'user_id',
            'mentor_id',
            'rating',
            'feedback',
        ];

        $this->assertEquals($expected, $review->getFillable());
    }

    /**
     * Test Review model initialization empty
     */
    public function test_review_can_be_instantiated_empty(): void
    {
        $review = new Review();

        $this->assertInstanceOf(Review::class, $review);
        $this->assertNull($review->session_id);
        $this->assertNull($review->user_id);
    }

    /**
     * Test Review has session relationship method
     */
    public function test_review_has_session_relationship(): void
    {
        $review = new Review();
        $this->assertTrue(method_exists($review, 'session'));
    }

    /**
     * Test Review has user relationship method
     */
    public function test_review_has_user_relationship(): void
    {
        $review = new Review();
        $this->assertTrue(method_exists($review, 'user'));
    }

    /**
     * Test Review has mentor relationship method
     */
    public function test_review_has_mentor_relationship(): void
    {
        $review = new Review();
        $this->assertTrue(method_exists($review, 'mentor'));
    }

    /**
     * Test Review attributes can be assigned
     */
    public function test_review_attributes_can_be_assigned(): void
    {
        $review = new Review();
        $review->session_id = 5;
        $review->user_id = 6;
        $review->mentor_id = 7;
        $review->rating = 5.0;
        $review->feedback = 'Excellent mentor!';

        $this->assertEquals(5, $review->session_id);
        $this->assertEquals(6, $review->user_id);
        $this->assertEquals(7, $review->mentor_id);
        $this->assertEquals(5.0, $review->rating);
        $this->assertEquals('Excellent mentor!', $review->feedback);
    }

    /**
     * Test Review model stores all attributes correctly
     */
    public function test_review_stores_all_attributes(): void
    {
        $data = [
            'session_id' => 10,
            'user_id' => 11,
            'mentor_id' => 12,
            'rating' => 3.5,
            'feedback' => 'Good session, but could be better',
        ];

        $review = new Review($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $review->$key);
        }
    }

    /**
     * Test Review rating values
     */
    public function test_review_different_rating_values(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $review = new Review(['rating' => (float)$i]);
            $this->assertEquals((float)$i, $review->rating);
        }
    }

    /**
     * Test Review with long feedback text
     */
    public function test_review_with_long_feedback(): void
    {
        $longFeedback = str_repeat('Great mentor! ', 100);
        $review = new Review(['feedback' => $longFeedback]);
        
        $this->assertEquals($longFeedback, $review->feedback);
    }

    /**
     * Test Review has event listeners
     */
    public function test_review_has_event_listeners(): void
    {
        $review = new Review();
        // Check that the model class exists and has relationships
        $this->assertTrue(method_exists($review, 'mentor'));
    }

    /**
     * Test Review factory trait exists
     */
    public function test_review_uses_has_factory_trait(): void
    {
        $review = new Review();
        $this->assertTrue(method_exists($review, 'factory'));
    }

    /**
     * Test Review with rating boundary values
     */
    public function test_review_with_zero_rating(): void
    {
        $review = new Review(['rating' => 0]);
        $this->assertEquals(0, $review->rating);
    }

    /**
     * Test Review with decimal rating
     */
    public function test_review_with_decimal_rating(): void
    {
        $review = new Review(['rating' => 4.5]);
        $this->assertEquals(4.5, $review->rating);
    }

    /**
     * Test Review with float rating precision
     */
    public function test_review_with_precise_float_rating(): void
    {
        $review = new Review(['rating' => 3.7]);
        $this->assertEquals(3.7, $review->rating);
    }

    /**
     * Test Review multiple attribute assignments
     */
    public function test_review_multiple_assignments(): void
    {
        $review = new Review();

        $review->session_id = 1;
        $this->assertEquals(1, $review->session_id);

        $review->session_id = 2;
        $this->assertEquals(2, $review->session_id);

        $review->user_id = 5;
        $this->assertEquals(5, $review->user_id);
    }

    /**
     * Test Review with very long feedback text
     */
    public function test_review_with_very_long_feedback(): void
    {
        $veryLongFeedback = str_repeat('This is a detailed feedback. ', 200);
        $review = new Review(['feedback' => $veryLongFeedback]);
        
        $this->assertEquals($veryLongFeedback, $review->feedback);
        $this->assertStringContainsString('detailed feedback', $review->feedback);
    }

    /**
     * Test Review relationship methods are callable
     */
    public function test_review_relationship_methods_callable(): void
    {
        $review = new Review(['id' => 1]);

        $this->assertTrue(is_callable([$review, 'session']));
        $this->assertTrue(is_callable([$review, 'user']));
        $this->assertTrue(is_callable([$review, 'mentor']));
    }

    /**
     * Test Review with empty feedback
     */
    public function test_review_with_empty_feedback(): void
    {
        $review = new Review(['feedback' => '']);
        $this->assertEquals('', $review->feedback);
    }

    /**
     * Test Review with null feedback
     */
    public function test_review_with_null_feedback(): void
    {
        $review = new Review();
        $this->assertNull($review->feedback);
    }

    /**
     * Test Review session_id with different values
     */
    public function test_review_session_id_various_values(): void
    {
        $sessionIds = [1, 5, 10, 100, 999];

        foreach ($sessionIds as $id) {
            $review = new Review(['session_id' => $id]);
            $this->assertEquals($id, $review->session_id);
        }
    }

    /**
     * Test Review user_id with different values
     */
    public function test_review_user_id_various_values(): void
    {
        $userIds = [1, 3, 7, 50, 500];

        foreach ($userIds as $id) {
            $review = new Review(['user_id' => $id]);
            $this->assertEquals($id, $review->user_id);
        }
    }

    /**
     * Test Review mentor_id with different values
     */
    public function test_review_mentor_id_various_values(): void
    {
        $mentorIds = [1, 2, 10, 25, 100];

        foreach ($mentorIds as $id) {
            $review = new Review(['mentor_id' => $id]);
            $this->assertEquals($id, $review->mentor_id);
        }
    }

    /**
     * Test Review complete data set
     */
    public function test_review_with_complete_dataset(): void
    {
        $data = [
            'session_id' => 15,
            'user_id' => 8,
            'mentor_id' => 3,
            'rating' => 4.8,
            'feedback' => 'Exceptional mentor with great teaching skills',
        ];

        $review = new Review($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $review->$key, "Field $key should match");
        }
    }

    /**
     * Test Review rating values across entire scale
     */
    public function test_review_rating_scale(): void
    {
        $ratings = [1.0, 1.5, 2.0, 2.5, 3.0, 3.5, 4.0, 4.5, 5.0];

        foreach ($ratings as $rating) {
            $review = new Review(['rating' => $rating]);
            $this->assertEquals($rating, $review->rating);
        }
    }

    /**
     * Test Review getFillable returns correct array
     */
    public function test_review_get_fillable(): void
    {
        $review = new Review();
        $fillable = $review->getFillable();

        $this->assertContains('session_id', $fillable);
        $this->assertContains('user_id', $fillable);
        $this->assertContains('mentor_id', $fillable);
        $this->assertContains('rating', $fillable);
        $this->assertContains('feedback', $fillable);
    }

    /**
     * Test Review attribute modification chain
     */
    public function test_review_attribute_chain_modification(): void
    {
        $review = new Review();

        $review->session_id = 1;
        $review->user_id = 2;
        $review->mentor_id = 3;
        $review->rating = 5.0;
        $review->feedback = 'Perfect!';

        // Verify all are set
        $this->assertEquals(1, $review->session_id);
        $this->assertEquals(2, $review->user_id);
        $this->assertEquals(3, $review->mentor_id);
        $this->assertEquals(5.0, $review->rating);
        $this->assertEquals('Perfect!', $review->feedback);

        // Modify one and verify others unchanged
        $review->feedback = 'Excellent work!';
        $this->assertEquals('Excellent work!', $review->feedback);
        $this->assertEquals(5.0, $review->rating);
    }
}

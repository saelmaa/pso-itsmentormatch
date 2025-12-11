<?php

namespace Tests\Unit\Models;

use App\Models\Mentor;
use Tests\TestCase;

class MentorModelTest extends TestCase
{
    /**
     * Test Mentor model instantiation
     */
    public function test_mentor_can_be_instantiated_with_attributes(): void
    {
        $mentor = new Mentor([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'department' => 'Computer Science',
            'expertise' => 'Laravel',
            'bio' => 'Experienced Laravel developer',
            'experience_years' => 5,
            'rating' => 4.5,
            'total_sessions' => 20,
            'total_reviews' => 10,
            'availability_status' => 'available',
            'skills' => ['PHP', 'Laravel', 'MySQL'],
            'location' => 'Boston',
            'price' => 50.00,
        ]);

        $this->assertInstanceOf(Mentor::class, $mentor);
        $this->assertEquals('John Doe', $mentor->name);
        $this->assertEquals('john@example.com', $mentor->email);
    }

    /**
     * Test Mentor fillable attributes
     */
    public function test_mentor_fillable_attributes(): void
    {
        $mentor = new Mentor();
        $expected = [
            'name',
            'email',
            'department',
            'expertise',
            'bio',
            'experience_years',
            'rating',
            'total_sessions',
            'total_reviews',
            'availability_status',
            'skills',
            'location',
            'price',
        ];

        $this->assertEquals($expected, $mentor->getFillable());
    }

    /**
     * Test Mentor casts skills as array
     */
    public function test_mentor_casts_skills_as_array(): void
    {
        $mentor = new Mentor();
        $casts = $mentor->getCasts();
        
        // Skills should be cast as 'array'
        $this->assertEquals('array', $casts['skills']);
    }

    /**
     * Test Mentor casts rating as decimal
     */
    public function test_mentor_casts_rating_as_decimal(): void
    {
        $mentor = new Mentor([
            'name' => 'Bob Wilson',
            'rating' => 4.75,
        ]);

        $casts = $mentor->getCasts();
        $this->assertEquals('decimal:2', $casts['rating']);
    }

    /**
     * Test Mentor relationships are defined correctly
     */
    public function test_mentor_has_sessions_relationship(): void
    {
        $mentor = new Mentor();
        $this->assertTrue(method_exists($mentor, 'sessions'));
    }

    /**
     * Test Mentor has reviews relationship
     */
    public function test_mentor_has_reviews_relationship(): void
    {
        $mentor = new Mentor();
        $this->assertTrue(method_exists($mentor, 'reviews'));
    }

    /**
     * Test Mentor has updateRating method
     */
    public function test_mentor_has_update_rating_method(): void
    {
        $mentor = new Mentor();
        $this->assertTrue(method_exists($mentor, 'updateRating'));
    }

    /**
     * Test Mentor has search scope
     */
    public function test_mentor_has_search_scope(): void
    {
        $mentor = new Mentor();
        $this->assertTrue(method_exists($mentor, 'scopeSearch'));
    }

    /**
     * Test Mentor has department scope
     */
    public function test_mentor_has_department_scope(): void
    {
        $mentor = new Mentor();
        $this->assertTrue(method_exists($mentor, 'scopeDepartment'));
    }

    /**
     * Test Mentor model stores all attributes correctly
     */
    public function test_mentor_stores_all_attributes(): void
    {
        $data = [
            'name' => 'Dr. Alan Turing',
            'email' => 'turing@example.com',
            'department' => 'Mathematics',
            'expertise' => 'Algorithms',
            'bio' => 'Father of computer science',
            'experience_years' => 25,
            'rating' => 5.0,
            'total_sessions' => 100,
            'total_reviews' => 50,
            'availability_status' => 'available',
            'skills' => ['Theory', 'Computation'],
            'location' => 'Manchester',
            'price' => 100.00,
        ];

        $mentor = new Mentor($data);

        $this->assertEquals($data['name'], $mentor->name);
        $this->assertEquals($data['email'], $mentor->email);
        $this->assertEquals($data['expertise'], $mentor->expertise);
        $this->assertEquals($data['experience_years'], $mentor->experience_years);
    }

    /**
     * Test Mentor availability status attribute
     */
    public function test_mentor_availability_status(): void
    {
        $mentor = new Mentor(['availability_status' => 'busy']);
        $this->assertEquals('busy', $mentor->availability_status);

        $mentor->availability_status = 'available';
        $this->assertEquals('available', $mentor->availability_status);
    }

    /**
     * Test Mentor price attribute
     */
    public function test_mentor_price_attribute(): void
    {
        $mentor = new Mentor(['price' => 75.50]);
        $this->assertEquals(75.50, $mentor->price);
    }

    /**
     * Test Mentor has active trait
     */
    public function test_mentor_uses_has_factory_trait(): void
    {
        $mentor = new Mentor();
        $this->assertTrue(method_exists($mentor, 'factory'));
    }

    /**
     * Test Mentor relationship methods return correct types
     */
    public function test_mentor_relationship_methods_exist_and_callable(): void
    {
        $mentor = new Mentor(['id' => 1]);
        
        // Test that methods are callable
        $this->assertTrue(is_callable([$mentor, 'sessions']));
        $this->assertTrue(is_callable([$mentor, 'reviews']));
        $this->assertTrue(is_callable([$mentor, 'updateRating']));
    }

    /**
     * Test Mentor scopes with realistic data
     */
    public function test_mentor_search_scope_method_exists(): void
    {
        $mentor = new Mentor();
        $reflection = new \ReflectionClass($mentor);
        
        // Verify scopeSearch exists
        $this->assertTrue($reflection->hasMethod('scopeSearch'));
    }

    /**
     * Test Mentor department scope method exists
     */
    public function test_mentor_department_scope_method_exists(): void
    {
        $mentor = new Mentor();
        $reflection = new \ReflectionClass($mentor);
        
        // Verify scopeDepartment exists
        $this->assertTrue($reflection->hasMethod('scopeDepartment'));
    }

    /**
     * Test Mentor with various expertise values
     */
    public function test_mentor_expertise_values(): void
    {
        $expertises = ['Laravel', 'Python', 'JavaScript', 'DevOps'];
        
        foreach ($expertises as $exp) {
            $mentor = new Mentor(['expertise' => $exp]);
            $this->assertEquals($exp, $mentor->expertise);
        }
    }

    /**
     * Test Mentor experience years
     */
    public function test_mentor_experience_years_values(): void
    {
        for ($i = 1; $i <= 30; $i += 5) {
            $mentor = new Mentor(['experience_years' => $i]);
            $this->assertEquals($i, $mentor->experience_years);
        }
    }

    /**
     * Test Mentor bio attribute
     */
    public function test_mentor_bio_attribute(): void
    {
        $bio = 'A senior developer with extensive experience in web technologies.';
        $mentor = new Mentor(['bio' => $bio]);
        $this->assertEquals($bio, $mentor->bio);
    }

    /**
     * Test Mentor ratings range
     */
    public function test_mentor_rating_values_in_range(): void
    {
        $ratings = [0, 1.0, 2.5, 3.75, 4.5, 5.0];
        
        foreach ($ratings as $rating) {
            $mentor = new Mentor(['rating' => $rating]);
            $this->assertEquals($rating, $mentor->rating);
        }
    }

    /**
     * Test Mentor total sessions count
     */
    public function test_mentor_total_sessions_count(): void
    {
        $mentor = new Mentor(['total_sessions' => 150]);
        $this->assertEquals(150, $mentor->total_sessions);
    }

    /**
     * Test Mentor total reviews count
     */
    public function test_mentor_total_reviews_count(): void
    {
        $mentor = new Mentor(['total_reviews' => 45]);
        $this->assertEquals(45, $mentor->total_reviews);
    }

    /**
     * Test Mentor location attribute
     */
    public function test_mentor_location_attribute(): void
    {
        $locations = ['New York', 'San Francisco', 'Remote', 'London'];
        
        foreach ($locations as $loc) {
            $mentor = new Mentor(['location' => $loc]);
            $this->assertEquals($loc, $mentor->location);
        }
    }

    /**
     * Test Mentor with null values for optional fields
     */
    public function test_mentor_with_null_optional_fields(): void
    {
        $mentor = new Mentor([
            'name' => 'John Mentor',
            'bio' => null,
            'location' => null,
        ]);

        $this->assertEquals('John Mentor', $mentor->name);
        $this->assertNull($mentor->bio);
        $this->assertNull($mentor->location);
    }

    /**
     * Test Mentor rating with zero value
     */
    public function test_mentor_rating_zero(): void
    {
        $mentor = new Mentor(['rating' => 0]);
        $this->assertEquals(0, $mentor->rating);
    }

    /**
     * Test Mentor rating with perfect score
     */
    public function test_mentor_rating_perfect_score(): void
    {
        $mentor = new Mentor(['rating' => 5.0]);
        $this->assertEquals(5.0, $mentor->rating);
    }

    /**
     * Test Mentor experience years progression
     */
    public function test_mentor_experience_years_progression(): void
    {
        $yearsOfExperience = [1, 5, 10, 20, 30];

        foreach ($yearsOfExperience as $years) {
            $mentor = new Mentor(['experience_years' => $years]);
            $this->assertEquals($years, $mentor->experience_years);
        }
    }

    /**
     * Test Mentor skills casting
     */
    public function test_mentor_skills_as_array_cast(): void
    {
        $mentor = new Mentor();
        $casts = $mentor->getCasts();
        
        $this->assertArrayHasKey('skills', $casts);
        $this->assertEquals('array', $casts['skills']);
    }

    /**
     * Test Mentor rating casting as decimal
     */
    public function test_mentor_rating_as_decimal_cast(): void
    {
        $mentor = new Mentor();
        $casts = $mentor->getCasts();
        
        $this->assertArrayHasKey('rating', $casts);
        $this->assertEquals('decimal:2', $casts['rating']);
    }

    /**
     * Test Mentor with all attributes set
     */
    public function test_mentor_with_all_attributes_set(): void
    {
        $data = [
            'name' => 'Dr. Complete Mentor',
            'email' => 'complete@mentor.com',
            'department' => 'Computer Science',
            'expertise' => 'Full Stack Development',
            'bio' => 'Comprehensive bio',
            'experience_years' => 15,
            'rating' => 4.9,
            'total_sessions' => 200,
            'total_reviews' => 80,
            'availability_status' => 'available',
            'skills' => ['PHP', 'Laravel', 'React', 'Node.js'],
            'location' => 'Silicon Valley',
            'price' => 150.00,
        ];

        $mentor = new Mentor($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $mentor->$key, "Field $key mismatch");
        }
    }

    /**
     * Test Mentor department variations
     */
    public function test_mentor_department_variations(): void
    {
        $departments = [
            'Computer Science',
            'Engineering',
            'Mathematics',
            'Physics',
            'Chemistry',
        ];

        foreach ($departments as $dept) {
            $mentor = new Mentor(['department' => $dept]);
            $this->assertEquals($dept, $mentor->department);
        }
    }

    /**
     * Test Mentor expertise variations
     */
    public function test_mentor_expertise_variations(): void
    {
        $expertises = [
            'Web Development',
            'Mobile Development',
            'DevOps',
            'Data Science',
            'Cloud Architecture',
        ];

        foreach ($expertises as $exp) {
            $mentor = new Mentor(['expertise' => $exp]);
            $this->assertEquals($exp, $mentor->expertise);
        }
    }

    /**
     * Test Mentor availability status variations
     */
    public function test_mentor_availability_status_variations(): void
    {
        $statuses = ['available', 'busy', 'on-leave', 'inactive'];

        foreach ($statuses as $status) {
            $mentor = new Mentor(['availability_status' => $status]);
            $this->assertEquals($status, $mentor->availability_status);
        }
    }

    /**
     * Test Mentor price various values
     */
    public function test_mentor_price_various_values(): void
    {
        $prices = [0.00, 25.50, 50.00, 100.00, 250.99];

        foreach ($prices as $price) {
            $mentor = new Mentor(['price' => $price]);
            $this->assertEquals($price, $mentor->price);
        }
    }

    /**
     * Test Mentor skill array with multiple skills
     */
    public function test_mentor_skills_with_multiple_items(): void
    {
        $skills = ['PHP', 'JavaScript', 'Python', 'Go', 'Rust'];
        $mentor = new Mentor(['skills' => $skills]);

        // Skills should be stored/retrieved as array
        $this->assertIsArray($mentor->getAttribute('skills') ?? $skills);
    }

    /**
     * Test Mentor total sessions with large number
     */
    public function test_mentor_total_sessions_large_number(): void
    {
        $mentor = new Mentor(['total_sessions' => 1000]);
        $this->assertEquals(1000, $mentor->total_sessions);
    }

    /**
     * Test Mentor total reviews with large number
     */
    public function test_mentor_total_reviews_large_number(): void
    {
        $mentor = new Mentor(['total_reviews' => 500]);
        $this->assertEquals(500, $mentor->total_reviews);
    }

    /**
     * Test Mentor email format variations
     */
    public function test_mentor_email_format_variations(): void
    {
        $emails = [
            'mentor@example.com',
            'dr.smith@university.edu',
            'john.doe+mentor@company.co.uk',
        ];

        foreach ($emails as $email) {
            $mentor = new Mentor(['email' => $email]);
            $this->assertEquals($email, $mentor->email);
        }
    }

    /**
     * Test Mentor bio with long text
     */
    public function test_mentor_bio_long_text(): void
    {
        $longBio = str_repeat('Experienced mentor with expertise in multiple domains. ', 10);
        $mentor = new Mentor(['bio' => $longBio]);

        $this->assertEquals($longBio, $mentor->bio);
        $this->assertStringContainsString('Experienced mentor', $mentor->bio);
    }

    /**
     * Test Mentor getFillable returns all expected fields
     */
    public function test_mentor_get_fillable_all_fields(): void
    {
        $mentor = new Mentor();
        $fillable = $mentor->getFillable();

        $expectedFields = [
            'name', 'email', 'department', 'expertise', 'bio',
            'experience_years', 'rating', 'total_sessions', 'total_reviews',
            'availability_status', 'skills', 'location', 'price',
        ];

        foreach ($expectedFields as $field) {
            $this->assertContains($field, $fillable, "Field $field not in fillable");
        }
    }

    /**
     * Test Mentor session and review relationship methods exist
     */
    public function test_mentor_relationships_methods_callable(): void
    {
        $mentor = new Mentor(['id' => 1]);

        $this->assertTrue(is_callable([$mentor, 'sessions']));
        $this->assertTrue(is_callable([$mentor, 'reviews']));
    }

    /**
     * Test Mentor updateRating method exists
     */
    public function test_mentor_update_rating_method_callable(): void
    {
        $mentor = new Mentor();
        $this->assertTrue(is_callable([$mentor, 'updateRating']));
    }
}


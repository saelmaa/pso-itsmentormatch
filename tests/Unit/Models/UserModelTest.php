<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    /**
     * Test User model instantiation
     */
    public function test_user_can_be_instantiated_with_attributes(): void
    {
        $user = new User([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'department' => 'Computer Science',
            'student_id' => 'CS001',
            'phone' => '555-1234',
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('Computer Science', $user->department);
        $this->assertEquals('CS001', $user->student_id);
    }

    /**
     * Test User fillable attributes
     */
    public function test_user_fillable_attributes(): void
    {
        $user = new User();
        $expected = [
            'name',
            'email',
            'password',
            'department',
            'student_id',
            'phone',
        ];

        $this->assertEquals($expected, $user->getFillable());
    }

    /**
     * Test User hidden attributes
     */
    public function test_user_hidden_attributes(): void
    {
        $user = new User();
        $expected = [
            'password',
            'remember_token',
        ];

        $this->assertEquals($expected, $user->getHidden());
    }

    /**
     * Test User casts email_verified_at as datetime
     */
    public function test_user_casts_email_verified_at(): void
    {
        $user = new User();
        $casts = $user->getCasts();
        $this->assertEquals('datetime', $casts['email_verified_at']);
    }

    /**
     * Test User has sessions relationship method
     */
    public function test_user_has_sessions_relationship(): void
    {
        $user = new User();
        $this->assertTrue(method_exists($user, 'sessions'));
    }

    /**
     * Test User has reviews relationship method
     */
    public function test_user_has_reviews_relationship(): void
    {
        $user = new User();
        $this->assertTrue(method_exists($user, 'reviews'));
    }

    /**
     * Test User has goal relationship method
     */
    public function test_user_has_goal_relationship(): void
    {
        $user = new User();
        $this->assertTrue(method_exists($user, 'goal'));
    }

    /**
     * Test User instantiation empty
     */
    public function test_user_can_be_instantiated_empty(): void
    {
        $user = new User();

        $this->assertInstanceOf(User::class, $user);
        $this->assertNull($user->name);
        $this->assertNull($user->email);
    }

    /**
     * Test User attributes can be assigned
     */
    public function test_user_attributes_can_be_assigned(): void
    {
        $user = new User();
        $user->name = 'Jane Smith';
        $user->email = 'jane@example.com';
        $user->department = 'Mathematics';
        $user->student_id = 'MATH002';
        $user->phone = '555-5678';

        $this->assertEquals('Jane Smith', $user->name);
        $this->assertEquals('jane@example.com', $user->email);
        $this->assertEquals('Mathematics', $user->department);
        $this->assertEquals('MATH002', $user->student_id);
        $this->assertEquals('555-5678', $user->phone);
    }

    /**
     * Test User model stores all attributes correctly
     */
    public function test_user_stores_all_attributes(): void
    {
        $password = bcrypt('secure123');
        $data = [
            'name' => 'Alice Johnson',
            'email' => 'alice@example.com',
            'password' => $password,
            'department' => 'Engineering',
            'student_id' => 'ENG003',
            'phone' => '555-9999',
        ];

        $user = new User($data);

        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['email'], $user->email);
        $this->assertEquals($data['password'], $user->password);
        $this->assertEquals($data['department'], $user->department);
        $this->assertEquals($data['student_id'], $user->student_id);
        $this->assertEquals($data['phone'], $user->phone);
    }

    /**
     * Test User is Authenticatable
     */
    public function test_user_is_authenticatable(): void
    {
        $user = new User();
        $this->assertTrue($user instanceof \Illuminate\Contracts\Auth\Authenticatable);
    }

    /**
     * Test User has Notifiable trait
     */
    public function test_user_is_notifiable(): void
    {
        $user = new User();
        $this->assertTrue(method_exists($user, 'notify'));
    }

    /**
     * Test User different departments
     */
    public function test_user_different_departments(): void
    {
        $departments = [
            'Computer Science',
            'Mathematics',
            'Engineering',
            'Physics',
            'Chemistry',
        ];

        foreach ($departments as $dept) {
            $user = new User(['department' => $dept]);
            $this->assertEquals($dept, $user->department);
        }
    }

    /**
     * Test User student_id formats
     */
    public function test_user_student_id_formats(): void
    {
        $ids = ['CS001', 'MATH002', 'ENG003', 'PHY004', 'CHM005'];

        foreach ($ids as $id) {
            $user = new User(['student_id' => $id]);
            $this->assertEquals($id, $user->student_id);
        }
    }

    /**
     * Test User email validation format stored
     */
    public function test_user_email_format_stored(): void
    {
        $emails = [
            'test@example.com',
            'user123@domain.org',
            'mentor.name@institution.edu',
        ];

        foreach ($emails as $email) {
            $user = new User(['email' => $email]);
            $this->assertEquals($email, $user->email);
        }
    }

    /**
     * Test User phone number formats
     */
    public function test_user_phone_number_formats(): void
    {
        $phones = ['555-1234', '5551234567', '+1-555-1234'];

        foreach ($phones as $phone) {
            $user = new User(['phone' => $phone]);
            $this->assertEquals($phone, $user->phone);
        }
    }

    /**
     * Test User password hidden in array
     */
    public function test_user_password_hidden_in_array(): void
    {
        $user = new User([
            'name' => 'Bob Wilson',
            'email' => 'bob@example.com',
            'password' => bcrypt('secret'),
        ]);

        $arr = $user->toArray();
        
        // Password and remember_token should not be in the array
        $this->assertArrayNotHasKey('password', $arr);
        $this->assertArrayNotHasKey('remember_token', $arr);
    }

    /**
     * Test User factory method exists
     */
    public function test_user_factory_method_exists(): void
    {
        $user = new User();
        $this->assertTrue(method_exists($user, 'factory'));
    }

    /**
     * Test User can call session relationship
     */
    public function test_user_can_call_sessions_relationship(): void
    {
        $user = new User(['id' => 1]);
        $this->assertTrue(is_callable([$user, 'sessions']));
    }

    /**
     * Test User can call reviews relationship
     */
    public function test_user_can_call_reviews_relationship(): void
    {
        $user = new User(['id' => 1]);
        $this->assertTrue(is_callable([$user, 'reviews']));
    }

    /**
     * Test User can call goal relationship
     */
    public function test_user_can_call_goal_relationship(): void
    {
        $user = new User(['id' => 1]);
        $this->assertTrue(is_callable([$user, 'goal']));
    }

    /**
     * Test User instance of Authenticatable
     */
    public function test_user_implements_authenticatable(): void
    {
        $user = new User();
        $this->assertInstanceOf(\Illuminate\Contracts\Auth\Authenticatable::class, $user);
    }

    /**
     * Test User with all fillable fields populated
     */
    public function test_user_with_all_fields_populated(): void
    {
        $user = new User([
            'name' => 'Complete User',
            'email' => 'complete@example.com',
            'password' => bcrypt('secure_password'),
            'department' => 'Engineering',
            'student_id' => 'ENG001',
            'phone' => '555-9876',
        ]);

        $this->assertEquals('Complete User', $user->name);
        $this->assertEquals('complete@example.com', $user->email);
        $this->assertEquals('Engineering', $user->department);
        $this->assertEquals('ENG001', $user->student_id);
        $this->assertEquals('555-9876', $user->phone);
    }

    /**
     * Test User email cast format
     */
    public function test_user_email_cast_format(): void
    {
        $user = new User(['email' => 'test@EXAMPLE.COM']);
        // Email should be stored as-is (no auto-lowercase in model)
        $this->assertEquals('test@EXAMPLE.COM', $user->email);
    }

    /**
     * Test User password remains hidden in multiple contexts
     */
    public function test_user_password_hidden_in_json(): void
    {
        $user = new User([
            'name' => 'Json User',
            'password' => bcrypt('secret123'),
            'email' => 'json@test.com',
        ]);

        $json = json_decode($user->toJson(), true);
        $this->assertArrayNotHasKey('password', $json);
    }

    /**
     * Test User with empty phone number
     */
    public function test_user_with_empty_phone(): void
    {
        $user = new User([
            'name' => 'No Phone User',
            'email' => 'nophone@example.com',
            'phone' => '',
        ]);

        $this->assertEquals('', $user->phone);
    }

    /**
     * Test User with null phone number
     */
    public function test_user_with_null_phone(): void
    {
        $user = new User([
            'name' => 'Null Phone User',
            'email' => 'nullphone@example.com',
        ]);

        $this->assertNull($user->phone);
    }

    /**
     * Test User getHidden returns correct arrays
     */
    public function test_user_get_hidden_returns_password_fields(): void
    {
        $user = new User();
        $hidden = $user->getHidden();

        $this->assertContains('password', $hidden);
        $this->assertContains('remember_token', $hidden);
        $this->assertCount(2, $hidden);
    }

    /**
     * Test User multiple department assignments
     */
    public function test_user_department_changes(): void
    {
        $user = new User(['department' => 'Physics']);
        $this->assertEquals('Physics', $user->department);

        $user->department = 'Chemistry';
        $this->assertEquals('Chemistry', $user->department);

        $user->department = 'Biology';
        $this->assertEquals('Biology', $user->department);
    }

    /**
     * Test User with special characters in fields
     */
    public function test_user_with_special_characters(): void
    {
        $user = new User([
            'name' => "O'Brien-Smith",
            'email' => 'test+tag@example.co.uk',
            'student_id' => 'ENG-001-A',
        ]);

        $this->assertEquals("O'Brien-Smith", $user->name);
        $this->assertEquals('test+tag@example.co.uk', $user->email);
        $this->assertEquals('ENG-001-A', $user->student_id);
    }

    /**
     * Test User email_verified_at cast as datetime
     */
    public function test_user_email_verified_at_cast(): void
    {
        $user = new User();
        $casts = $user->getCasts();
        
        $this->assertEquals('datetime', $casts['email_verified_at']);
    }

    /**
     * Test User is notifiable
     */
    public function test_user_has_notify_method(): void
    {
        $user = new User();
        $this->assertTrue(method_exists($user, 'notify'));
    }
}

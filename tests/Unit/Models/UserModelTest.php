<?php

namespace Tests\Unit\Models;

use App\Models\Goal;
use App\Models\Review;
use App\Models\Session;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user can be created with fillable attributes
     */
    public function test_user_can_be_created(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'phone' => '+62 812 3456 7890',
            'password' => bcrypt('Password123'),
        ];

        $user = User::create($userData);

        $this->assertNotNull($user->id);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('05111940000001', $user->student_id);
        $this->assertEquals('Information System', $user->department);
        $this->assertEquals('+62 812 3456 7890', $user->phone);
    }

    /**
     * Test user has correct fillable attributes
     */
    public function test_user_fillable_attributes(): void
    {
        $expected = [
            'name',
            'email',
            'password',
            'department',
            'student_id',
            'phone',
        ];

        $user = new User();
        $this->assertEquals($expected, $user->getFillable());
    }

    /**
     * Test password is hidden from array
     */
    public function test_password_is_hidden(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => bcrypt('Password123'),
        ]);

        $userArray = $user->toArray();
        $this->assertArrayNotHasKey('password', $userArray);
    }

    /**
     * Test remember_token is hidden from array
     */
    public function test_remember_token_is_hidden(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => bcrypt('Password123'),
        ]);

        $userArray = $user->toArray();
        $this->assertArrayNotHasKey('remember_token', $userArray);
    }

    /**
     * Test email_verified_at is cast to datetime
     */
    public function test_email_verified_at_cast_to_datetime(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => bcrypt('Password123'),
            'email_verified_at' => now(),
        ]);

        $this->assertInstanceOf('Illuminate\Support\Carbon', $user->email_verified_at);
    }

    /**
     * Test user can create multiple sessions
     */
    public function test_user_can_have_many_sessions(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => bcrypt('Password123'),
        ]);

        // Create sessions using factory
        $sessions = Session::factory(3)->create(['user_id' => $user->id]);

        $this->assertCount(3, $user->sessions);
        $this->assertTrue($user->sessions->contains($sessions->first()));
    }

    /**
     * Test user can create multiple reviews
     */
    public function test_user_can_have_many_reviews(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => bcrypt('Password123'),
        ]);

        // Create reviews using factory
        $reviews = Review::factory(3)->create(['user_id' => $user->id]);

        $this->assertCount(3, $user->reviews);
        $this->assertTrue($user->reviews->contains($reviews->first()));
    }

    /**
     * Test user can have one goal
     */
    public function test_user_can_have_one_goal(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => bcrypt('Password123'),
        ]);

        // Create goal using factory
        $goal = Goal::factory()->create(['user_id' => $user->id]);

        $this->assertNotNull($user->goal);
        $this->assertEquals($goal->id, $user->goal->id);
    }

    /**
     * Test user without email_verified_at
     */
    public function test_user_email_verified_at_is_null_by_default(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => bcrypt('Password123'),
        ]);

        $this->assertNull($user->email_verified_at);
    }

    /**
     * Test user attributes are not null after creation
     */
    public function test_user_required_attributes_are_not_null(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => bcrypt('Password123'),
        ]);

        $this->assertNotNull($user->name);
        $this->assertNotNull($user->email);
        $this->assertNotNull($user->student_id);
        $this->assertNotNull($user->department);
        $this->assertNotNull($user->password);
    }

    /**
     * Test user phone can be null
     */
    public function test_user_phone_can_be_null(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => bcrypt('Password123'),
            'phone' => null,
        ]);

        $this->assertNull($user->phone);
    }

    /**
     * Test user can be retrieved by email
     */
    public function test_user_can_be_retrieved_by_email(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => bcrypt('Password123'),
        ]);

        $retrievedUser = User::where('email', 'john@example.com')->first();

        $this->assertNotNull($retrievedUser);
        $this->assertEquals($user->id, $retrievedUser->id);
    }

    /**
     * Test user can be retrieved by student_id
     */
    public function test_user_can_be_retrieved_by_student_id(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => bcrypt('Password123'),
        ]);

        $retrievedUser = User::where('student_id', '05111940000001')->first();

        $this->assertNotNull($retrievedUser);
        $this->assertEquals($user->id, $retrievedUser->id);
    }

    /**
     * Test user can be updated
     */
    public function test_user_can_be_updated(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => bcrypt('Password123'),
        ]);

        $user->update([
            'name' => 'Jane Doe',
            'phone' => '+62 812 9999 8888',
        ]);

        $this->assertEquals('Jane Doe', $user->name);
        $this->assertEquals('+62 812 9999 8888', $user->phone);
    }

    /**
     * Test user can be deleted
     */
    public function test_user_can_be_deleted(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'password' => bcrypt('Password123'),
        ]);

        $userId = $user->id;
        $user->delete();

        $this->assertNull(User::find($userId));
    }
}

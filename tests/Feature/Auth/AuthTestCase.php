<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Base test class untuk authentication tests
 * 
 * Menggunakan RefreshDatabase trait untuk:
 * - Menggunakan in-memory SQLite database untuk testing
 * - Refresh database sebelum setiap test
 * - Rollback transactions setelah setiap test
 */
class AuthTestCase extends TestCase
{
    use RefreshDatabase;

    /**
     * Valid registration data template
     */
    public static function validRegistrationData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'student_id' => '05111940000001',
            'department' => 'Information System',
            'phone' => '+62 812 3456 7890',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ], $overrides);
    }

    /**
     * Get registration data dengan email unik
     */
    public static function uniqueRegistrationData(array $overrides = []): array
    {
        return self::validRegistrationData(array_merge([
            'email' => 'user' . uniqid() . '@example.com',
            'student_id' => 'ID' . uniqid(),
        ], $overrides));
    }
}

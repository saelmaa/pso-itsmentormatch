<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    /**
     * Password reset functionality is not implemented
     * in this application. Entire suite is skipped.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->markTestSkipped('Password reset not implemented in this application.');
    }

    public function test_reset_password_link_screen_can_be_rendered(): void {}
    public function test_reset_password_link_can_be_requested(): void {}
    public function test_reset_password_screen_can_be_rendered(): void {}
    public function test_password_can_be_reset_with_valid_token(): void {}
}
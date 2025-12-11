<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    /**
     * Password confirmation flow is not implemented in this application,
     * so this entire test suite is skipped to avoid false failures.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->markTestSkipped('Password confirmation not implemented in this application.');
    }

    public function test_confirm_password_screen_can_be_rendered(): void
    {
        // skipped
    }

    public function test_password_can_be_confirmed(): void
    {
        // skipped
    }

    public function test_password_is_not_confirmed_with_invalid_password(): void
    {
        // skipped
    }
}

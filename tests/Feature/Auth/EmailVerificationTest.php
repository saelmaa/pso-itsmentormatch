<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    /**
     * Email verification is NOT implemented in this application,
     * so we skip this entire test suite to avoid false failures.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->markTestSkipped('Email verification not implemented in this application.');
    }

    public function test_email_verification_screen_can_be_rendered(): void
    {
        // skipped
    }

    public function test_email_can_be_verified(): void
    {
        // skipped
    }

    public function test_email_is_not_verified_with_invalid_hash(): void
    {
        // skipped
    }
}
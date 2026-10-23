<?php

namespace Tests\Feature;

use Tests\TestCase;

class VerifyInvalidTokenTest extends TestCase
{
    public function test_unknown_token_shows_friendly_404(): void
    {
        $this->get('/userVerify/does-not-exist')
            ->assertStatus(404)
            ->assertSee('Link invalid or expired');
    }
}
<?php

namespace Tests\Feature;

use Tests\TestCase;

class LogoutRedirectTest extends TestCase
{
    public function test_logout_keeps_https_when_request_is_forwarded_by_vercel(): void
    {
        $response = $this->withServerVariables([
            'HTTP_X_FORWARDED_PROTO' => 'https',
        ])->get('http://pembayaran-spp-orpin.vercel.app/logout');

        $response->assertRedirect('https://pembayaran-spp-orpin.vercel.app/login');
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicMediaTest extends TestCase
{
    public function test_it_serves_committed_school_images(): void
    {
        $images = [
            '/storage/settings/logo/L3ODh3znFaOM4ueXHrIjTgRfCNx8a8IHo4ve5yvh.jpg' => 'image/jpeg',
            '/storage/about/gallery/SzZ6zn5ocn8Pwn5vTS06jE0CYSiyTewWuQPw9667.webp' => 'image/webp',
            '/storage/about/gallery/bMwAwnGqmaWS8vwwgQFspw7Ns2eH2J99vVfynMjM.jpg' => 'image/jpeg',
            '/storage/about/hero/aFkZfOcboZK5QRnFNP6jwtkiqS3wmf8IPOCsarJm.jpg' => 'image/jpeg',
        ];

        foreach ($images as $url => $contentType) {
            $response = $this->get($url);

            $response->assertOk();
            $response->assertHeader('content-type', $contentType);
        }
    }

    public function test_it_does_not_serve_files_outside_public_storage(): void
    {
        $this->get('/storage/../../composer.json')->assertNotFound();
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleSwitchTest extends TestCase
{
    use RefreshDatabase;

    public function test_localized_home_pages_are_accessible(): void
    {
        $this->get('/')->assertOk();
        $this->get('/ru')->assertOk();
        $this->get('/kg')->assertOk();
    }

    public function test_language_switcher_shows_all_supported_locales(): void
    {
        $response = $this->get('/ru');

        $response->assertOk()
            ->assertSee('EN')
            ->assertSee('RU')
            ->assertSee('KG');
    }
}

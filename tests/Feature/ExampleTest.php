<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_root_page_redirects_to_property_listings(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('home'));
    }
}

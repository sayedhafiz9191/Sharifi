<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_home_endpoint_returns_json(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Log;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testViewRoutes()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->get('/cart');
        $response->assertStatus(200);
    }


    public function testAPIRutes()
    {
        $response = $this->get('/api/pizzas');
        $response->assertStatus(200);

        $response = $this->get('/api/orders');
        $response->assertStatus(200);

        $response = $this->get('/api/cart');
        $response->assertStatus(200);
    }
}

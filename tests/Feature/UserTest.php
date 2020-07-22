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
        Log::info('/api/pizzas');
        $response = $this->get('/api/pizzas');
        $response->assertStatus(200);
        $this->assertCount(7, json_decode($response->getContent())->data);


        Log::info('/api/cart');
        $response = $this->withHeaders([
            'X-CSRFToken' => 'l7bZRPzepM95zmryTslS484Yp2qrRxI78TNXlHnn',
        ])->get('/api/cart');
        Log::info(json_decode($response->getContent()));
        $response->assertStatus(200);
        $this->assertCount(0, json_decode($response->getContent()));

        Log::info('/api/orders');
        $order = [
            'token' => 'l7bZRPzepM95zmryTslS484Yp2qrRxI78TNXlHnn',
            'items' => [
                'pizza_id' => 1,
                'quantity' => 1,
                'price' => 799
            ],
            'total_price' => 799,
            'status' => 'pending',
        ];
        $response = $this->postJson('/api/orders', $order)->assertStatus(201);


        Log::info('/api/cart');
        $response = $this->withHeaders([
            'X-CSRFToken' => 'l7bZRPzepM95zmryTslS484Yp2qrRxI78TNXlHnn',
        ])->get('/api/cart');
        $response->assertStatus(200);
        $this->assertCount(1, json_decode($response->getContent()));


        Log::info('/api/orders');
        $response = $this->get('/api/orders');
        Log::info($response->getContent());
        $response->assertStatus(200);


    }
}

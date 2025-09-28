<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class CartTest extends TestCase
{
    public function test_calculates_the_final_price_correctly_with_a_valid_payload(): void
    {
        $payload = [
            "products" => [
                ["name" => "Fone Bluetooth", "price" => 100.00, "quantity" => 2],
                ["name" => "Mouse Gamer", "price" => 150.00, "quantity" => 1]
            ],
            "payment_method" => "CARTAO_CREDITO",
            "installments" => 3
        ];

        $response = $this->postJson('/api/cart/calculate', $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'price_total' => 360.61
        ]);
    }

    public function test_returns_a_validation_error_if_payment_method_is_missing(): void
    {
        $payload = [
            "products" => [
                ["name" => "Fone Bluetooth", "price" => 100.00, "quantity" => 2]
            ],
            "installments" => 3
        ];

        $response = $this->postJson('/api/cart/calculate', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['payment_method']);
    }
}

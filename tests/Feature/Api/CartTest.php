<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class CartTest extends TestCase
{
    public function test_calculates_the_final_price_correctly_with_a_valid_payload(): void
    {
        $payload = [
            "produtos" => [
                ["nome" => "Fone Bluetooth", "valor" => 100.00, "quantidade" => 2],
                ["nome" => "Mouse Gamer", "valor" => 150.00, "quantidade" => 1]
            ],
            "metodo_pagamento" => "CARTAO_CREDITO",
            "parcelas" => 3
        ];

        $response = $this->postJson('/api/cart/calculate', $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'valor_total_calculado' => 360.61
        ]);
    }

    #[Test]
    public function test_returns_a_validation_error_if_payment_method_is_missing(): void
    {
        $payload = [
            "produtos" => [
                ["nome" => "Fone Bluetooth", "valor" => 100.00, "quantidade" => 2]
            ],
            "parcelas" => 3
        ];

        $response = $this->postJson('/api/cart/calculate', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['metodo_pagamento']);
    }
}

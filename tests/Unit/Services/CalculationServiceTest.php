<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\PaymentMethod;
use App\Services\CalculationService;
use PHPUnit\Framework\TestCase;

class CalculationServiceTest extends TestCase
{
    private CalculationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CalculationService();
    }

    public function test_correctly_calculates_the_example_from_the_challenge_scope(): void
    {
        $products = [
            ['nome' => 'Fone Bluetooth', 'valor' => 100.00, 'quantidade' => 2],
            ['nome' => 'Mouse Gamer', 'valor' => 150.00, 'quantidade' => 1]
        ];

        $paymentMethod = PaymentMethod::CREDIT_CARD;
        $installments = 3;

        $finalPrice = $this->service->calculateFinalPrice($products, $paymentMethod, $installments);

        $this->assertEquals(360.61, $finalPrice);
    }

    public function test_applies_10_percent_discount_for_pix_payment(): void
    {
        $products = [['valor' => 200, 'quantidade' => 1]];
        $finalPrice = $this->service->calculateFinalPrice($products, PaymentMethod::PIX);
        $this->assertEquals(180.00, $finalPrice);
    }

    public function test_applies_10_percent_discount_for_one_installment_credit_card(): void
    {
        $products = [['valor' => 200, 'quantidade' => 1]];
        $finalPrice = $this->service->calculateFinalPrice($products, PaymentMethod::CREDIT_CARD, 1);
        $this->assertEquals(180.00, $finalPrice);
    }

    public function test_applies_compound_interest_for_credit_card_installments(): void
    {
        $products = [
            ['nome' => 'Produto Caro', 'valor' => 500.00, 'quantidade' => 1]
        ];

        $paymentMethod = PaymentMethod::CREDIT_CARD;
        $installments = 4;

        $finalPrice = $this->service->calculateFinalPrice($products, $paymentMethod, $installments);

        $expectedPrice = 520.30;

        $this->assertEquals($expectedPrice, $finalPrice, "O cálculo de juros compostos para {$installments} parcelas está incorreto.");
    }
}

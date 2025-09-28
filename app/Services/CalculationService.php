<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\PaymentMethod;

class CalculationService
{
    private const DISCOUNT_RATE_FOR_CASH_PAYMENT = 0.10;
    private const COMPOUND_INTEREST_RATE_PER_INSTALLMENT = 0.01;

    public function calculateFinalPrice(array $products, PaymentMethod $paymentMethod, int $installments = 1): float
    {
        $principal = array_reduce($products, function ($carry, $product) {
            return $carry + ($product['price'] * $product['quantity']);
        }, 0);

        if ($paymentMethod === PaymentMethod::PIX || ($paymentMethod === PaymentMethod::CREDIT_CARD && $installments === 1)) {
            $finalAmount = $principal * (1 - self::DISCOUNT_RATE_FOR_CASH_PAYMENT);
        } elseif ($paymentMethod === PaymentMethod::CREDIT_CARD && $installments >= 2) {
            $finalAmount = $principal * pow((1 + self::COMPOUND_INTEREST_RATE_PER_INSTALLMENT), $installments);
        } else {
            $finalAmount = $principal;
        }

        return round($finalAmount, 2);
    }
}

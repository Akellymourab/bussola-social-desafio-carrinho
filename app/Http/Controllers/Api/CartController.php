<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CalculateCartRequest;
use App\Services\CalculationService;
use Symfony\Component\HttpFoundation\JsonResponse;

class CartController extends Controller
{
    public function __construct(private readonly CalculationService $calculationService)
    {
    }

    /**
     * @OA\Post(
     * path="/api/cart/calculate",
     * tags={"Cart"},
     * summary="Calcula o valor final do carrinho",
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * type="object",
     * @OA\Property(property="produtos", type="array", @OA\Items(
     * @OA\Property(property="nome", type="string", example="Fone Bluetooth"),
     * @OA\Property(property="valor", type="number", format="float", example=100.00),
     * @OA\Property(property="quantidade", type="integer", example=2)
     * )),
     * @OA\Property(property="metodo_pagamento", type="string", example="CARTAO_CREDITO"),
     * @OA\Property(property="parcelas", type="integer", example=3)
     * )
     * ),
     * @OA\Response(response="200", description="Valor final calculado com sucesso."),
     * @OA\Response(response="422", description="Erro de validação nos dados enviados.")
     * )
     */
    public function calculate(CalculateCartRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $paymentMethodEnum = PaymentMethod::from($validated['metodo_pagamento']);

        $finalPrice = $this->calculationService->calculateFinalPrice(
            $validated['produtos'],
            $paymentMethodEnum,
            $validated['parcelas'] ?? 1
        );

        return response()->json([
            'valor_total_calculado' => $finalPrice,
        ]);
    }
}

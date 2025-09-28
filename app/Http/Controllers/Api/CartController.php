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
     * @OA\Property(property="products", type="array", @OA\Items(
     * @OA\Property(property="name", type="string", example="Fone Bluetooth"),
     * @OA\Property(property="price", type="number", format="float", example=100.00),
     * @OA\Property(property="quantity", type="integer", example=2)
     * )),
     * @OA\Property(property="payment_method", type="string", example="CARTAO_CREDITO"),
     * @OA\Property(property="installments", type="integer", example=3)
     * )
     * ),
     * @OA\Response(response="200", description="Valor final calculado com sucesso."),
     * @OA\Response(response="422", description="Erro de validação nos dados enviados.")
     * )
     */
    public function calculate(CalculateCartRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $paymentMethodEnum = PaymentMethod::from($validated['payment_method']);

        $finalPrice = $this->calculationService->calculateFinalPrice(
            $validated['products'],
            $paymentMethodEnum,
            $validated['installments'] ?? 1
        );

        return response()->json([
            'price_total' => $finalPrice,
        ]);
    }
}

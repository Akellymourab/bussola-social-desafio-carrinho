<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CalculateCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'products' => ['required', 'array'],
            'products.*.name' => ['required', 'string'],
            'products.*.price' => ['required', 'numeric', 'min:0'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'string', new Enum(PaymentMethod::class)],
            'installments' => ['required_if:payment_method,CARTAO_CREDITO', 'integer', 'min:1', 'max:12'],
        ];
    }
}

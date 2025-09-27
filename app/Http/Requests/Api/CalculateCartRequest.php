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
            'produtos' => ['required', 'array'],
            'produtos.*.nome' => ['required', 'string'],
            'produtos.*.valor' => ['required', 'numeric', 'min:0'],
            'produtos.*.quantidade' => ['required', 'integer', 'min:1'],
            'metodo_pagamento' => ['required', 'string', new Enum(PaymentMethod::class)],
            'parcelas' => ['required_if:metodo_pagamento,CARTAO_CREDITO', 'integer', 'min:1', 'max:12'],
        ];
    }
}

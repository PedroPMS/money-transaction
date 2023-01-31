<?php

namespace MoneyTransaction\Presentation\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<string|object>> */
    public function rules(): array
    {
        return [
            'payer_id' => ['required', 'string', 'exists:users,id', 'different:payee_id'],
            'payee_id' => ['required', 'string', 'exists:users,id', 'different:payer_id'],
            'value' => ['required', 'integer', 'gt:0'],
        ];
    }
}

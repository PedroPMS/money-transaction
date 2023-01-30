<?php

namespace MoneyTransaction\Presentation\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use MoneyTransaction\Domain\Enums\User\UserType;

class CreateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'cpf' => ['required', 'string'],
            'password' => ['required', 'string'],
            'type' => ['required', new Enum(UserType::class)],
        ];
    }
}

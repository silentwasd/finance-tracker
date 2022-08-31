<?php

namespace App\Http\Requests;

use App\Structures\TransactionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'type' => [
                'required',
                'string',
                Rule::in(collect(TransactionType::cases())->map(fn (TransactionType $type) => $type->value))
            ]
        ];
    }
}

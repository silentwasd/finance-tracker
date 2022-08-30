<?php

namespace App\Http\Requests;

use App\Structures\TransactionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'type' => [
                'required',
                'string',
                Rule::in(collect(TransactionType::cases())->map(fn (TransactionType $type) => $type->value))
            ],
            'value' => 'required|numeric|min:0',
            'completed_at' => 'required|date'
        ];
    }
}

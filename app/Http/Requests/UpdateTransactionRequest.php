<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'category' => 'nullable|int|exists:categories,id',
            'value' => 'required|numeric|min:0',
            'completed_at' => 'required|date'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMonthlyPaymentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'value' => 'required|numeric|min:0',
            'will_created_at' => 'required|date'
        ];
    }
}

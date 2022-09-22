<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMonthlyIncomeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'value' => 'required|numeric|min:0'
        ];
    }
}

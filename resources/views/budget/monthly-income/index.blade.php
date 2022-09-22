@extends('layouts.main', ['title' => 'Бюджет – Ежемесячные доходы'])

@section('main')
    <div class="mb-3">
        <x-month-selector :month="$month"></x-month-selector>
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('budget.monthly-income.update', $month) }}">
                @csrf

                <div class="mb-3">
                    <label for="value" class="form-label">{{ __('forms.monthly_income.value') }}</label>
                    <input type="number" class="form-control" id="value"
                           placeholder="123,45" min="0.00" step="0.01" required
                           name="value" value="{{ old('value') ?? $value->full() }}">
                </div>

                <button class="btn btn-primary">{{ __('forms.monthly_income.set_button') }}</button>
            </form>
        </div>
    </div>
@endsection

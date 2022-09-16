@extends('layouts.main', ['title' => __('forms.monthly_payment.create_title')])

@section('main')
    <div class="row">
        <div class="col">
            <h3>{{ __('forms.monthly_payment.create_title') }}</h3>

            <form method="post" action="{{ route('budget.monthly-payments.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('forms.monthly_payment.name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" required
                           placeholder="{{ __('forms.monthly_payment.name_placeholder') }}" value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label for="value" class="form-label">{{ __('forms.monthly_payment.value') }}</label>
                    <input type="number" class="form-control" id="value"
                           placeholder="123,45" min="0.00" step="0.01"
                           name="value" value="{{ old('value') }}" required>
                </div>

                <div class="mb-3">
                    <label for="will_created_at" class="form-label">{{ __('forms.monthly_payment.will_created_at') }}</label>
                    <input type="date" class="form-control" id="will_created_at" name="will_created_at"
                           value="{{ old('will_created_at') ?? $will_created_at->startOfDay()->format('Y-m-d') }}"
                           required>
                </div>

                <button class="btn btn-primary">{{ __('forms.monthly_payment.create_button') }}</button>
            </form>
        </div>
    </div>
@endsection

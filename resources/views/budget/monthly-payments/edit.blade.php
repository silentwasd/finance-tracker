@extends('layouts.main', ['title' => __('forms.monthly_payment.edit_title')])

@section('main')
    <div class="row">
        <div class="col">
            <h3>{{ __('forms.monthly_payment.edit_title') }}</h3>

            <form class="d-inline" method="post" action="{{ route('budget.monthly-payments.update', $payment->id) }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('forms.monthly_payment.name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" required
                           placeholder="{{ __('forms.monthly_payment.name_placeholder') }}"
                           value="{{ old('name') ?? $payment->name }}">
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">{{ __('forms.monthly_payment.category') }}</label>
                    <select id="category" name="category" class="form-select">
                        <option
                            value="" @selected($payment->category_id == null)>{{ __('forms.monthly_payment.category_none') }}</option>
                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}" @selected($old = old('category') ? $old == $category->id : $category->id == $payment->category_id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="value" class="form-label">{{ __('forms.monthly_payment.value') }}</label>
                    <input type="number" class="form-control" id="value"
                           placeholder="123,45" min="0.00" step="0.01" required
                           name="value" value="{{ old('value') ?? $payment->value->full() }}">
                </div>

                <div class="mb-3">
                    <label for="will_created_at" class="form-label">{{ __('forms.monthly_payment.will_created_at') }}</label>
                    <input type="date" class="form-control" id="will_created_at" name="will_created_at"
                           value="{{ old('will_created_at') ?? $payment->will_created_at->format('Y-m-d') }}"
                           required>
                </div>

                <button class="btn btn-success">{{ __('forms.monthly_payment.update_button') }}</button>
            </form>

            <form class="d-inline" method="post" action="{{ route('budget.monthly-payments.destroy', $payment->id) }}">
                @csrf

                <button class="btn btn-danger">{{ __('forms.monthly_payment.delete_button') }}</button>
            </form>
        </div>
    </div>
@endsection

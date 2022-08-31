@extends('layouts.main', ['title' => $title ?? __('forms.transaction.create_title')])

@section('main')
    <div class="row">
        <div class="col">
            <h3>{{ __('forms.transaction.create_title') }}</h3>

            <form method="post" action="{{ route('transactions.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('forms.transaction.name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" required
                           placeholder="{{ __('forms.transaction.name_placeholder') }}" value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('forms.transaction.transaction_type') }}</label>

                    <div class="form-check mb-1">
                        <input class="form-check-input" type="radio" name="type"
                               id="income" value="{{ \App\Structures\TransactionType::Income->value }}"
                            @checked(old('type') ? old('type') == \App\Structures\TransactionType::Income->value : $income)>
                        <label class="form-check-label" for="income">
                            {{ Str::ucfirst(__('transaction_types.income')) }}
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type"
                               id="expense" value="{{ \App\Structures\TransactionType::Expense->value }}"
                            @checked(old('type') ? old('type') == \App\Structures\TransactionType::Expense->value : $expense)>
                        <label class="form-check-label" for="expense">
                            {{ Str::ucfirst(__('transaction_types.expense')) }}
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="value" class="form-label">{{ __('forms.transaction.value') }}</label>
                    <input type="number" class="form-control" id="value"
                           placeholder="123,45" min="0.00" step="0.01"
                           name="value" value="{{ old('value') }}" required>
                </div>

                <div class="mb-3">
                    <label for="completed_at" class="form-label">{{ __('forms.transaction.completed_at') }}</label>
                    <input type="date" class="form-control" id="completed_at" name="completed_at"
                           value="{{ old('completed_at') ?? $completed_at->startOfDay()->format('Y-m-d') }}"
                           required>
                </div>

                <button class="btn btn-primary">{{ __('forms.transaction.create_button') }}</button>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.main', ['title' => __('forms.category.create_title')])

@section('main')
    <div class="row">
        <div class="col">
            <h3>{{ __('forms.category.create_title') }}</h3>

            <form method="post" action="{{ route('categories.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('forms.category.name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" required
                           placeholder="{{ __('forms.category.name_placeholder') }}" value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('forms.category.transaction_type') }}</label>

                    <div class="form-check mb-1">
                        <input class="form-check-input" type="radio" name="type"
                               id="income" value="{{ \App\Structures\TransactionType::Income->value }}"
                            @checked(old('type') ? old('type') == \App\Structures\TransactionType::Income->value : true)>
                        <label class="form-check-label" for="income">
                            {{ Str::ucfirst(__('transaction_types.income')) }}
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type"
                               id="expense" value="{{ \App\Structures\TransactionType::Expense->value }}"
                            @checked(old('type') == \App\Structures\TransactionType::Expense->value)>
                        <label class="form-check-label" for="expense">
                            {{ Str::ucfirst(__('transaction_types.expense')) }}
                        </label>
                    </div>
                </div>

                <button class="btn btn-primary">{{ __('forms.category.create_button') }}</button>
            </form>
        </div>
    </div>
@endsection

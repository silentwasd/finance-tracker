@extends('layouts.main', ['title' => __('forms.category.edit_title')])

@section('main')
    <div class="row">
        <div class="col">
            <h3>{{ __('forms.category.edit_title') }}</h3>

            <form class="d-inline" method="post" action="{{ route('categories.update', $item->id) }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('forms.category.name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" required
                           placeholder="{{ __('forms.category.name_placeholder') }}" value="{{ old('name') ?? $item->name }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('forms.category.transaction_type') }}</label>

                    <div class="form-check mb-1">
                        <input class="form-check-input" type="radio" name="type" disabled
                               id="income" value="income" @checked($item->transaction_type == \App\Structures\TransactionType::Income->value)>
                        <label class="form-check-label" for="income">
                            {{ Str::ucfirst(__('transaction_types.income')) }}
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" disabled
                               id="expense" value="expense" @checked($item->transaction_type == \App\Structures\TransactionType::Expense->value)>
                        <label class="form-check-label" for="expense">
                            {{ Str::ucfirst(__('transaction_types.expense')) }}
                        </label>
                    </div>
                </div>

                <button class="btn btn-success">{{ __('forms.category.update_button') }}</button>
            </form>

            <form class="d-inline" method="post" action="{{ route('categories.destroy', $item->id) }}">
                @csrf

                <button class="btn btn-danger">{{ __('forms.category.delete_button') }}</button>
            </form>
        </div>
    </div>
@endsection

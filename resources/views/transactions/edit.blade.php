@extends('layouts.main', ['title' => $title ?? __('forms.transaction.edit_title')])

@section('main')
    <div class="row">
        <div class="col">
            <h3>{{ __('forms.transaction.edit_title') }}</h3>

            <form class="d-inline" method="post" action="{{ route('transactions.update', $transaction->id) }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('forms.transaction.name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" required
                           placeholder="{{ __('forms.transaction.name_placeholder') }}" value="{{ old('name') ?? $transaction->name }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('forms.transaction.transaction_type') }}</label>

                    <div class="form-check mb-1">
                        <input class="form-check-input" type="radio" name="type" disabled
                               id="income" value="income" @checked($transaction->transaction_type == 'income')>
                        <label class="form-check-label" for="income">
                            {{ Str::ucfirst(__('transaction_types.income')) }}
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" disabled
                               id="expense" value="expense" @checked($transaction->transaction_type == 'expense')>
                        <label class="form-check-label" for="expense">
                            {{ Str::ucfirst(__('transaction_types.expense')) }}
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">{{ __('forms.transaction.category') }}</label>
                    <select id="category" name="category" class="form-select">
                        <option value="" @selected($transaction->category_id == null)>{{ __('forms.transaction.category_none') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected($old = old('category') ? $old == $category->id : $category->id == $transaction->category_id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="value" class="form-label">{{ __('forms.transaction.value') }}</label>
                    <input type="number" class="form-control" id="value"
                           placeholder="123,45" min="0.00" step="0.01" required
                           name="value" value="{{ old('value') ?? $transaction->value->rubles() }}">
                </div>

                <div class="mb-3">
                    <label for="completed_at" class="form-label">{{ __('forms.transaction.completed_at') }}</label>
                    <input type="date" class="form-control" id="completed_at" name="completed_at"
                           value="{{ old('completed_at') ?? $transaction->completed_at->format('Y-m-d') }}"
                           required>
                </div>

                <button class="btn btn-success">{{ __('forms.transaction.update_button') }}</button>
            </form>

            <form class="d-inline" method="post" action="{{ route('transactions.destroy', $transaction->id) }}">
                @csrf

                <button class="btn btn-danger">{{ __('forms.transaction.delete_button') }}</button>
            </form>
        </div>
    </div>
@endsection

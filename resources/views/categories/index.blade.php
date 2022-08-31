@extends('layouts.main', ['title' => __('links.categories')])

@section('side')
    <div class="row mt-3">
        <div class="col">
            <h5>{{ __('links.actions') }}</h5>

            <div class="list-group">
                <a href="#top" class="list-group-item list-group-item-action">
                    {{ __('links.top') }}
                </a>

                <a href="{{ route('categories.create') }}" class="list-group-item list-group-item-action">
                    {{ __('links.create') }}
                </a>

                <a href="#table-income" class="list-group-item list-group-item-action">
                    {{ __('tables.income_categories') }}
                </a>

                <a href="#table-expense" class="list-group-item list-group-item-action">
                    {{ __('tables.expense_categories') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@section('main')
    <div class="row">
        <div class="col">
            <table class="table" id="table-income">
                <caption class="caption-top">{{ __('tables.income_categories') }}</caption>

                <thead class="table-light sticky-top">
                <tr>
                    <th>{{ __('tables.name') }}</th>
                    <th>{{ __('tables.transaction_count') }}</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($items->where('transaction_type', \App\Structures\TransactionType::Income->value) as $item)
                    <tr>
                        <td>
                            <a href="{{ route('categories.edit', $item->id) }}" class="text-decoration-none">
                                {{ $item->name }}
                            </a>
                        </td>
                        <td>{{ $item->transactions()->count() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <table class="table" id="table-expense">
                <caption class="caption-top">{{ __('tables.expense_categories') }}</caption>

                <thead class="table-light sticky-top">
                <tr>
                    <th>{{ __('tables.name') }}</th>
                    <th>{{ __('tables.transaction_count') }}</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($items->where('transaction_type', \App\Structures\TransactionType::Expense->value) as $item)
                    <tr>
                        <td>
                            <a href="{{ route('categories.edit', $item->id) }}" class="text-decoration-none">
                                {{ $item->name }}
                            </a>
                        </td>
                        <td>{{ $item->transactions()->count() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

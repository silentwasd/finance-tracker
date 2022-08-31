@extends('layouts.main', ['title' => __('links.joint')])

@section('main')
    <div class="mb-3">
        <x-month-selector :month="$month"></x-month-selector>
    </div>

    <div class="row">
        <div class="col">

            <table class="table">
                <thead class="table-light sticky-top">
                <tr>
                    <td>{{ __('tables.transaction_type') }}</td>
                    <td>{{ __('tables.name') }}</td>
                    <td>{{ __('tables.category') }}</td>
                    <td>{{ __('tables.value') }}</td>
                    <td>{{ __('tables.date') }}</td>
                </tr>
                </thead>

                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->transaction_type == \App\Structures\TransactionType::Income->value ? __('tables.income') : __('tables.expense') }}</td>
                        <td>
                            <a href="{{ route('transactions.edit', ['transaction' => $item->id]) }}"
                               class="text-decoration-none">
                                {{ $item->name }}
                            </a>
                        </td>
                        <td>{{ $item->category->name ?? '–' }}</td>
                        <td>{{ $item->value }}</td>
                        <td>{{ $item->completed_at->format(config('app.date_format')) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection

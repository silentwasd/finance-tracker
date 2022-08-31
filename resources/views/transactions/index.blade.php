@extends('layouts.main', ['title' => $title ?? 'Transactions'])

@section('side')
    <div class="row mt-3">
        <div class="col">
            <h5>{{ __('links.actions') }}</h5>

            <div class="list-group">
                <a href="{{ route('transactions.create', ['from' => Route::currentRouteName(), 'month' => $month]) }}"
                   class="list-group-item list-group-item-action">
                    {{ __('links.create') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@section('main')
    <div class="mb-3">
        <x-month-selector :month="$month"></x-month-selector>
    </div>

    <div class="row">
        <div class="col">

            <table class="table">
                <thead class="table-light sticky-top">
                <tr>
                    <td>{{ __('tables.name') }}</td>
                    <td>{{ __('tables.category') }}</td>
                    <td>{{ __('tables.value') }}</td>
                    <td>{{ __('tables.date') }}</td>
                </tr>
                </thead>

                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>
                            <a href="{{ route('transactions.edit', $item->id) }}" class="text-decoration-none">
                                {{ $item->name }}
                            </a>
                        </td>
                        <td>{{ $item->category->name ?? '–' }}</td>
                        <td>{{ $item->value }}</td>
                        <td>{{ $item->completed_at->format('d.m.Y') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection

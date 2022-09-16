@extends('layouts.main', ['title' => 'Бюджет – Ежемесячные платежи'])

@section('side')
    <div class="row mt-3">
        <div class="col">
            <h5>{{ __('links.actions') }}</h5>

            <div class="list-group">
                <a href="#top" class="list-group-item list-group-item-action">
                    {{ __('links.top') }}
                </a>

                <a href="{{ route('budget.monthly-payments.create', ['month' => $month]) }}"
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

            <div class="overflow-auto">
                <table class="table" id="table">
                    <thead class="table-light sticky-top">
                    <tr>
                        <td>{{ __('tables.name') }}</td>
                        <td>{{ __('tables.category') }}</td>
                        <td>{{ __('tables.value') }}</td>
                        <td>{{ __('tables.scheduled_date') }}</td>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                <a href="#" class="text-decoration-none">
                                    {{ $item->name }}
                                </a>
                            </td>
                            <td>{{ $item->category->name ?? '–' }}</td>
                            <td>{{ $item->value }}</td>
                            <td>{{ $item->will_created_at->format(config('app.date_format')) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

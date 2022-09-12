@extends('layouts.main', ['title' => $title ?? 'Statistics'])

@section('side')
    <div class="row mt-3">
        <div class="col">
            <h5>{{ __('links.actions') }}</h5>

            <div class="list-group">
                <a href="#top" class="list-group-item list-group-item-action">
                    {{ __('links.top') }}
                </a>

                <a href="#table-general" class="list-group-item list-group-item-action">
                    {{ __('tables.general') }}
                </a>

                <a href="#table-name" class="list-group-item list-group-item-action">
                    {{ __('tables.by_name') }}
                </a>

                <a href="#table-time-type" class="list-group-item list-group-item-action">
                    {{ __('tables.by_category_daily') }}
                </a>

                <a href="#table-type" class="list-group-item list-group-item-action">
                    {{ __('tables.by_category') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@section('main')
    <x-month-selector :month="$month"></x-month-selector>

    <div class="row">
        <div class="col">

            @include('parts.stats.general', ['data' => $total])

            @include('parts.stats.tables.by-name', ['data' => $name])

            @include('parts.stats.tables.by-time-type', ['data' => $timeAndType])

            @include('parts.stats.tables.by-type', ['data' => $type])

            <div class="row">
                @include('parts.stats.charts.by-name', ['data' => $name])

                @include('parts.stats.charts.by-time-type', ['data' => $timeAndType])
            </div>

        </div>
    </div>
@endsection

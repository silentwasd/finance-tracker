@extends('layouts.main', ['title' => $title ?? 'Статистика'])

@section('side')
    <div class="row mt-3">
        <div class="col">
            <h5>Страница</h5>

            <div class="list-group">
                <a href="#top" class="list-group-item list-group-item-action">
                    Наверх
                </a>

                <a href="#table-general" class="list-group-item list-group-item-action">
                    Общее
                </a>

                <a href="#table-name" class="list-group-item list-group-item-action">
                    По наименованию
                </a>

                <a href="#table-time-type" class="list-group-item list-group-item-action">
                    По типу (учет по дням)
                </a>

                <a href="#table-type" class="list-group-item list-group-item-action">
                    По типу (учет по записям)
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

            @include('parts.stats.by-name', ['data' => $name])

            @include('parts.stats.by-time-type', ['data' => $timeAndType])

            @include('parts.stats.by-type', ['data' => $type])

        </div>
    </div>
@endsection

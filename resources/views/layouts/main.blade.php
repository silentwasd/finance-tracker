@extends('layouts.base', ['title' => $title])

@section('body')
    <div class="container py-4 g-0">
        <div class="row">
            <div class="col-3">
                <div class="sticky-top" style="top: 1.5rem;">
                    @include('parts.nav')
                </div>
            </div>

            <div class="col">
                @yield('main')
            </div>
        </div>
    </div>
@endsection

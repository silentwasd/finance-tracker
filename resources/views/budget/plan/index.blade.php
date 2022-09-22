@extends('layouts.main', ['title' => __('links.budget.plan')])

@section('main')
    <div class="mb-3">
        <x-month-selector :month="$month"></x-month-selector>
    </div>

    <div class="row" style="row-gap: 1rem;">
        <div class="col-12 col-lg-6">
            <div class="bg-success text-white rounded p-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="fa fa-arrow-up"></span>
                    <span>Income</span>
                </div>
                <p class="m-0 h1 fw-bold">{{ $income }}</p>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="bg-danger text-white rounded p-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="fa fa-arrow-down"></span>
                    <span>Payments</span>
                </div>
                <p class="m-0 h1 fw-bold">{{ $payments }}</p>
            </div>
        </div>

        <div class="col-12">
            <div class="bg-light border rounded p-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="fa fa-balance-scale"></span>
                    <span>Balance</span>
                </div>
                <p class="m-0 h1 fw-bold">{{ $balance }}</p>
            </div>
        </div>
    </div>
@endsection

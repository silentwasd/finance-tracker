@extends('layouts.base', ['title' => $title])

@section('body')
    <div class="container py-lg-4" id="top">
        <div class="row">
            <div class="col col-lg-3 mb-3 mb-lg-0 sticky-top" style="z-index: 1021;" id="navigation">
                <div class="row p-3 bg-light align-items-center d-flex d-lg-none sticky-top" style="z-index: 1030;" id="navigationMobilePanel">
                    <div class="col">
                        <h3 class="m-0">{{ __('links.navigation') }}</h3>
                    </div>

                    <div class="col text-end">
                        <span class="fa fa-arrow-down" id="navigationArrow"></span>
                    </div>
                </div>

                <div class="row d-none d-lg-flex sticky-top" id="navigationContent">
                    <div class="col px-4 py-2 p-lg-0">
                        @include('parts.nav')

                        @yield('side')
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg d-block pb-4 pb-lg-0 ms-lg-3" id="main">
                @yield('main')
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const nav = document.querySelector('#navigation');
            const navMobilePanel = document.querySelector('#navigationMobilePanel');
            const navArrow = document.querySelector('#navigationArrow');
            const navContent = document.querySelector('#navigationContent');
            const main = document.querySelector('#main');

            let navCollapsed = true;

            nav.addEventListener('click', () => {
                if (getComputedStyle(navMobilePanel).display !== 'flex')
                    return;

                navCollapsed = !navCollapsed;

                if (navCollapsed && !navContent.classList.contains('d-none')) {
                    main.classList.replace('d-none', 'd-block');
                    navContent.classList.replace('d-flex', 'd-none');
                    navArrow.classList.replace('fa-arrow-up', 'fa-arrow-down');
                }

                if (!navCollapsed && navContent.classList.contains('d-none')) {
                    main.classList.replace('d-block', 'd-none');
                    navContent.classList.replace('d-none', 'd-flex');
                    navArrow.classList.replace('fa-arrow-down', 'fa-arrow-up');

                    document.body.scrollIntoView(document.querySelector('#top'));
                }
            });
        });
    </script>
@endsection

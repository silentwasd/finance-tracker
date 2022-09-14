<div class="row align-items-center">
    <div class="col-auto">
        <a class="btn btn-primary {{ $prev == null ? 'disabled' : '' }}"
           href="{{ $prev ? route(Route::currentRouteName(), $prev) : '#' }}">
            <span class="fa fa-arrow-left"></span>
        </a>
    </div>

    <div class="col text-center">
        <h3 class="m-0">{{ Str::ucfirst(__("months.$current")) }}</h3>
    </div>

    <div class="col-auto">
        <a class="btn btn-primary {{ $next == null ? 'disabled' : '' }}"
           href="{{ $next ? route(Route::currentRouteName(), $next) : '#' }}">
            <span class="fa fa-arrow-right"></span>
        </a>
    </div>
</div>

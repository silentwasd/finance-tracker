<div class="row">
    <div class="col-auto">
        <a class="btn btn-primary {{ $prev == null ? 'disabled' : '' }}"
           href="{{ $prev ? route(Route::currentRouteName(), $prev) : '#' }}">
            Предыдущий
        </a>
    </div>

    <div class="col text-center">
        <h3>{{ Str::ucfirst(__("months.$current")) }}</h3>
    </div>

    <div class="col-auto">
        <a class="btn btn-primary {{ $next == null ? 'disabled' : '' }}"
           href="{{ $next ? route(Route::currentRouteName(), $next) : '#' }}">
            Следующий
        </a>
    </div>
</div>

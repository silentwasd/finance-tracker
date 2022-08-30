<div class="row">
    <div class="col">
        <h5>Страницы</h5>

        <div class="list-group">
            @foreach ($nav as $route => $name)
                <a href="{{ route($route) }}"
                   class="list-group-item list-group-item-action @if (Route::currentRouteName() == (is_array($name) ? $name[0] : $route)) active @endif">
                    {{ is_array($name) ? $name[1] : $name }}
                </a>
            @endforeach
        </div>
    </div>
</div>

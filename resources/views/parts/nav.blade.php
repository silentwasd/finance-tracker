@foreach ($nav as $group)
    <div class="row mb-3">
        <div class="col">
            <h5>{{ $group['title'] }}</h5>

            <div class="list-group">
                @foreach ($group['items'] as $route => $name)
                    @php

                    $route = isset($group['prefix']) ? $group['prefix'].$route : $route;
                    $routeName = is_array($name) ? $name[1] : $name;
                    $activeRoute = is_array($name) ? $name[0] : $route;
                    $activeRoute = isset($group['prefix']) ? $group['prefix'].$activeRoute : $activeRoute;

                    @endphp
                    <a href="{{ route($route) }}"
                       class="list-group-item list-group-item-action @if (Route::currentRouteName() == $activeRoute) active @endif">
                        {{ is_array($name) ? $name[1] : $name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endforeach

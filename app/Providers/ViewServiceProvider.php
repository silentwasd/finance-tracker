<?php

namespace App\Providers;

use App\Http\ViewComposers\NavViewComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('parts.nav', NavViewComposer::class);
    }
}

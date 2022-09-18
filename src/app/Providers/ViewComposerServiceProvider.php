<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        View::composers([
            \App\Http\ViewComposers\BookComposer::class => ['book.*', 'memo.*', 'setting.*'],
            \App\Http\ViewComposers\GenreComposer::class => ['book.create', 'book.manual'],
        ]);
    }
}

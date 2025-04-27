<?php
// app/Providers/DropboxServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Dropbox\Client;

class DropboxServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Client::class, function () {
            return new Client(config('services.dropbox.access_token'));
        });
    }
}

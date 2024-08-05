<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Session;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // ここにリスナーの設定が必要ないので削除します。
    ];

    public function boot()
    {
        parent::boot();

        Event::listen(Login::class, function () {
            Session::put('logged_in', true);
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Events\QueryExecuted;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //

//        // 监听日志记录的db操作
//        Event::listen(QueryExecuted::class, function ($event){
//            Log::info(QueryExecuted::class,
//                [
//                    'connection'=>$event->connection->getConfig(),
//                    'sql' => $event->sql,
//                    'time' => $event->time,
//                    'bindings' => $event->bindings,
//                ]);
//        });

    }
}

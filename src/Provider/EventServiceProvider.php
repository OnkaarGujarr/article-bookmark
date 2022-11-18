<?php

namespace OnkaarGujarr\Library\Provider;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use OnkaarGujarr\Library\Events\LibraryCreatedEvent;
use OnkaarGujarr\Library\Listener\LibraryCreatedListener;
use OnkaarGujarr\Library\Events\LibraryDeletedEvent;
use OnkaarGujarr\Library\Listener\LibraryDeletedListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        LibraryCreatedEvent::class => [
            LibraryCreatedListener::class,
        ],
        LibraryDeletedEvent::class => [
            LibraryDeletedListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
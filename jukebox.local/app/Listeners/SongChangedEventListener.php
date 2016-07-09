<?php

namespace App\Listeners;

use App\Events\SomeEvent;
use App\Events\SongChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SongChangedEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SomeEvent  $event
     * @return void
     */
    public function handle(SongChanged $event)
    {
        //
        \Log::alert('song change event fired');
    }
}

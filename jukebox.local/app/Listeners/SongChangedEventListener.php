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
        //\Log::alert('song change event fired');
        echo "song change event fired" . PHP_EOL;

        if(($event->status['nextsongid'] == 0) && (config('jukebox.jukebox_mode')) ){
            //todo: queue song from playlist
        }
    }
}

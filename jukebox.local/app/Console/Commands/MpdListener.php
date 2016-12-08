<?php

namespace App\Console\Commands;

use App\Events\SongChanged;
use Illuminate\Console\Command;
use lxmpd;
use Event;
use App\Repositories\SettingsRepository;

define ('MPDEVENTLISTENER_ONSTOP', 'onStop');
define ('MPDEVENTLISTENER_ONPAUSE', 'onPause');
define ('MPDEVENTLISTENER_ONSONGCHANGE', 'onSongChange');
define ('MPDEVENTLISTENER_ONPLAY', 'onPlay');
define ('MPDEVENTLISTENER_ONREPEATCHANGE', 'onRepeatChange');
define ('MPDEVENTLISTENER_ONSHUFFLECHANGE', 'onShuffleChange');
define ('MPDEVENTLISTENER_ONPLAYLISTCHANGE', 'onPlaylistChange');
define ('MPDEVENTLISTENER_ONCROSSFADECHANGE', 'onCrossfadeChange');
define ('MPDEVENTLISTENER_ONVOLUMECHANGE', 'onVolumeChange');
define ('MPDEVENTLISTENER_ONCONSUMECHANGE', 'onConsumeChange');
define ('MPDEVENTLISTENER_ONSINGLECHANGE', 'onSingleChange');
define ('MPDEVENTLISTENER_ONTIMECHANGE', 'onTimeChange');
define ('MPDEVENTLISTENER_ONOUTPUTCHANGE', 'onOutputChange');

class MpdListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mpd:listen {checkTime=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'listen for mpd events';

    private $checkTime;

    private $bindings = array();

    private $status = array();

    private $playlist = array();

    private $mpd;

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
	    if(SettingsRepository::jukeboxMode()){

		    $this->checkTime = $this->argument('checkTime');
		    $this->startListening();
	    }
    }

    public function startListening() {
        set_time_limit(0);
        do {
            lxmpd::refreshInfo();
            $this->status = lxmpd::getStatus();
            $this->playlist = lxmpd::getEnhancedPlaylist();
            sleep($this->checkTime);
            lxmpd::refreshInfo();
            $this->_checkStatus(lxmpd::getStatus(), lxmpd::getEnhancedPlaylist());
        } while (true);
    }

    public function getCheckTime() {
        return $this->checkTime;
    }

    public function setCheckTime($checkTime) {
        $this->checkTime = $checkTime;
    }

    public function getBindings() {
        return $this->bindings;
    }

    public function setBindings($bindings) {
        $this->bindings = $bindings;
    }

    public function bind($event, $function) {
        $this->bindings[$event][] = $function;
        return true;
    }

    /**
     * Unbind a function from an event. Return if it existed and done.
     *
     * @param string $event
     * @param string $function
     */
    public function unbind($event, $function) {
        if ($this->bindings[$event]) {
            $func_key = array_search($function,$this->bindings[$event]);
            if ($func_key) {
                unset($this->bindings[$event][$func_key]);
                return true;
            } else {
                return false;
            }
        } else
            return false;
    }

    private function _checkStatus($newStatus, $newPlaylist) {
        $change_status = array_diff_assoc($newStatus,$this->status);

        foreach ($change_status as $attr => $value) {
            switch ($attr) {
                case 'volume':
                    echo $value; // $this->_triggerEvent(MPDEVENTLISTENER_ONVOLUMECHANGE,$this->status['volume'],$value);
                    break;
                case 'repeat':
                    echo $value; // $this->_triggerEvent(MPDEVENTLISTENER_ONREPEATCHANGE,$this->status['repeat'],$value);
                    break;
                case 'random':
                    echo $value; // $this->_triggerEvent(MPDEVENTLISTENER_ONSHUFFLECHANGE,$this->status['random'],$value);
                    break;
                case 'single':
                    echo $value; // $this->_triggerEvent(MPDEVENTLISTENER_ONSINGLECHANGE,$this->status['single'],$value);
                    break;
                case 'consume':
                    echo $value; // $this->_triggerEvent(MPDEVENTLISTENER_ONCONSUMECHANGE,$this->status['consume'],$value);
                    break;
                case 'playlist':
                    echo $value; // $this->_triggerEvent(MPDEVENTLISTENER_ONPLAYLISTCHANGE,$this->playlist,$newPlaylist);
                    break;
                case 'xfade':
                    echo $value; // $this->_triggerEvent(MPDEVENTLISTENER_ONCROSSFADECHANGE,$this->status['xfade'],$value);
                    break;
                case 'state':
                    switch ($value) {
                        case 'pause':
                            echo $value; // $this->_triggerEvent(MPDEVENTLISTENER_ONPAUSE,$this->status['state']);
                            break;
                        case 'play':
                            echo $value; // $this->_triggerEvent(MPDEVENTLISTENER_ONPLAY,$this->status['state']);
                            break;
                        case 'stop':
                            echo $value; // $this->_triggerEvent(MPDEVENTLISTENER_ONSTOP,$this->status['state']);
                            break;
                    }
                    break;
                case 'songid':
                    Event::fire( new SongChanged($newStatus) );
                    break;
                case 'time':
                    echo $value; // $this->_triggerEvent(MPDEVENTLISTENER_ONTIMECHANGE,$this->status['time'],$value);
                    break;
            }
        }
    }
    public function _triggerEvent($one = null, $two = null, $three = null){
        echo $one . PHP_EOL;
        return;
    }
}

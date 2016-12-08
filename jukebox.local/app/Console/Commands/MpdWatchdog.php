<?php

namespace App\Console\Commands;

use App\Service\PlayerService;
use Illuminate\Console\Command;
use App\Repositories\SettingsRepository;
use lxmpd;

class MpdWatchdog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mpd:watchdog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes sure the mpd doesn\'t stop playing';

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
    public function handle() {

	    if (SettingsRepository::jukeboxMode()) {

		    $status = lxmpd::getStatus();

		    if ($status['nextsongid'] == 0) {
			    $playerService = new PlayerService();
			    $playerService->queueRandomTrack();
		    }

		    if ($status['state'] != 'playing') {
			    lxmpd::play();
			    lxmpd::refreshInfo();
		    }
	    }
    }
}

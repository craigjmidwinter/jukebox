<?php

namespace App\Listeners;

use App\Events\SomeEvent;
use App\Events\SongChanged;
use \App\Track;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use lxmpd;
use App\Repositories\SettingsRepository;
use App\Service\PlayerService;

class SongChangedEventListener {

	/**
	 * Create the event listener.
	 *
	 * @return void
	 */

	public function __construct()
	{

	}

	/**
	 * Handle the event.
	 *
	 * @param  SomeEvent $event
	 * @return void
	 */
	public function handle(SongChanged $event) {

		$playerService = new PlayerService();
		//
		//\Log::alert('song change event fired');
		echo "song change event fired jukebox mode: " . SettingsRepository::jukeboxMode() . PHP_EOL;

		$this->queueMaintenance();

		if (($event->status['nextsongid'] == 0) && (SettingsRepository::jukeboxMode())) {
			$playerService->queueRandomTrack();
		}
	}

	private function queueMaintenance() {

		echo 'queue maintenance' . PHP_EOL;
		$track = false;

		$currentSong = lxmpd::getCurrentTrack();

		if (isset($currentSong['file'])) {
			$uri = $currentSong['file'];
			$track = Track::firstOrCreate(array('uri' => $uri));
		} else {
			var_dump($currentSong);
		}

		if ($track) {
			$track->updateLastPlayed();
		}
	}
}

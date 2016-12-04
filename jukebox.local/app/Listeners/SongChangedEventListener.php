<?php

namespace App\Listeners;

use App\Events\SomeEvent;
use App\Events\SongChanged;
use \App\Track;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use lxmpd;
use App\Settings;
use App\Repositories\SettingsRepository;

class SongChangedEventListener {

	/**
	 * Create the event listener.
	 *
	 * @return void
	 */

	const DUPE_COUNT = 7;

	public $allowDuplicates;

	public $jukeboxMode;

	public $dupeTimestamp;

	public function __construct() {

		//
		$this->jukeboxMode = SettingsRepository::getSettingByKey('jukebox-mode') == Settings::JUKEBOX_MODE_ON;
		$this->allowDuplicates = SettingsRepository::getSettingByKey('allow-duplicates') == 'on';

		$this->dupeTimestamp = strtotime('-2 hours');
	}

	/**
	 * Handle the event.
	 *
	 * @param  SomeEvent $event
	 * @return void
	 */
	public function handle(SongChanged $event) {

		//
		//\Log::alert('song change event fired');
		echo "song change event fired jukebox mode: " . $this->jukeboxMode . PHP_EOL;


		//var_dump($event);
		$this->queueMaintenance();


		if (($event->status['nextsongid'] == 0) && ($this->jukeboxMode)) {

			$songFound = false;
			$songAttempts = 0;

			while (!$songFound) {

				$song = $this->getRandomSong();

				if($song['file']){
					$track = Track::whereUri($song['file'])->first();
				} else{
					var_dump($song);
				}

				if ($track) {
					echo PHP_EOL;
					echo PHP_EOL;
					echo 'Track found for ' . $song['file'] . PHP_EOL;
					echo 'last played: ' . $track->last_played . PHP_EOL;
					echo 'dupestamp: ' . $this->dupeTimestamp . PHP_EOL;
					echo 'dupe: ' . ($track->last_played > $this->dupeTimestamp ? 'yes' : 'no') . PHP_EOL;

				} else {
					echo PHP_EOL;echo PHP_EOL;
					echo 'No track found for ' . $song['file'] . PHP_EOL;
				}

				if (!$track || $track->last_played < $this->dupeTimestamp || $songAttempts >= self::DUPE_COUNT || $this->allowDuplicates) {
					$songURI = $song['file'];
					$songFound = true;
				} else {
					$songAttempts++;

					if ($track->last_played > $this->dupeTimestamp) {
						echo 'pick attempt #' . $songAttempts . PHP_EOL;
						echo 'picked song ' . $track->uri . ' just played' . PHP_EOL;
					}
				}

			}

			lxmpd::queue($songURI);

		}
	}

	private function getRandomSong() {

		$songs = lxmpd::runCommand('listall');

		$queuesong = array_rand($songs, 1);

		$song = $songs[$queuesong];

		return $song;
	}

	private function queueMaintenance() {

		echo 'queue maintenance' . PHP_EOL;
		$track = false;

		$currentSong = lxmpd::getCurrentTrack();
		//var_dump($currentSong);

		if (isset($currentSong['Title']) && isset($currentSong['Artist']) && isset($currentSong['file'])) {

			$title = $currentSong['Title'];
			$artist = $currentSong['Artist'];
			$uri = $currentSong['file'];

			$track = Track::firstOrCreate(array('title' => $title, 'artist' => $artist, 'uri' => $uri));

		} elseif (isset($currentSong['file'])) {

			$uri = $currentSong['file'];
			$track = Track::firstOrCreate(array('uri' => $uri));
		} else {
			//echo 'No track found for ' . $currentSong['file'] . PHP_EOL;

			var_dump($currentSong);
		}

		if ($track) {
			$track->updateLastPlayed();
		}
	}
}

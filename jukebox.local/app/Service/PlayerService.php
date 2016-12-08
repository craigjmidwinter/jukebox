<?php
namespace App\Service;

use App\Settings;
use App\Repositories\SettingsRepository;
use App\Track;
use lxmpd;

class PlayerService {

	const DUPE_COUNT = 15;

	public $allowDuplicates;
	public $jukeboxMode;
	public $dupeTimestamp;

	public function __construct() {

		$this->jukeboxMode = SettingsRepository::getSettingByKey('jukebox-mode') == Settings::JUKEBOX_MODE_ON;
		$this->allowDuplicates = SettingsRepository::getSettingByKey('allow-duplicates') == 'on';

		$this->dupeTimestamp = strtotime(Settings::DUPE_TIME);
	}

	public function queueRandomTrack(){

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

				if ($track->last_played < strtotime(Settings::DUPE_TIME) || $songAttempts >= self::DUPE_COUNT || $this->allowDuplicates) {
					$track->queueTrack();
					$songFound = true;
				} elseif ($track->last_played > $this->dupeTimestamp) {
					echo 'pick attempt #' . $songAttempts . PHP_EOL;
					echo 'picked song ' . $track->uri . ' just played' . PHP_EOL;
				}
			} else {
				echo PHP_EOL . PHP_EOL;
				echo 'No track found for ' . $song['file'] . PHP_EOL;
			}

			$songAttempts++;
		}
	}

	private function getRandomSong() {

		$songs = lxmpd::runCommand('listall');
		$queuesong = array_rand($songs, 1);
		$song = $songs[$queuesong];

		return $song;
	}

}
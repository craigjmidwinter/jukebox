<?php

namespace App;

use App\Repositories\SettingsRepository;
use Illuminate\Database\Eloquent\Model;
use lxmpd;

/**
 * App\Track
 *
 * @mixin \Eloquent
 * @property int $id
 * @property integer $last_played
 * @property string $title
 * @property string $artist
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereLastPlayed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereArtist($value)
 * @property string $uri
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereUri($value)
 * @property integer $artist_id
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereArtistId($value)
 */
class Track extends Model {

	//
	public $timestamps = false;

	protected $fillable = ['title', 'artist_id', 'last_played', 'uri'];

	/**
	 * Updates the last played with the current timestamp
	 */
	public function updateLastPlayed() {

		echo 'updating';

		$this->last_played = strtotime('now');
		$this->save();
	}

	public function queueTrack($queueType = Queue::AUTO_QUEUE) {

		$queueRecord = new Queue(['track_id' => $this->id, 'queue_type' => $queueType]);
		$queueRecord->queue_time = strtotime('now');
		$queueRecord->save();

		lxmpd::queue($this->uri);
	}

	public function artist() {

		return $this->belongsTo('App\Artist');
	}

	public function queueRecords() {

		return $this->hasMany('App\Queue');
	}

	public function lastQueueTime() {

		$queueRecord =
			Queue::where('track_id', $this->id)
				->orderBy('queue_time', 'desc')
				->first();

		return $queueRecord ? $queueRecord->queue_time : 0;
	}


}

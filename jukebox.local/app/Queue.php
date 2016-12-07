<?php
/**
 * Queue Records
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Queue
 *
 * @property-read \App\Track $track
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Queue[] $queueRecords
 * @mixin \Eloquent
 * @property int $id
 * @property integer $song_id
 * @property integer $queue_time
 * @property integer $queue_type
 * @method static \Illuminate\Database\Query\Builder|\App\Queue whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Queue whereSongId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Queue whereQueueTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Queue whereQueueType($value)
 */
class Queue extends Model
{
    //

	const USER_QUEUE = 1;
	const AUTO_QUEUE = 2;

	public $timestamps = false;

	protected $fillable = ['track_id', 'queue_type'];

	public function track(){
		return $this->belongsTo('App\Track');
	}
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
 */
class Track extends Model
{
    //
	public $timestamps = false;
	protected $fillable = ['title','artist','last_played','uri'];

	/**
	 * Updates the last played with the current timestamp
	 */
	public function updateLastPlayed(){

		echo 'updating';
		$now = new \DateTime();

		$this->last_played = $now->getTimestamp();
		$this->save();

	}
}

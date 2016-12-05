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
 * @property string $uri
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereUri($value)
 * @property integer $artist_id
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereArtistId($value)
 */
class Track extends Model
{
    //
	public $timestamps = false;
	protected $fillable = ['title','artist_id','last_played','uri'];

	/**
	 * Updates the last played with the current timestamp
	 */
	public function updateLastPlayed(){

		echo 'updating';

		$this->last_played = strtotime('now');
		$this->save();
	}

	public function artist(){
		return $this->belongsTo('App\Artist');
	}
}

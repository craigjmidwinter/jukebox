<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    //
	public $timestamps = false;
	protected $fillable = ['title','artist','last_played'];

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

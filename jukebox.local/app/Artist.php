<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Artist
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Track[] $tracks
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereName($value)
 */
class Artist extends Model
{
    //
	public $timestamps = false;
	protected $fillable = ['name'];

	public function tracks(){
		return $this->hasMany('App\Track');
	}
}

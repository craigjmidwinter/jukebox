<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Settings
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $setting
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\App\Settings whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Settings whereSetting($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Settings whereValue($value)
 */
class Settings extends Model
{
	const JUKEBOX_MODE_ON = 'on';
	const JUKEBOX_MODE_OFF = 'off';

	const DUPE_TIME = '-1 Day';


	protected $table = 'settings';

	//
}

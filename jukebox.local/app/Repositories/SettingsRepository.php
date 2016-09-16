<?php

namespace App\Repositories;

use App\Settings;
use Illuminate\Support\Facades\DB;

class SettingsRepository extends Repository
{

	/**
	 * @param $key
	 */
	public static function getSettingByKey($key){

		$setting = Settings::whereSetting($key)->first();

		return ($setting) ? $setting->value : false;

	}

	public static function setSetting($key, $value){

/*
		DB::table('settings')
			->where('setting', $key)->first();

		return $results->value;
*/
	}
}

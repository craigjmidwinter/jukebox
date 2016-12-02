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

		$setting = DB::table('settings');

		return $setting->updateOrInsert(['setting' => $key],['value' => $value]);
	}

	public static function jukeboxMode(){
		return self::getSettingByKey('jukebox-mode') == 'on' ? true : false;
	}

	public static function allowDuplicates(){
		return self::getSettingByKey('allow-duplicates') == 'on' ? true : false;
	}
}

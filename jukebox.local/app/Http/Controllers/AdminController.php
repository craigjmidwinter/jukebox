<?php

namespace App\Http\Controllers;

use App\Repositories\SettingsRepository;
use App\Settings;
use Illuminate\Http\Request;

use App\Http\Requests;
use lxmpd;

class AdminController extends Controller
{
    //
	public function __construct() {

		$this->middleware('auth');
	}
	
	public function index() {
		$data = [];

		$data['jukeboxMode'] = (SettingsRepository::getSettingByKey('jukebox-mode') == Settings::JUKEBOX_MODE_ON) ? true : false;
		$data['jukeboxDuplicates'] = (SettingsRepository::getSettingByKey('allow-duplicates') == 'on') ? true : false;
		$data['jukeboxPlaylist'] = SettingsRepository::getSettingByKey('jukebox-playlist');
		$data['playlistValid'] = lxmpd::playlistExists(SettingsRepository::getSettingByKey('jukebox-playlist'));
		$data['allPlaylists'] = lxmpd::runCommand("listplaylists");

		return \View::make('admin/admin', $data);
	}
	
	public function postSaveJukeboxSettings (Request $request) {
		$playlist = lxmpd::playlistExists($request->input('jukeboxPlaylist'))? $request->input('jukeboxPlaylist') : '';

		SettingsRepository::setSetting('jukebox-mode', ($request->input('jukeboxMode') == 'on') ? 'on' : 'off' );
		SettingsRepository::setSetting('allow-duplicates', ($request->input('allowDuplicates') == 'on')? 'on' : 'off');
		SettingsRepository::setSetting('jukebox-playlist', ($request->input('allowDuplicates') == 'on')? 'on' : 'off');


		return $this->index();
	}

	public function dumpSettings(Request $request){
		$settings = Settings::all();

		return new JsonResponse($settings);
	}
}

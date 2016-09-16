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
		$data['jukeboxPlaylist'] = config('jukebox.playlist');
		$data['playlistValid'] = lxmpd::playlistExists(config('jukebox.playlist'));
		$data['allPlaylists'] = lxmpd::runCommand("listplaylists");

		return \View::make('admin/admin', $data);
	}
	
	public function postSaveJukeboxSettings (Request $request) {
		$playlist = lxmpd::playlistExists($request->input('jukeboxPlaylist'))? $request->input('jukeboxPlaylist') : '';

		config([
		'jukebox.jukebox_mode' => (($request->input('jukeboxMode') == 'on')? true : false),
		'jukebox.allow_duplicates' => (($request->input('allowDuplicates') == 'on')? true : false),
		'jukebox.playlist' => $playlist,
		]);

		return $this->index();
	}

	public function dumpSettings(Request $request){
		$settings = Settings::all();


	}
}

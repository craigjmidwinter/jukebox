<?php

namespace App\Http\Controllers;

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

		$data['jukeboxMode'] = config('jukebox.jukebox_mode');
		$data['jukeboxDuplicates'] = config('jukebox.allow_duplicates');
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
}

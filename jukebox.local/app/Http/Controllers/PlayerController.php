<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use lxmpd;

class PlayerController extends Controller
{
    //
	public function updateLibrary(){
		lxmpd::runCommand('update');

		lxmpd::refreshInfo();

		return "updating";
	}

	public function getNowPlayingInfo(){
		$data['artist'] = lxmpd::getCurrentTrack();
	}
	
	public function postQueueSong(Request $request){
		$songUri = $request->input('song');
		
		lxmpd::queue($songUri);
	}
	
	public function play(){
		lxmpd::play();

		lxmpd::refreshInfo();

		\Redirect::action();
	}
}

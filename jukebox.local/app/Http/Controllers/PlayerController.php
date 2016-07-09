<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use lxmpd, URL, Redirect;
use Psy\Util\Json;
use Symfony\Component\HttpFoundation\JsonResponse;

class PlayerController extends Controller
{
    //
	public function updateLibrary(){
		lxmpd::runCommand('update');

		lxmpd::refreshInfo();

		return "updating";
	}

	public function getNowPlayingInfo(){
		
		$data = [];
		$currentSong = lxmpd::getCurrentTrack();
		$status = lxmpd::getStatus();
		
		if(key_exists('Title', $currentSong)){
			$data['currentSong'] = $currentSong['Title'];
			$data['currentArtist'] = $currentSong['Artist'];
			$data['time'] = $status['time'];
		} else {
			$data['currentSong'] = 0;
			$data['currentArtist'] = 0;
			$data['time'] = $status['time'];
		}
		
		return new JsonResponse($data);
	}
	
	public function postQueueSong(Request $request){
		$songUri = $request->input('song');
		
		lxmpd::queue($songUri);

		$status = lxmpd::getStatus();

		if($status['state'] != 'playing'){
			lxmpd::play();
			lxmpd::refreshInfo();
		}

		return redirect('/');
	}
	
	public function play(){
		lxmpd::play();

		lxmpd::refreshInfo();

		return redirect('/');
	}

	public function status(){

		$status = lxmpd::getStatus();

		return new JsonResponse($status);

	}
}

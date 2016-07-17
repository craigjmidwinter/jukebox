<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use lxmpd, URL, Redirect, View;
use Symfony\Component\HttpFoundation\StreamedResponse as StreamedResponse;

class PlayerController extends Controller
{
    //
	public function updateLibrary(){
		lxmpd::runCommand('update');

		lxmpd::refreshInfo();

		return "updating";
	}

	public function getNowPlayingInfo(){

		$response = new StreamedResponse();
		$response->headers->set('Content-Type', 'text/event-stream');
		$response->headers->set('Cache-Control', 'no-cache');
		$response->setCallback( function() {
			while(true) {
				$data = [];
				$currentSong = lxmpd::getCurrentTrack();
				$status = lxmpd::getStatus();

				if (key_exists('Title', $currentSong)) {
					$data['currentSong'] = $currentSong['Title'];
					$data['currentArtist'] = $currentSong['Artist'];
					$data['time'] = $status['time'];
				} else {
					$data['currentSong'] = 0;
					$data['currentArtist'] = 0;
					$data['time'] = $status['time'];
				}

				//echo "event: now playing\n";
				$dataString = json_encode($data, JSON_FORCE_OBJECT);
				sleep(3);
				echo "data: " . $dataString;
				ob_flush();
				flush();
			}

		});

		$response->send();
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

	public function getPlaylists($playlist = null){
		if($playlist !== null){
			$list = lxmpd::runCommand("listplaylist", $playlist );
		}else{
			$list = lxmpd::runCommand("listplaylists");
		}

		return new JsonResponse($list);

	}

	/**
	 * temporary route for debugging command output
	 */
	public function debug(){
		
		//$ret = lxmpd::runCommand('listall');


		$songs = lxmpd::runCommand('listall');

		$queuesong = array_rand ($songs,1);

		$song = $songs[$queuesong];
		$songURI = $song['file'];
		lxmpd::queue($songURI);


		return new JsonResponse($songURI);
	}
}

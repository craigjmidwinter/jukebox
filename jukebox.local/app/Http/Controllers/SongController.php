<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use lxmpd,View;

class SongController extends Controller
{
    //
	public function getSongList($artist){

		$songs = [];

		$artist = urldecode($artist);

		$data['listingType'] = 'song';
		$data['artist'] = $artist;
		$data['pageSubtitle'] = $artist;
		

	//	$albums = lxmpd::runCommand("list",["album", stripslashes($artist)]);

	//	foreach($albums as $album){
			$songs = lxmpd::runCommand('find',["artist", $artist]);
	//	}

		usort($songs, function ($item1, $item2) {
			return $item1['Title'] <=> $item2['Title'];
		});

		$data['songs'] = $songs;
		
		return View::make('listing/listing', $data);
		
	}
}

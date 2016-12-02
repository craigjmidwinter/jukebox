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

		$songsfiltered =[];

		foreach ($songs as $song){
			if(isset($song['Title'])){
				$songsfiltered[] = $song;
			}
		}
		usort($songsfiltered, function ($item1, $item2) {

			return ($item1['Title'] < $item2['Title']) ? -1 : (($item1['Title'] > $item2['Title']) ? 1 : 0);
		});

		$data['songs'] = $songsfiltered;
		
		return View::make('listing/listing', $data);
		
	}
}

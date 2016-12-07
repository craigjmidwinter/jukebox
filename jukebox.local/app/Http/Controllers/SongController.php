<?php

namespace App\Http\Controllers;

use App\Artist;
use App\Track;
use App\Settings;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use lxmpd,View;
//use Artist

class SongController extends Controller
{
    //
	public function getSongList($artistId){

		$artist = Artist::whereId($artistId)->first();
		$songs = new Collection();

		$data['listingType'] = 'song';
		$data['artist'] = $artist->name;
		$data['pageSubtitle'] = $artist->name;

		$tracks = Track::whereArtistId($artist->id)
			->where('last_played','<=',strtotime(Settings::DUPE_TIME))
			->get();

		foreach ($tracks as $track){
			$queueTime = $track->lastQueueTime();
			if($queueTime <= strtotime(Settings::DUPE_TIME)){
				$songs->add($track);
			}
		}

		$data['songs'] = $songs;
		
		return View::make('listing/listing', $data);
		
	}
}

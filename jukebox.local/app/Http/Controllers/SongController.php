<?php

namespace App\Http\Controllers;

use App\Artist;
use App\Track;
use App\Settings;
use Illuminate\Http\Request;

use App\Http\Requests;
use lxmpd,View;
//use Artist

class SongController extends Controller
{
    //
	public function getSongList($artistId){

		$artist = Artist::whereId($artistId)->first();

		$data['listingType'] = 'song';
		$data['artist'] = $artist->name;
		$data['pageSubtitle'] = $artist->name;

		$songs = $artist->tracks()
			->where('last_played','<=',strtotime(Settings::DUPE_TIME))
			->orderBy('title')
			->get();

		$data['songs'] = $songs;
		
		return View::make('listing/listing', $data);
		
	}
}

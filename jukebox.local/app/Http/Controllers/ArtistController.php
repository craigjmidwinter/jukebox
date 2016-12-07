<?php

namespace App\Http\Controllers;

use App\Artist;
use App\Settings;
use App\Track;
use Illuminate\Http\Request;

use App\Http\Requests;

use lxmpd, View;


class ArtistController extends Controller
{

	function __construct() {

	}

	public function getArtistList(){

		$data['listingType'] = 'artist';

		$artists = Artist::orderBy('name')->get();
		$playableArtists = [];

		foreach ($artists as $artist){

			$tracksAvailable = 0;

			$tracks = Track::whereArtistId($artist->id)
						->where('last_played','<=',strtotime(Settings::DUPE_TIME))
						->get();

			foreach ($tracks as $track){
				$queueTime = $track->lastQueueTime();
				if($queueTime <= strtotime(Settings::DUPE_TIME)){
					$tracksAvailable++;
				}
			}

			if($tracksAvailable > 0){
				$playableArtists[] = $artist;
			}
		}

		$data['artists'] = $playableArtists;
		$data['pageSubtitle'] = 'Artists';
		
		return View::make('listing/listing', $data);

	}
}

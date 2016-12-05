<?php

namespace App\Http\Controllers;

use App\Artist;
use App\Settings;
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
			$tracksAvailable = $artist->tracks()->where('last_played','<=',strtotime(Settings::DUPE_TIME))->count();

			if($tracksAvailable > 0){
				$playableArtists[] = $artist->name;
			}
		}

		$data['artists'] = $playableArtists;
		$data['pageSubtitle'] = 'Artists';
		
		return View::make('listing/listing', $data);

	}
}

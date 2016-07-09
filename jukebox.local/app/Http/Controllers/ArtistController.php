<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use lxmpd, View;


class ArtistController extends Controller
{

	function __construct() {

	}

	public function getArtistList(){

		$data['listingType'] = 'artist';
		$data['artists'] = lxmpd::runCommand('list','artist');
		$data['pageSubtitle'] = 'Artists';
		$currentSong = lxmpd::getCurrentTrack();
		$data['currentSong'] = $currentSong['Title'];
		$data['currentArtist'] = $currentSong['Artist'];
		return View::make('listing/listing', $data);

	}
}

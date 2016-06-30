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

		$data['listing_type'] = 'artist';
		$data['artists'] = lxmpd::runCommand('list','artist');

		return View::make('listing\listing', $data);


	}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use LxMpd;


class ArtistController extends Controller
{

	function __construct() {
		parent::__construct();



		// Authenticate to MPD
		//$this->xMPD->authenticate();
		// Refresh the xMPD properties with status and statistics from MPD
		//$this->xMPD->refreshInfo();
	}

	public function getArtistList(){

		//$artists = lmpd::class;



	}
}

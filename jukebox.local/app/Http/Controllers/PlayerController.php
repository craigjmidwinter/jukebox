<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use lxmpd;

class PlayerController extends Controller
{
    //
	public function updateLibrary(){
		lxmpd::runCommand('update');

		lxmpd::refreshInfo();

		return "updating";
	}
}

<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Jukebox Mode
	|--------------------------------------------------------------------------
	|
	| When set to true, the player will queue up a random song from the optional jukebox playlist
	|
	*/
	'jukebox.jukebox_mode' => true,

	/*
	|--------------------------------------------------------------------------
	| Jukebox Playlist
	|--------------------------------------------------------------------------
	|
	| If set to a valid playlist, random songs will only be from this playlist
	|
	*/
	'jukebox.playlist' => '',

	/*
	|--------------------------------------------------------------------------
	| Jukebox Duplicates
	|--------------------------------------------------------------------------
	|
	| When set to false, songs will not be queable after being played once.
	|
	*/
	'jukebox.allow_duplicates' => true,
]; 
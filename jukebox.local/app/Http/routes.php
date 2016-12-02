<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/','ArtistController@getArtistList');

Route::get('/artists','ArtistController@getArtistList');

Route::get('/{artist}/songs','SongController@getSongList');

Route::get('/admin/update','PlayerController@updateLibrary');

Route::post('/queue','PlayerController@postQueueSong');

Route::get('/play','PlayerController@play');

Route::get('/admin/dumpSettings', 'AdminController@dumpSettings');
//Route::auth();

Route::any('/admin', 'AdminController@index');

Route::get('/get/nowPlaying', 'PlayerController@getNowPlayingInfo');
Route::get('/get/status', 'PlayerController@status');

Route::get('/get/playlists/{playlist?}', 'PlayerController@getPlaylists');

Route::post('/admin/saveSettings', 'AdminController@postSaveJukeboxSettings');

Route::get('/debug', 'PlayerController@debug');
Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/thanks', 'PlayerController@thanks');

/**
 * Created by craig on 2016-07-17.
 */
$( document ).ready(function() {
	if(typeof(EventSource) !== "undefined") {

		var source = new EventSource("/get/nowPlaying");
		source.onopen = function () {
			console.log('connection opened');
		};
		source.onmessage = function(e) {
			var data = e.data;
			setNowPlaying(data.currentSong,data.currentArtist);
			console.log(data);
		};
		source.onerror = function(e) {
			var data = e.data;
			console.log(data);
		};
	} else {
		$('#trackInfo').html('Your Browser Cant support Server Side Event');

	}
});

function setNowPlaying(song,artist) {
	$('#currentArtist').val = artist;
	$('#currentSong').val = song;
}
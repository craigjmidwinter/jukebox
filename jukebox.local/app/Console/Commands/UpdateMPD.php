<?php

namespace App\Console\Commands;

use App\Artist;
use App\Track;
use Illuminate\Console\Command;
use lxmpd;
use DB;

class UpdateMPD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mpd:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update mpc and refresh tracks table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
	    if($this->confirm('This will remove all data from the queue table and repopulate the tracks and artists, are you sure?')){

		    $command = "mpc -h '" . config('lxmpd.password') ."@localhost' update";

		    exec($command);

		    DB::table('tracks')->truncate();
		    DB::table('artists')->truncate();
		    DB::table('queues')->truncate();

		    $allFiles = $data['artists'] = lxmpd::runCommand('listallinfo');

		    foreach ($allFiles as $file){

			    if(isset($file['Artist']) && isset($file['Title']) && isset($file['file'])){
				    $artist = Artist::firstOrCreate(array('name' => $file['Artist']));
				    $track = new Track(array('title' => $file['Title'],'artist_id' => $artist->id,'uri' => $file['file']));
				    $track->save();
			    }
		    }
	    }

    }
}

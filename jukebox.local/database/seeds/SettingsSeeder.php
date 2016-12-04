<?php

use Illuminate\Database\Seeder;
use App\Repositories\SettingsRepository;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
	    SettingsRepository::setSetting('jukebox-mode', 'on');
	    SettingsRepository::setSetting('allow-duplicates', 'off');
	    //SettingsRepository::setSetting('jukebox-playlist', 'on');
    }
}

<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'Craig',
            'email' => 'ward.craig.j@gmail.com',
            'password' => bcrypt('w3dding'),
        ]);
    }
}

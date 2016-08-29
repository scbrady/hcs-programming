<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\User::create([
	        'name' => 'Scott Brady',
	        'email' => 'a@a.a',
            'permissions' => 0,
	        'password' => 'password',
	    ]);

        \App\Models\User::create([
	        'name' => 'Dan Khilkovets',
	        'email' => 'khilkovetsnaa@gmail.com',
            'permissions' => 1,
	        'password' => 'password',
	    ]);

        \App\Models\User::create([
	        'name' => 'Alex Soto',
	        'email' => 'johnalex.soto@yahoo.com',
            'permissions' => 1,
	        'password' => 'password',
	    ]);
    }
}
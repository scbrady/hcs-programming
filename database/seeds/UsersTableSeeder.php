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
	        'name' => 'Tester',
	        'email' => 'b@b.b',
            'permissions' => 1,
	        'password' => 'password',
	    ]);
    }
}
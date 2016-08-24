<?php

use Illuminate\Database\Seeder;

class AssignmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\Assignment::create([
	        'name' => 'Program 1',
	        'description' => 'Hello World',
            'due' => '2016-10-23',
	    ]);

        \App\Models\Assignment::create([
	        'name' => 'Program 2',
	        'description' => 'Variables',
            'due' => '2016-11-23',
	    ]);
    }
}
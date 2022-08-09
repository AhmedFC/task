<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

	        User::create([
	            'name' => "Ahmed",
	            'email' => "ahmed@gmail.com",
                'password' => bcrypt('123456'),
            ]);

        User::create([
            'name' => "Ali",
            'email' => "ali@gmail.com",
            'password' => bcrypt('123456'),
        ]);

    }
}

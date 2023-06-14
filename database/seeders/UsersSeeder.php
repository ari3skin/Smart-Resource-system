<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //date format YYYY-MM-DD
        DB::table('users')
            ->insert([
                [
                    'employer_id' => 101,
                    'username' => 'ryan_kathurima',
                    'password' => Hash::make('admin@123'),
                    'email_verified_at' => '2005-04-1 12:00:00',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]);
    }
}

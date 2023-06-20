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
                    'employee_id' => null,
                    'role' => 'Admin',
                    'username' => 'ryan_kathurima@resource.arcadian.org',
                    'password' => Hash::make('admin@123'),
                    'email_verified_at' => '2005-04-1 12:00:00',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'employer_id' => 102,
                    'employee_id' => null,
                    'role' => 'Employer',
                    'username' => 'megan_mwago@resource.arcadian.org',
                    'password' => Hash::make('admin@123'),
                    'email_verified_at' => '2007-12-17 12:00:00',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'employer_id' => null,
                    'employee_id' => 101,
                    'role' => 'Employee',
                    'username' => 'reece_elroy@resource.arcadian.org',
                    'password' => Hash::make('admin@123'),
                    'email_verified_at' => '2015-05-23 12:00:00',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]);
    }
}

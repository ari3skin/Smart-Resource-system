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
                    'identifier'=>'ADM_',
                    'employer_id' => 101,
                    'employee_id' => null,
                    'role' => 'Admin',
                    'username' => 'ryan_kathurima@resource.arcadian.com',
                    'password' => Hash::make('admin@123'),
                    'email_verified_at' => '2005-04-1 12:00:00',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'identifier'=>'MNGR_',
                    'employer_id' => 102,
                    'employee_id' => null,
                    'role' => 'Manager',
                    'username' => 'megan_mwago@resource.arcadian.com',
                    'password' => Hash::make('admin@123'),
                    'email_verified_at' => '2007-12-17 12:00:00',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'identifier'=>'EPE_',
                    'employer_id' => null,
                    'employee_id' => 101,
                    'role' => 'Employee',
                    'username' => 'reece_elroy@resource.arcadian.com',
                    'password' => Hash::make('admin@123'),
                    'email_verified_at' => '2015-05-23 12:00:00',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]);
    }
}

<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //date format YYYY-MM-DD
        DB::table('employers')
            ->insert([
                [
                    'department_id' => 101,
                    'designation_id' => 101,
                    'first_name' => 'Ryan',
                    'last_name' => 'Kathurima',
                    'email' => 'ryankinotikathurima@gmail.com',
                    'phone_number' => '0797236922',
                    'employed_date' => '2005-03-30',
                    'DOB' => '1976-05-23',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]);
    }
}

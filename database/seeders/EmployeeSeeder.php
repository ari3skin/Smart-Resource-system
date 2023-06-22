<?php

namespace Database\Seeders;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('employees')
            ->insert([
                [
                    'department_id' => 104,
                    'designation_id' => 102,
                    'first_name' => 'Reece',
                    'last_name' => 'Elroy',
                    'email' => 'reece.elroy@arcadianbank.com',
                    'phone_number' => '0797236922',
                    'employed_date' => '2005-03-30',
                    'DOB' => '1976-05-23',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]);

        for ($i = 0; $i < 150; $i++) {
            Employee::factory()->create();
        }
    }
}

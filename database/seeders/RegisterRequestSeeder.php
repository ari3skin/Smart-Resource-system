<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Employer;
use App\Models\UserRegistrationRequest;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegisterRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $employerInfo = Employer::inRandomOrder()->take(10)->get();
        $employeeInfo = Employee::inRandomOrder()->take(10)->get();

        foreach ($employerInfo as $employer) {
            UserRegistrationRequest::create([
                'employer_id' => $employer->id,
                'employee_id' => null,
                'work_email' => $employer->email,
                'request_date' => Carbon::now(),
            ]);
        }
        foreach ($employeeInfo as $employee) {
            UserRegistrationRequest::create([
                'employee_id' => $employee->id,
                'employer_id' => null,
                'work_email' => $employee->email,
                'request_date' => Carbon::now(),
            ]);
        }

    }
}

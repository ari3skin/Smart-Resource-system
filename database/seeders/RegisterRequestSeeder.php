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
        $employerInfo = Employer::inRandomOrder()->take(100)->get();
        $employeeInfo = Employee::inRandomOrder()->take(100)->get();

        $totalIterations = 200;
        $switchIteration = rand(1, $totalIterations);

        $employerCount = 0;
        $employeeCount = 0;

        for ($i = 0; $i < $totalIterations; $i++) {
            if ($i === $switchIteration) {
                // Switch between employer and employee loop
                $switchIteration += rand(1, $totalIterations);
                $temp = $employerCount;
                $employerCount = $employeeCount;
                $employeeCount = $temp;
            }

            if ($i % 2 === 0) {
                if ($employerCount < count($employerInfo)) {
                    $employer = $employerInfo[$employerCount];
                    UserRegistrationRequest::create([
                        'employer_id' => $employer->id,
                        'employee_id' => null,
                        'work_email' => $employer->email,
                        'request_date' => Carbon::now(),
                    ]);
                    $employerCount++;
                }
            } else {
                if ($employeeCount < count($employeeInfo)) {
                    $employee = $employeeInfo[$employeeCount];
                    UserRegistrationRequest::create([
                        'employee_id' => $employee->id,
                        'employer_id' => null,
                        'work_email' => $employee->email,
                        'request_date' => Carbon::now(),
                    ]);
                    $employeeCount++;
                }
            }
        }
    }

}

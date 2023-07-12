<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Employer;
use App\Models\User;
use App\Models\UserRegistrationRequest;
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
        DB::table('users')
            ->insert([
                [
                    'identifier' => 'ADM_',
                    'employer_id' => 101,
                    'employee_id' => null,
                    'role' => 'Admin',
                    'username' => 'ryan_kathurima@arcadian.resource',
                    'password' => Hash::make('admin@123'),
                    'email_verified_at' => '2005-04-1 12:00:00',
                    'account_status' => 'activated',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'identifier' => 'MNGR_',
                    'employer_id' => 102,
                    'employee_id' => null,
                    'role' => 'Manager',
                    'username' => 'megan_mwago@arcadian.resource',
                    'password' => Hash::make('admin@123'),
                    'email_verified_at' => '2007-12-17 12:00:00',
                    'account_status' => 'activated',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'identifier' => 'EPE_',
                    'employer_id' => null,
                    'employee_id' => 101,
                    'role' => 'Employee',
                    'username' => 'reece_elroy@arcadian.resource',
                    'password' => Hash::make('admin@123'),
                    'email_verified_at' => '2015-05-23 12:00:00',
                    'account_status' => 'activated',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]);
        $registrationRequests = UserRegistrationRequest::whereNotIn('work_email', [
            'ryankinotikathurima@gmail.com',
            'megan.mwago@strathmore.edu',
            'reece.elroy@arcadianbank.com'
        ])->inRandomOrder()->get();

        $totalUsers = 67;
        $managerCount = 0;
        $employeeCount = 0;

        foreach ($registrationRequests as $registrationRequest) {
            if ($managerCount >= 15 && $employeeCount >= ($totalUsers - 15)) {
                break;
            }

            if ($registrationRequest->employer_id && $managerCount < 15) {
                $employer = Employer::find($registrationRequest->employer_id);
                if ($employer) {
                    $this->createUser($employer, $registrationRequest);
                    $managerCount++;
                }
            } elseif ($registrationRequest->employee_id && $employeeCount < ($totalUsers - 15)) {
                $employee = Employee::find($registrationRequest->employee_id);
                if ($employee) {
                    $this->createUser($employee, $registrationRequest);
                    $employeeCount++;
                }
            }

            $registrationRequest->update(['status' => 'approved']);
        }
    }

    private function createUser($userModel, $registrationRequest)
    {
        $identifier = $registrationRequest->employer_id ? 'MNGR_' : 'EPE_';
        $role = $registrationRequest->employer_id ? 'Manager' : 'Employee';

        $user = new User();
        $user->identifier = $identifier;
        $user->employer_id = $registrationRequest->employer_id;
        $user->employee_id = $registrationRequest->employee_id;
        $user->role = $role;
        $user->username = $registrationRequest->employer_id ?
            $userModel->first_name . '.' . $userModel->last_name . '@arcadian.resource' :
            $userModel->first_name . '.' . $userModel->last_name . '@arcadian.resource';

        $user->password = Hash::make('admin@123');
        $user->account_status = 'activated';
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();

        $user->save();
    }
}

<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationRequestApproval;
use App\Models\Employee;
use App\Models\Employer;
use App\Models\UserRegistrationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use function Symfony\Component\Translation\t;

class EmailController extends Controller
{
    //
    public function approved(Request $request)
    {
        $data = $request->all();

        if ($data['user_type'] == 'EPR_') {
            $type = 'Manager';
            $employer_data = Employer::all()->where('email', '=', $request->input('request_mail'))->first();
            $username = strtolower($employer_data->first_name . "_" . $employer_data->last_name . '@arcadian.resource');

            //create for them an account
            $createAccount = new AuthController();
            if ($createAccount->createAccount($employer_data, $type)) {
                $this->updateStatus($data);
                Mail::to($request->input('request_mail'))->send(new RegistrationRequestApproval($employer_data, $type, $username));
            } else {
                return redirect("/admin")->withErrors(['error' => "There has been an error in sending the email"]);
            }
        } elseif ($data['user_type'] == 'EPE_') {
            $type = 'Employee';
            $employee_data = Employee::all()->where('email', '=', $request->input('request_mail'))->first();
            $username = strtolower($employee_data->first_name . "_" . $employee_data->last_name . '@arcadian.resource');

            //create for them an account
            $createAccount = new AuthController();
            if ($createAccount->createAccount($employee_data, $type)) {
                $this->updateStatus($data);
                Mail::to($request->input('request_mail'))->send(new RegistrationRequestApproval($employee_data, $type, $username));
            } else {
                return redirect("/admin")->withErrors(['error' => "There has been an error in sending the email"]);
            }
        }
        return redirect("/admin")->withErrors(['msg' => "email successfully sent"]);
    }

    public function updateStatus($data)
    {
        return UserRegistrationRequest::where('work_email', $data['request_mail'])
            ->update(['status' => $data['status']]);
    }
}

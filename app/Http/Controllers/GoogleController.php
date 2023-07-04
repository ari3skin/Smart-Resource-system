<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Laravel\Socialite\Facades\Socialite;
use mysql_xdevapi\Exception;

class GoogleController extends Controller
{
    //
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $google_employer = Employer::where('google_email', $user->email)->exists();
            $google_employee = Employee::where('google_email', $user->email)->exists();

            if ($google_employer) {
                $employer = Employer::all()->where('google_email', '=', $user->email)->first();
                $finduser = User::where('employer_id', $employer->id)->first();
                if ($finduser) {
                    $finduser->google_id = $user->id;

                    // Download and save the profile picture
//                    $profilePictureUrl = $user->avatar_original;
//                    $filename = 'profile_picture.jpg'; // Change the filename if desired
//                    $picture = Image::make($profilePictureUrl);
//                    Storage::disk('public')->put($filename, $picture->stream());
//
                    // Save the filename to the user's record
//                    $finduser->profile_picture = $filename;

                    $finduser->save();
                    //Auth::login($finduser);
                    return app('App\Http\Controllers\AuthController')->login(Request::create('/admin/', 'POST', [
                        'google_id' => $user->id,
                    ]));
                } else {
                    return redirect()->intended('/auth/registration');
                }

            } elseif ($google_employee) {
                $employee = Employee::all()->where('google_email', '=', $user->email)->first();
                $finduser = User::where('employee_id', $employee->id)->first();
                if ($finduser) {
                    $finduser->google_id = $user->id;
                    $finduser->save();
                    return app('App\Http\Controllers\AuthController')->login(Request::create('/admin/', 'POST', [
                        'google_id' => $user->id,
                    ]));
                } else {
                    return redirect()->intended('/auth/registration');
                }
            } else {
                return redirect()->intended('/auth/registration')->withErrors(['error' => 'User does not exist']);
            }
        } catch (\Exception $exception) {
            return redirect('/auth/google/');
        }
    }
}

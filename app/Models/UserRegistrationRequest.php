<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRegistrationRequest extends Model
{
    use HasFactory;

    protected $table = 'user_registration_requests';
    protected $fillable = [
        'employer_id',
        'employee_id',
        'work_email',
        'request_date',
        'status',
    ];

}

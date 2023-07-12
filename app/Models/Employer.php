<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    protected $table = 'employers';

    public function user()
    {
        return $this->hasOne('App\Models\User', 'employer_id');
    }
}

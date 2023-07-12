<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    public function tasks()
    {
        return $this->hasMany('App\Models\Task', 'project_id');
    }

    public function manager()
    {
        return $this->belongsTo('App\Models\User', 'project_manager');
    }

    public function subManager()
    {
        return $this->belongsTo('App\Models\User', 'sub_project_manager');
    }
}

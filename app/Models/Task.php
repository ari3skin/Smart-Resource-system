<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    public function project()
    {
        return $this->belongsTo('App\Models\Project', 'project_id');
    }

    public function teamManager()
    {
        return $this->belongsTo('App\Models\User', 'task_team_manager');
    }

    public function individualUser()
    {
        return $this->belongsTo('App\Models\User', 'task_individual_user');
    }
}

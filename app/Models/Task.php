<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function taskTeamManager(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'task_team_manager', 'id');
    }

    public function taskIndividualUser(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'task_individual_user', 'id');
    }

    public function taskList(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(TaskList::class, 'task_id');
    }

    public function reports(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Report::class, 'task_id');
    }


    // Get the department of the task via a project
    public function department()
    {
        return $this->project->department;
    }
}

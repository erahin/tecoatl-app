<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    /* -------------------------------------------------------------------------- */
    /*                         Relation report and project                        */
    /* -------------------------------------------------------------------------- */
    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    /* -------------------------------------------------------------------------- */
    /*                          Relation user and project                         */
    /* -------------------------------------------------------------------------- */
    function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

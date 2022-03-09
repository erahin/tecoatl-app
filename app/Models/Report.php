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
    // public function projects()
    // {
    //     return $this->belongsTo(Project::class, 'project_id');
    // }
    /* -------------------------------------------------------------------------- */
    /*                          Relation user and report                          */
    /* -------------------------------------------------------------------------- */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /* -------------------------------------------------------------------------- */
    /*                         Relation studio with report                        */
    /* -------------------------------------------------------------------------- */
    public function studies()
    {
        return $this->belongsTo(Study::class, 'studio_id');
    }
}

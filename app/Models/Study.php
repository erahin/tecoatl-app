<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    use HasFactory;
    /* -------------------------------------------------------------------------- */
    /*                         Relation project and study                         */
    /* -------------------------------------------------------------------------- */
    public function projects_study()
    {
        return $this->belongsToMany(Project::class, 'projects_studies');
    }
    /* -------------------------------------------------------------------------- */
    /*                        Relation reports with studty                        */
    /* -------------------------------------------------------------------------- */
    public function reports()
    {
        return $this->hasMany(Report::class, 'id');
    }
}

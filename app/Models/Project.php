<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    /* -------------------------------------------------------------------------- */
    /*                         Relation project and region                        */
    /* -------------------------------------------------------------------------- */
    public function regions()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
    /* -------------------------------------------------------------------------- */
    /*                         Relation project and studio                        */
    /* -------------------------------------------------------------------------- */
    public function studys()
    {
        return $this->belongsToMany(Study::class, 'projects_studies');
    }
    /* -------------------------------------------------------------------------- */
    /*                          Relation user and project                         */
    /* -------------------------------------------------------------------------- */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

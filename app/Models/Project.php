<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function regions()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function studys()
    {
        return $this->belongsToMany(Study::class, 'projects_studies');
    }
}

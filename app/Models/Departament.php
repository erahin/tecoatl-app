<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departament extends Model
{
    use HasFactory;
    /* -------------------------------------------------------------------------- */
    /*                        Relation departament and user                       */
    /* -------------------------------------------------------------------------- */
    public function users()
    {
        return $this->hasMany(User::class, 'id');
    }
}

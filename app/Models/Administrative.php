<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrative extends Model
{
    use HasFactory;
    /* -------------------------------------------------------------------------- */
    /*                          Relation user and Administrative                  */
    /* -------------------------------------------------------------------------- */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

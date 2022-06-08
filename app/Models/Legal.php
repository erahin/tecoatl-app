<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Legal extends Model
{
    use HasFactory;
    /* -------------------------------------------------------------------------- */
    /*                          Relation user and Legal                  */
    /* -------------------------------------------------------------------------- */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

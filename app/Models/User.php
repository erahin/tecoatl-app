<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'phone'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /* -------------------------------------------------------------------------- */
    /*                        Relation reports and user                           */
    /* -------------------------------------------------------------------------- */
    public function reports()
    {
        return $this->hasMany(Report::class, 'id');
    }
    /* -------------------------------------------------------------------------- */
    /*                        Relation project and user                           */
    /* -------------------------------------------------------------------------- */
    public function projects()
    {
        return $this->hasMany(Project::class, 'id');
    }
    /* -------------------------------------------------------------------------- */
    /*                           Relation user and study                          */
    /* -------------------------------------------------------------------------- */
    public function studies()
    {
        return $this->belongsToMany(Study::class, 'users_studies');
    }
    /* -------------------------------------------------------------------------- */
    /*                         Relation departament and user                      */
    /* -------------------------------------------------------------------------- */
    // public function departaments()
    // {
    //     return $this->belongsTo(Administrative::class, 'departament_id');
    // }
    public function administratives()
    {
        return $this->hasMany(Administrative::class, 'id');
    }
}

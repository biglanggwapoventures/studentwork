<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    const USER_TYPE_ADMIN = 'admin';
    const USER_TYPE_STUDENT = 'student';
    const USER_TYPE_ADVISER = 'adviser';

    const USER_DEFAULT_PASSWORRD = 'usc2018!*';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'middle_initial',
        'birthdate',
        'contact_number',
        'username',
        'password',
        'user_role'
    ];

    protected $appends = ['fullname'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Undocumented function
     *
     * @param string $userRole
     * @return boolean
     */
    public function isRole(string $userRole)
    {
        return $this->user_role === $userRole;
    }

    public function getFullnameAttribute()
    {
        return "{$this->lastname}, {$this->firstname} {$this->middle_initial}.";
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('user_role', $type);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_authors', 'author_id', 'project_id');
    }

    public function handledProjects()
    {
        return $this->hasMany(Project::class, 'adviser_id');
    }
}

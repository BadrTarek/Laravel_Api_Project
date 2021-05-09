<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;



class Admin extends Authenticatable 
{
    use HasFactory;
    protected $table = "admins";
    protected $primaryKey = "id";
    protected $fillable = [
		'id',
		'name',
		'phone',
		'email',
		'email_verified_at',
		'remember_token',
		'updated_at',
		'is_super_admins',
		'type',
		'role',
		'is_active' 
    ];

    protected $hidden = [
        'password'
    ];


    public $timestamps = false;
    public function setUpdatedAt($value)
    {
      return NULL;
    }


    public function setCreatedAt($value)
    {
      return NULL;
    }   
}
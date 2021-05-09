<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotficationModel extends Model
{
    use HasFactory;

    protected $table = 'notify_users';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public function setUpdatedAt($value)
    {
      return NULL;
    }


    public function setCreatedAt($value)
    {
      return NULL;
    }


    protected $fillable = [
		'id',
		'notifications_id',
		'is_seen',
		'created_at',
		'users_id',
		'drivers_id'
    ];

   /*One To Many*/
	// from user
	//return $this->hasMany('\App\Posts','user_id');

	// from posts
	//return $this->belongsTo('\App\Posts','user_id');
/************/

	public function user_notify(){
		return $this->belongsTo('\App\Models\NotficationModel','notifications_id');
	}



 
}

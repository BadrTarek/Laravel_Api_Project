<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewModel extends Model
{
     use HasFactory;

    protected $table = "reviews";
    protected $primaryKey = "id";
    protected $fillable = [
		'id',
		'rate',
		'created_at,',
		'type',
		'drivers_id',
		'users_id',
		'orders_id'
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

    /*public function order_user(){
    	//    	return $this->hasMany('\App\Models\MainCategories','main_categories_id');
    	return $this->hasOne("\App\Models\User","users_id");
    }
    public function order_driver(){
    	//    	return $this->hasMany('\App\Models\MainCategories','main_categories_id');
    	return $this->hasOne("\App\Models\Driver","drivers_id");
    }*/
}

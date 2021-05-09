<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;



class Driver extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $table = "drivers";
    protected $primaryKey = "id";
    protected $fillable = [
        'image' , 
		'name' , 
		'country_code' , 
		'phone' , 
		'car_name' , 
		'car_model' , 
		'car_license_number' , 
		'driving_license_image' , 
		'car_license_image' , 
		'id_image' , 
		'car_photo' , 
		'is_active' , 
		'is_verified' , 
		'api_token' , 
		'language' , 
		'created_at' , 
		'trucks_types_id' , 
		'locations_id' , 
		'companies_id' , 
		'fees' , 
		'email' , 
		'firebase_token' 
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


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function driver_location(){
    	return $this->belongsTo('\App\Models\LocationModel','locations_id');;
    }
    
}

 /*public function selectProductsByMainCategory(){
    	return $this->hasMany('\App\Models\MainCategories','main_categories_id');
    }
    public function selectProductsByBrand(){
    	return $this->hasMany('\App\Brands','products_id');
    }
        return print_r($products->where('main_categories_id','=',2)->with("selectProductsByMainCategory")->first());
    */

/* One To One */
	// from user
	//return $this->hasOne('\App\Profile','user_id');

	// from profile
	//return $this->belongsTo('\App\User','user_id');
/*************/

/*One To Many*/
	// from user
	//return $this->hasMany('\App\Posts','user_id');

	// from posts
	//return $this->belongsTo('\App\Posts','user_id');
/************/

/*Many To Many*/
	// from user 							   	  name of pivote table
	// return $this->belongsToMany('\App\Product'   ,'products_user',  'user_id' , 'product_id');

	// from product 							name of pivote table
	// return $this->belongsToMany('\App\User'   ,'products_user',  'product_id' , 'user_id');
/**************/
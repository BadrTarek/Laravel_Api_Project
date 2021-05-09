<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model{
    use HasFactory;

    protected $table = "orders";
    protected $primaryKey = "id";
    protected $fillable = [
		'locations_pickup_id',
		'locations_destination_id',
		'image',
		'goods_types_id',
		'descriptions',
		'i_am_recipient',
		'recipient_name',
		'country_code',
		'phone',
		'load_weight',
		'status',
		'created_at',
		'users_id',
		'trucks_types_id',
		'code',
		'drivers_id',
		'companies_id'
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

    public function order_user(){
    	return $this->belongsTo("\App\Models\User","users_id");
    } 

    public function order_bill(){
        return $this->hasOne("\App\Models\BillModel","orders_id");
    }

    public function order_driver(){
    	return $this->belongsTo("\App\Models\Driver","drivers_id");
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceModel extends Model
{
    use HasFactory;

    protected $table = "price_list";
    protected $primaryKey = "id";
    protected $fillable = [
		'id',
		'category',
		'price',
		'created_at',
		'trucks_types_id'
		
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

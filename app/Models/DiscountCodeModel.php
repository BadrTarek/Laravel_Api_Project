<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCodeModel extends Model
{
    use HasFactory;

    protected $table = "discount_code";
    protected $primaryKey = "id";
    protected $fillable = [
		'id',
		'code',
		'discount',
		'count',
		'end_date',
		'is_active',
		'created_at'      
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

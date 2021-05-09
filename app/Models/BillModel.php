<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillModel extends Model
{
    use HasFactory;

	protected $table = "bills";
    protected $primaryKey = "id";
    protected $fillable = [
		'id',
		'orders_id',
		'cost',
		'discount',
		'payment_type',
		'status',
		'created_at',
		'fees'
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financials extends Model
{
    use HasFactory;

    protected $table = "financials";
    protected $primaryKey = "id";
    protected $fillable = [
		'id',
		'total_benefit',
		'paid_money',
		'created_at',
		'updated_at',
		'drivers_id'
		
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


trait ApiOrderResponseTrait{
	public function apiResponse($status ,$order=null,  $message=null){
		$array = [
			'status' => $status,
			'order' => $order,
			'message' => $message
		];
		return $array;
	}
	public function apiResponseNoObj($status , $message=null){
		$array = [
			'status' => $status,
			'message' => $message
		];
		return $array;
	}
	public function apiResponseNoMessage($status ,$order=null){
		$array = [
			'status' => $status,
			'order' => $order,
		];
		return $array;
	}
	public function apiResponseOnlyMessage($message){
		$array = [
			'message' => $message
		];
		return $array;
	}
	
}
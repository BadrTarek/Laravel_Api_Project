<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


trait ApiResponseTrait{
	public function apiResponse($status ,$account=null,  $message=null){
		$array = [
			'status' => $status,
			'account' => $account,
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
	public function apiResponseNoMessage($status ,$account=null){
		$array = [
			'status' => $status,
			'account' => $account,
		];
		return $array;
	}
	public function apiResponseOnlyMessage($message){
		$array = [
			'message' => $message
		];
		return $array;
	}

	public function apiResponseApiToken($status , $apiToken , $message=null){
		$array = [
			'status' => $status,
			'apiToken' => $apiToken,
			'message' => $message
		];
		return $array;
	}
	
}
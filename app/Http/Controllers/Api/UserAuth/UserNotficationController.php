<?php

namespace App\Http\Controllers\Api\UserAuth;

use App\Http\Resources\UserObjectResource;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserNotficationModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class UserNotficationController extends Controller
{
	use \App\Http\Controllers\Api\ApiResponseTrait;

	public function unseenNotifications(){
		$notifications = UserNotficationModel::select( DB::raw('COUNT(id) as number_of_notifications') )->where('is_seen','=',0)->where("users_id","=",auth_id())->get();
		$arr = [
			"status" => 200,
			$notifications
		];
		return response($arr);
	}

	public function notifications(){
		$notifications = UserNotficationModel::select("*")->with('user_notify')->where("users_id",'=',auth_id())->where('is_seen','=',0)->get();
		$allNotifications = $notifications;
		foreach ($notifications as $key ) {
			$key->is_seen = 1;
			$key->save();
		}
		$arr = [
			"status" => 200,
			"notifications" => $allNotifications
		];
		return response($arr);
	}

}

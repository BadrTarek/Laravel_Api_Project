<?php

namespace App\Http\Controllers\Api\Contacts;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserObjectResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class ContactsController extends Controller
{
	use \App\Http\Controllers\Api\ApiResponseTrait;


    public function contact(Request $req){
    	$validation = Validator::make($req->all(),[
	        'name' =>  (!isAuth())?'required|string':'' ,
	        'phone' => (!isAuth())?'required|string|alpha_num|min:6':'' ,
	        'language' => (!isAuth())?'required|string|in:ar,en|min:2':'' ,
	        'message'=>'required|string',
	        'contacts_types_id' => 'required|exists:contacts_types,id'
    	]); 
    	if($validation->fails())
    	{
    		return $this->apiResponseNoObj(400,$validation->errors()); 
    	}else{
    		if(!isAuth())
    		{	
				DB::table('contacts')->insert([
					'contacts_types_id' => $req->contacts_types_id,
					'message' => "- Name: ".$req->name."\n- Phone: ".$req->phone."\n Message:".$req->message,
					'code' =>  rand(10000,99999),
					'created_at' => new \DateTime()
				]);
    		}else{
				DB::table('contacts')->insert([
					auth_type() => auth_id() ,
					'contacts_types_id' => $req->contacts_types_id,
					'message' => $req->message,
					'code' =>  rand(10000,99999),
					'created_at' => new \DateTime()
				]);
    		}
    		return $this->apiResponseNoObj(200,'sent successfully');
    	}

    }


    public function getContactsTypes(Request $req){
    	$contactTypes = DB::table("contacts_types")->get();
    	return $this->apiResponseNoMessage(200,$contactTypes);
    }


}

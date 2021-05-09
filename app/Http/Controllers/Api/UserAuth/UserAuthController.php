<?php

namespace App\Http\Controllers\Api\UserAuth;

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

class UserAuthController extends Controller
{
	use \App\Http\Controllers\Api\ApiResponseTrait;

    public function register(Request $req){
    	$user = new User;

        /*Validation Of request data*/
    	$validation = Validator::make($req->all(),[
	        'name' => 'required|string',
	        'password' => 'required|string|min:5',
	        'language' => 'required|string|in:ar,en|min:2',
	        'country_code' => 'required|string',
	        'phone' => 'required|string|alpha_num|min:6',
	        'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
	        'email' => 'string|email',
    	]); 
    	if($validation->fails())
    	{
    		return $this->apiResponseNoObj(400,$validation->errors());
    	} /*Check if this phone exist or not*/
    	else if($user->where("phone","=",strval($req['phone']))->get()->count() >0 )
    	{
    		return $this->apiResponseNoObj(407,"This phone registered before");
    	}


        /*Save Data in DB*/
    	$user->name = $req["name"];
    	$user->password = Hash::make($req->password);
    	$user->language = $req["language"];
    	$user->country_code = $req["country_code"];
    	$user->phone = $req["phone"];
    	$user->image = ($req->hasFile("image"))?(upload($req->file('image'),"UserUploads")):"";
    	$user->email = $req["email"]; 
        $user->api_token =   null;//Str::random(64);
    	$user->created_at = new \DateTime();
    	$user->save();
        $code = rand(10000,99999);
        $session = DB::table("sessions")->insert([
            "code" => $code,
            "created_at" => new \DateTime(),
            'users_id' => $user->id
        ]);

        /*Send Code To verify account */
        $codeMessage = "Your code : ".$code."\nCode Time will expire after 1 Hour";
        sendSMS($req->phone , "Ship" , $codeMessage);

        //$apiToken = auth('user-api')->attempt( array('phone' => $req['phone'], 'password' => $req['password']));

        /*Return Data*/
    	$account = [
    		"country_code"=>$req["country_code"],
    		"phone" => $req["phone"],
    		"type" => "user",
            "user" => new UserObjectResource($user)
    	];
		return $this->apiResponse(200,$account,"successfully registered");
    }


    public function login(Request $req)
    {
    	$user = new User;
        /*Validation Of request data*/
    	$validation = Validator::make($req->all(),[
	        'password' => 'required|string|min:5',
	        'language' => 'required|string|in:ar,en|min:2',
	        'phone' => 'required|string|alpha_num|min:6',
    	]); 
    	if($validation->fails())
    	{
    		return $this->apiResponseNoObj(400,$validation->errors());
    	}/*check auth*/
        else if($api_token = auth('user-api')->attempt( array('phone' => $req['phone'], 'password' => $req['password']) ))
        {
            if(auth('user-api')->user()->is_verified==0)
            {
                auth('user-api')->logout();
                return $this->apiResponseNoObj(410 , "Phone not verified");
            }else{            
        	   /*login successfully and return response data*/
               $loggedinUser = User::find(auth('user-api')->user()->id);
               $loggedinUser->api_token = $api_token;
               $loggedinUser->save();
                $account = [
                    "apiToken" => $api_token,
                    "country_code"=>$req["country_code"],
                    "phone" => $req["phone"],
                    "type" => "user",
                    "user" => new UserObjectResource(auth("user-api")->user())
                ];
        		return $this->apiResponse(200,$account, "login successfully" );
            }
        	
        }/*check if phone number exist*/
        else if($user->where("phone","=",$req["phone"])->get()->count() > 0 ){
                return $this->apiResponseNoObj(412,"password is wrong" );
        }
        else{
            return $this->apiResponseNoObj(411,"this phone is not registered" );
        }
    }

    
    public function logout(){
        $user = User::find(auth('user-api')->user()->id);
        $user->api_token= null ;
        $user->save();
    	auth('user-api')->logout();
        return $this->apiResponseOnlyMessage("Successfully logged out");
    }

    public function verificationCode(Request $req){
        /*Validation Of request data*/
        $validation = Validator::make($req->all(),[
            "phone" => 'required|string|alpha_num|min:6',
            "code" => "required|string|alpha_num"
        ]);
        $user = new User;
        $selectedUser = $user->where("phone","=", $req->phone)->get()->first();
        $codeData = DB::table('sessions')->where("is_verified","=",0)->where("code","=",$req->code)->where("users_id","=",$selectedUser->id)->get()->first();
        if($validation->fails())
        {
            return $this->apiResponseNoObj(400,$validation->errors());
        }/*check user exist*/
        else if($selectedUser->count()<0)
        {
            return $this->apiResponseNoObj(409,"Phone Doesn't exist");
        }/*check if code exist*/
        elseif($codeData != null){
            
            $codeTime = Carbon::parse( $codeData->created_at ) ;
            /*check if time expired or not*/
            if( $codeTime->diffInMinutes(now()) >= 60 )
            {
                return $this->apiResponseNoObj(409,"Time Exprired");
            }else{
                /*Success*/

                /*update session table*/
                $codeData->is_verified = 1;
                $codeData->save();

                /*update user table*/
                $selectedUser->is_verified = 1;
                $apiToken = auth('user-api')->fromUser(  $selectedUser );
                $selectedUser->api_token = $apiToken;
                $selectedUser->save();
                return $this->apiResponseApiToken(200,$apiToken,"successfully done");
            }
        }else{
            return $this->apiResponseNoObj(409,"code does't exist");
        }

    }
    
    /*public function forgetPassword(Request $req)
    {
        $validation = Validator::make($req->all(),[
            'phone' => 'required|string|alpha_num|min:6'
        ]);
        $user = User::where("phone","=",$req->phone)->get()->first();
        if($validation->fails())
        {
            return $this->apiResponseNoObj(400,$validation->errors());
        }elseif ($user->count()>0) {
            $code = rand(10000,99999);
            $session = DB::table("sessions")->insert([
                "code" => $code,
                "created_at" => new \DateTime(),
                'tmpToken' => null
            ]);

            $codeMessage = "Your code : ".$code."\nCode Time will expire after 1 Hour";
            sendSMS($req->phone , "Ship" , $codeMessage);


        }else{
            return $this->apiResponseNoObj(412,"this phone not registered");
        }

    }*/


    /*
    public function changePassword(Request $req)
    {
        $validation = Validator::make($req->all(),[
            'name' => 'required|string',
            'country_code' => 'required|string',
            'phone' => 'required|string|alpha_num|min:6',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if($validation->fails())
        {
            return $this->apiResponseNoObj(400,$validation->errors());
        }elseif ($user->count()>0) {
            
        }else{

        }

    }*/

    public function updatePassword(Request $req)
    {
        $validation = Validator::make($req->all(),[
            'oldPassword' => 'required|string|min:5',
            'newPassword' => 'required|string|min:5',
        ]);
        $user = User::find(auth('user-api')->user()->id);
        if($validation->fails())
        {
            return $this->apiResponseNoObj(400,$validation->errors());
        }elseif ($user->count()>0) {
            if (Hash::check($req->oldPassword , $user->password)) {
                $user->password = Hash::make($req->newPassword);
                $user->save();
                return $this->apiResponseNoObj(200,"password updated successfully");

            }else{
                return $this->apiResponseNoObj(414,"the old password is incorrect ");
            }
        }else{
            return $this->apiResponseNoObj(499 , "User not found ");
        }
    }
    
   /* public function updateUserProfile(Request $req)
    {
        $validation = Validator::make($req->all(),[
            'name' => 'string',
            'country_code' => 'string',
            'phone' => 'string|alpha_num|min:6',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $user = User::find(auth('user-api')->user()->id);
        if($validation->fails())
        {
            return $this->apiResponseNoObj(400,$validation->errors());
        }else{
            $user->name = ($req->name!=null)?$req->name:$user->name ;
            $user->image = ($req->hasFile("image"))?(upload($req->file('image'),"UserUploads")):$user->image;
            $user->save();

            if($req->phone != null &&$req->phone != $user->phone){
                $checkPhone = User::where('phone','=',$req->phone)->get()->first();
                if($checkPhone->count()>0)
                {
                    return $this->apiResponseNoObj(415,'this phone registered before');
                }else{
                    $code = rand(10000,99999);
                    $session = DB::table("sessions")->insert([
                        "code" => $code,
                        "created_at" => new \DateTime(),
                        'tmp_phone' => $req->phone,
                        'users_id' => auth('user-api')->user()->id
                    ]);
                    $codeMessage = "Your code : ".$code."\nCode Time will expire after 1 Hour";
                    sendSMS("01004323202" , "Ship" , $codeMessage);
                    //endSMS($req->phone , "Ship" , $codeMessage);
                }
            }

            $account = [
                "apiToken" => $user->api_token,
                "country_code"=>$user->country_code,
                "phone" => $user->phone,
                "type" => "user",
                "user" => new UserObjectResource(auth("user-api")->user())
            ];
            return $this->apiResponse(200,$account, "updated successfully" );
        }

    }


    public function verificationCodeToUpdatePhone(Request $req){
        //Validation Of request data
        $validation = Validator::make($req->all(),[
            "code" => "required|string|alpha_num"
        ]);
        $codeData = DB::table('sessions')->where("code","=",$req->code)->where("is_verified","=",0)->where("users_id","=",auth('user-api')->user()->id)->get()->latest();
        if($validation->fails())
        {
            return $this->apiResponseNoObj(400,$validation->errors());
        }//check if code exist
        elseif($codeData != null){
            
            $codeTime = Carbon::parse( $codeData->created_at ) ;
            //check if time expired or not
            if( $codeTime->diffInMinutes(now()) >= 60 )
            {
                return $this->apiResponseNoObj(409,"Time Exprired");
            }else{
                //Success

                //update session table
                $codeData->is_verified = 1;
                $codeData->save();

                //update user table
                $user = User::find(auth('user-api')->user()->id);
                $user->phone = $codeData->tmp_phone;
                $user->save();

            $account = [
                "apiToken" => $user->api_token,
                "country_code"=>$req["country_code"],
                "phone" => $user->phone,
                "type" => "user",
                "user" => new UserObjectResource(auth("user-api")->user())
            ];
            return $this->apiResponse(200,$account, "updated successfully" );            
        }
        }else{
            return $this->apiResponseNoObj(409,"code does't exist");
        }

    }*/


    
    public function resendCode(Request $req)
    {
        $validation = Validator::make($req->all(),[
            'phone' => 'required|string|alpha_num|min:6',
            'language' => 'required|string|in:ar,en|min:2'
       ]);

        if($validation->fails())
        {
            return $this->apiResponseNoObj(400,$validation->errors());
        }
        $user  = User::where("phone","=",$req->phone)->get()->first();
        /*Check if user exist*/
        if ($user->count()>0) {
            $lastCode = DB::table('sessions')->where('users_id','=',$user->id)->latest()->get()->first();
            // check if last code exist
            if($lastCode != null )
            { 
                $codeTime = Carbon::parse( $lastCode->created_at ) ;
                //check if last code sent before 2 min or not
                if( $codeTime->diffInMinutes(now()) < 2 )
                {
                    return $this->apiResponseNoObj(416,"failed to send last code less than 2 minutes ago");
                }
                // generate code
                $code = rand(10000,99999);

                //store it in db
                $session = DB::table("sessions")->insert([
                    "code" => $code,
                    "created_at" => new \DateTime(),
                    'users_id' => $user->id
                ]);

                $codeMessage = "Your code : ".$code."\nCode Time will expire after 1 Hour ";
                
                sendSMS($req->phone , "Ship" , $codeMessage);

                return $this->apiResponseNoObj(200,"activation code sent");

            }else{
                return $this->apiResponseNoObj(404 , "undefind last code");
            }
        }else{
           return $this->apiResponseNoObj(404 , "This phone not registered");    
        }
    }



    



   


}

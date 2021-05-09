<?php

namespace App\Http\Controllers\Api\DriverAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\Validator;
use Str;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\DriverObjectResource;
use App\Models\Financials;
use App\Models\LocationModel;



class DriverAuthController extends Controller
{
	use \App\Http\Controllers\Api\ApiResponseTrait;

    public function register(Request $req)
    {
    	$driver = new Driver;
        /*Validation Of request data*/
    	$validation = Validator::make($req->all(),[
	        'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
	        'name' => 'required|string',
	        'country_code' => 'required|string',
	        'phone' => 'required|string|alpha_num|min:6',
	        'trucks_types_id' => 'required|numeric|exists:trucks_types,id', 
	        'password' => 'required|string|min:5',
	        'car_name' => 'required|string',
	        'car_model' => 'required|string',
	        'car_license_number' => 'required|string|numeric',
	        'driving_license_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
	        'car_license_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
	        'id_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
	        'car_photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
	        'language' => 'required|string|in:ar,en|min:2',
	        'email' => 'string|email'
    	]); 
    	if($validation->fails())
    	{
    		return $this->apiResponseNoObj(400,$validation->errors());
    	}/*Check if this phone exist or not*/
    	if($driver->where("phone","=",strval($req['phone']))->get()->count() >0 )
    	{
    		return $this->apiResponseNoObj(408,"This phone registered before");
    	}

        /* Insert To Database */
    	$driver->name = $req["name"];
    	$driver->password = Hash::make($req->password);
    	$driver->language = $req["language"];
    	$driver->country_code = $req["country_code"];
    	$driver->phone = $req["phone"];
        $driver->image = ($req->hasFile("image"))?(upload($req->file('image'),"DriverUploads/DriverImages")):"";
    	$driver->email = $req["email"]; 
    	$driver->api_token =   Str::random(64);
    	$driver->trucks_types_id =  $req["trucks_types_id"];
    	$driver->car_name =  $req["car_name"];
    	$driver->car_model =  $req["car_model"];
    	$driver->car_license_number =  $req["car_license_number"];
        $driver->driving_license_image = upload($req->file('driving_license_image'),"DriverUploads/DrivingLicenseImages" );
        $driver->car_license_image = upload($req->file('car_license_image'),"DriverUploads/CarLicenseImages" );
        $driver->id_image =  upload($req->file('id_image'),"DriverUploads/IdentificationImages" );
        $driver->car_photo =  upload($req->file('car_photo'),"DriverUploads/CarImages" );
    	$driver->created_at = new \DateTime();
    	$driver->save();

        /*Login*/
        $apiToken = auth('driver-api')->attempt( array('phone' => $req['phone'], 'password' => $req['password']) );

        $trucks_types = DB::table("trucks_types")->find($req->trucks_types_id);

        /*Return Values*/
    	$account = [
    		"apiToken" => $apiToken,
    		"country_code"=>$req["country_code"],
    		"phone" => $req["phone"],
    		"type" => "driver",
    		"driver"=> new DriverObjectResource( [ $driver , $trucks_types ] ) 
    	];
		return $this->apiResponse(200,$account,"successfully registered");
    }
    public function login(Request $req ){

        $driver = new Driver;
        /*Validation Of request data*/
        $validation = Validator::make($req->all(),[
            'phone' => 'required|string|alpha_num|min:6',
            'password' => 'required|string|min:5'
        ]);
        if($validation->fails())
        {
            return $this->apiResponseNoObj(400,$validation->errors());
        }
        else if($api_token = auth('driver-api')->attempt( array('phone' => $req['phone'], 'password' => $req['password']) ))
        {

            /*login successfully and return response data*/
            $trucks_types = DB::table("trucks_types")->find(auth("driver-api")->user()->id);
            $account = [
                "apiToken" => $api_token,
                "country_code"=>$req["country_code"],
                "phone" => $req["phone"],
                "type" => "driver",
                "driver" =>  new DriverObjectResource( [ auth('driver-api')->user() , $trucks_types ] ) 
            ];
            return $this->apiResponse(200,$account, "login successfully" );
        }/*check if phone number exist*/
        else if($driver->where("phone","=",$req["phone"])->get()->count() > 0 ) {
                return $this->apiResponseNoObj(412,"password is wrong" );
        }else{
            return $this->apiResponseNoObj(411,"this phone is not registered" );
        }

    }

    public function logout(){
        auth('driver-api')->logout();
        return $this->apiResponseOnlyMessage("Successfully logged out");
    }

    public function myProfit(){
        $financials = new Financials;
        $profit = $financials->where('drivers_id','=',auth("driver-api")->user()->id)->get();
        return $this->apiResponseNoMessage(200,$profit);
    }

    public function setDriverLocation (Request $req){
        $validation = Validator::make($req->all(),[
            'latitude'=>'required',
            'longitude' => 'required',
            'address' => 'required|string'
        ]);
        if($validation->fails())
        {
            return $this->apiResponseNoObj(400,$validation->errors());
        }
        $locationModel = new LocationModel;
        $locationModel->latitude = $req->latitude;
        $locationModel->longitude = $req->longitude;
        $locationModel->address = $req->address;
        $locationModel->created_at= new \DateTime();
        $locationModel->save();
        return response(['status'=>200]);
    }
    public function setDriverLocation (){
        $validation = Validator::make($req->all(),[
            'latitude'=>'required',
            'longitude' => 'required',
            'address' => 'required|string'
        ]);
        if($validation->fails())
        {
            return $this->apiResponseNoObj(400,$validation->errors());
        }
        $locationModel = new LocationModel;
        $locationModel->latitude = $req->latitude;
        $locationModel->longitude = $req->longitude;
        $locationModel->address = $req->address;
        $locationModel->created_at= new \DateTime();
        $locationModel->save();
        $driver = Driver::find(auth_id());
        $dirver->locations_id =  $locationModel->id;
        $driver->save();
        return response(['status'=>200]);
    }
}

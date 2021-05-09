<?php

namespace App\Http\Controllers\Admin\Drivers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class DriversController extends Controller
{
    public function index(){
    	$drivers = Driver::select("*")->with("driver_location")->paginate(10);
      	return view("drivers.drivers",['drivers'=>$drivers,"title"=>"Drivers"]);
    }	
    public function addDriverPage(){
        $trucks_types = DB::table('trucks_types')->get();
        return view('drivers.addDriver',compact('trucks_types'));
    }
    public function addDriver(Request $req){
        $this->validate($req, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'name' => 'required|string',
            'country_code' => 'required|string',
            'phone' => 'required|string|alpha_num|min:6|unique:drivers,phone',
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
            'is_active' => 'required|boolean',
            'email' => 'string|email|unique:drivers,email'
        ]);
        
        $driver = new Driver;
        $driver->name = $req->name;
        $driver->country_code = $req->country_code;
        $driver->phone = $req->phone;
        $driver->trucks_types_id = $req->trucks_types_id;
        $driver->password = Hash::make($req->password);
        $driver->car_name = $req->car_name;
        $driver->car_model = $req->car_model;
        $driver->car_license_number = $req->car_license_number;
        $driver->language = $req->language;
        $driver->is_active = $req->is_active;
        $driver->email = $req->email;
        $driver->fees = $req->fees;
        $driver->image = ($req->hasFile("image"))?(upload($req->file('image'),"DriverUploads/DriverImages")):"";
        $driver->driving_license_image = upload($req->file('driving_license_image'),"DriverUploads/DrivingLicenseImages" );
        $driver->car_license_image = upload($req->file('car_license_image'),"DriverUploads/CarLicenseImages" );
        $driver->id_image =  upload($req->file('id_image'),"DriverUploads/IdentificationImages" );
        $driver->car_photo =  upload($req->file('car_photo'),"DriverUploads/CarImages" );
        $driver->created_at =  new \DateTime();
        $driver->save();

        return back()->with("action","Added Successfully");
    }

    public function editDriver($id){
        $trucks_types = DB::table('trucks_types')->get();
        $driver = Driver::find($id);
        if($driver == null){
            return view("pages.undefind",["title"=>"Error","message"=>"Undefind Driver"]);
        }
        return view('drivers.editDriver',['trucks_types' => $trucks_types , 'driver' => $driver]);
    }
    public function updateDriver(Request $req,$id){
        $this->validate($req, [
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'name' => 'required|string',
            'country_code' => 'required|string',
            'phone' => 'required|string|alpha_num|min:6|unique:drivers,phone,'.$id.',id',
            'trucks_types_id' => 'required|numeric|exists:trucks_types,id', 
            //'password' => 'required|string|min:5',
            'car_name' => 'required|string',
            'car_model' => 'required|string',
            'car_license_number' => 'required|string|numeric',
            'driving_license_image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'car_license_image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'id_image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'car_photo' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'language' => 'required|string|in:ar,en|min:2',
            'is_active' => 'required|boolean',
            'email' => 'string|email|unique:drivers,email,'.$id.',id'
        ]);
        
        $driver = Driver::find($id);
        $driver->name = $req->name;
        $driver->country_code = $req->country_code;
        $driver->phone = $req->phone;
        $driver->trucks_types_id = $req->trucks_types_id;
        $driver->password = Hash::make($req->password);
        $driver->car_name = $req->car_name;
        $driver->car_model = $req->car_model;
        $driver->car_license_number = $req->car_license_number;
        $driver->language = $req->language;
        $driver->is_active = $req->is_active;
        $driver->email = $req->email;
        $driver->fees = $req->fees;
        $driver->image = ($req->hasFile("image"))?(upload($req->file('image'),"DriverUploads/DriverImages")):$driver->image;

        $driver->driving_license_image = ($req->hasFile("driving_license_image"))?(upload($req->file('driving_license_image'),"DriverUploads/DrivingLicenseImages")):$driver->driving_license_image ;

        $driver->car_license_image = ($req->hasFile("car_license_image"))?(upload($req->file('car_license_image'),"DriverUploads/CarLicenseImages")):$driver->car_license_image ;

        $driver->id_image = ($req->hasFile("id_image"))?(upload($req->file('id_image'),"DriverUploads/IdentificationImages")):$driver->id_image ;

        $driver->car_photo = ($req->hasFile("car_photo"))?(upload($req->file('car_photo'),"DriverUploads/CarImages")):$driver->car_photo ;

        $driver->created_at =  new \DateTime();
        $driver->save();

        return back()->with("action","Updated Successfully");
    }

    public function search(Request $req,$name=null)
    {
        if($name==null)
            $name = $req['driverName'];
        if($req->ajax())
        {
            if($name != null){

                $drivers = Driver::select("id","name")->where('name','like',"%".$name."%")->get();
                return response()->json(($drivers->count()>0)?$drivers:null );
            }else{
                return response()->json(null);
            }
        }else{
            if($name != null){

                $drivers = Driver::select("*")->with("driver_location")->where('name','like',"%".$name."%")->paginate(10);
                return view("drivers.drivers",[
                    "title" => "Search Results",
                    "drivers" => $drivers
                ]);
            }else{
                return view("pages.undefind",[
                    "title" => "Undefind",
                    "message"=>"Undefind driver"
                ]);
            }
        }

    }

    public function activedDrivers()
    {
        $drivers = Driver::select("*")->where("drivers.is_active","=",1)->with("driver_location")->paginate(10);
        return view("drivers.drivers",['drivers'=>$drivers,"title"=>"Actived Drivers"]);
    }
    public function inActivedDrivers()
    {
        $drivers = Driver::select("*")->where("drivers.is_active","=",0)->with("driver_location")->paginate(10);
        return view("drivers.drivers",['drivers'=>$drivers,"title"=>"Inactived Drivers"]);
    }
}

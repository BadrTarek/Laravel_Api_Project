<?php

namespace App\Http\Controllers\Admin\TruckTypes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TruckTypesController extends Controller
{
    public function index(){
    	$truckTypes = DB::table("trucks_types")->select("*")->paginate(10);
    	return view("truckTypes.truckTypes",["title"=>"Truck Types","truckTypes"=>$truckTypes]);
    }

    public function insert(Request $req){
    	 $this->validate($req, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'name' => 'required|string',
            'descriptions_en' => 'required|string',
            'max_weight' => "required|numeric",            
            'area' => "required|numeric",            
            'is_active' => 'required|boolean'
        ]);

    	DB::table("trucks_types")->insert([
    		"image" => upload($req->file('image'),"TruckTypesImages" ),
    		"name_en" => $req->name,
    		"descriptions_en" => $req->descriptions_en,
    		"max_weight" => $req->max_weight,
    		"area" => $req->area,
    		"is_active" => $req->is_active
    	]);

    	return back()->with("action","Added Succesfully");

    }


    public function search(Request $req,$name=null)
    {
        if($name==null)
            $name = $req['truckType'];
        if($req->ajax())
        {
            if($name != null){
            	$truckTypes = DB::table("trucks_types")->select("id","name_en")->where("name_en","like","%".$name."%")->get();

                return response()->json(($truckTypes->count()>0)?$truckTypes:null );
            }else{
                return response()->json(null);
            }
        }else{
            if($name != null){

            	$truckTypes = DB::table("trucks_types")->select("*")->where("name_en","like","%".$name."%")->paginate(10);

                if($truckTypes->count()<=0)
                {
                    return view("pages.undefind",[
                        "title" => "Undefind",
                        "message"=>"undefind Truck Types"
                    ]);
                }
            	return view("truckTypes.truckTypes",["title"=>"Truck Types","truckTypes"=>$truckTypes]);
            }else{
                return view("pages.undefind",[
                    "title" => "Undefind",
                    "message"=>"Undefind Truck Types"
                ]);
            }
        }

    }

    public function edit($id)
    {	    	
    	$truckType = DB::table("trucks_types")->find($id);
   		if($truckType == null)
   		{	
   			return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"undefind Truck Types"
            ]);
   		}
		return view("truckTypes.editTruckType",compact("truckType"));
    }

    public function update(Request $req,  $id)
    {	    	

		$this->validate($req, [
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'name' => 'required|string',
            'descriptions_en' => 'required|string',
            'max_weight' => "required|numeric",            
            'area' => "required|numeric",            
            'is_active' => 'required|boolean'
        ]);

    	$truckType = DB::table("trucks_types")->find($id);
    	if($truckType == null)
   		{	
   			return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"undefind Truck Types"
            ]);
   		}
    	DB::table("trucks_types")->where("id","=",$id)->update([
    		"image" => ($req->hasFile("image"))?(upload($req->file('image'),"TruckTypesImages")):$truckType->image,
    		"name_en" => $req->name,
    		"descriptions_en" => $req->descriptions_en,
    		"max_weight" => $req->max_weight,
    		"area" => $req->area,
    		"is_active" => $req->is_active
    	]);

    	return back()->with("action","Updated Succesfully");


    }

}

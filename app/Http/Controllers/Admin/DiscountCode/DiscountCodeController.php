<?php

namespace App\Http\Controllers\Admin\DiscountCode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PriceModel;
use Illuminate\Support\Facades\DB;

class DiscountCodeController extends Controller
{
    public function discountCodes(){
    	$codes = DB::table("discount_code")->paginate(10);
    	return view("discountCodes.discountCodes",["codes"=>$codes,"title"=>"Discount Codes"]);
    }

    public function addDiscountCode(Request $req){
    	$this->validate($req,[
    		"code" => "required|numeric|digits:5",
    		"count" => "required|numeric",
    		"discount" => "required|numeric",
    		"end_date"=>"required|date|after:".strval(now()),
    		"is_active" => "required|boolean",
    	]);

    	DB::table("discount_code")->insert([
    		"code" => $req->code,
    		"count" => $req->count,
    		"discount" =>$req->discount,
    		"end_date"=>$req->end_date,
    		"is_active" => $req->is_active,
    		"created_at" => new \DateTime()
    	]);

    	return back()->with("action","Added Successfully");
    }

    public function delete($id){
    	$code = DB::table("discount_code")->find($id);
    	if($code==null){
    		return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"undefind Discount Code"
            ]);
    	}
    	DB::table("discount_code")->where("id","=",$id)->delete();
    	return back()->with("action","Deleted Successfully");
    }

    public function activateDiscountCode($id){
		$code = DB::table("discount_code")->find($id);
    	if($code==null){
    		return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"undefind Discount Code"
            ]);
    	}
    	DB::table("discount_code")->where("id","=",$id)->update([
    		'is_active' => 1
    	]);
		return back()->with("action","Code Actived Successfully");

    }
    public function deactivateDiscountCode($id){
		$code = DB::table("discount_code")->find($id);
    	if($code==null){
    		return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"undefind Discount Code"
            ]);
    	}
    	DB::table("discount_code")->where("id","=",$id)->update([
    		'is_active' => 0
    	]);
		return back()->with("action","Code Inactived Successfully");

    }

    public function searchForDiscountCodes(Request $req,$code=null)
    {
        if($code==null)
            $code = $req['discountCode'];
        if($req->ajax())
        {
            if($code != null){

                $codes = DB::table("discount_code")->select("id","code")->where('code','like',"%".$code."%")->get();
                return response()->json(($codes->count()>0)?$codes:null );
            }else{
                return response()->json(null);
            }
        }else{
            if($code != null){
                $codes = DB::table("discount_code")->where('code','like',"%".$code."%")->get();
               	return view("discountCodes.discountCodes",["codes"=>$codes,"title"=>"Search Results"]);
            }else{
                return view("pages.undefind",[
                    "title" => "Undefind",
                    "message"=>"Undefind code"
                ]);
            }
        }

    }

    public function viewCode($id)
    {
    	$code = DB::table("discount_code")->select("*")->where("id","=",$id)->paginate(10);
       	return view("discountCodes.discountCodes",["codes"=>$code,"title"=>"Discount Code"]);
    }
}
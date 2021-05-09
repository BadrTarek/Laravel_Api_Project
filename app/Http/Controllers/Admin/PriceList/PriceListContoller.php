<?php

namespace App\Http\Controllers\Admin\PriceList;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PriceModel;
use Illuminate\Support\Facades\DB;

class PriceListContoller extends Controller
{
    public function index(){
    	$priceList = PriceModel::select("price_list.*","trucks_types.name_en as trucks_types_name")->join("trucks_types","trucks_types.id","price_list.trucks_types_id")->get();
    	return view("priceList.priceList",["priceList"=>$priceList]);
    }
    public function editPrice(Request $req , $id){
    	$price = PriceModel::find($id);
        if($price == null)
        {
            return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"Undefind Price"
            ]);
        }  
    	$trucks_types = DB::table('trucks_types')->get();
    	return view("priceList.editPrice",["price"=>$price,"trucks_types"=>$trucks_types]);
    }

    public function update(Request $req,$id){
    	$this->validate($req, [
            'category' => 'required|numeric',
            'price' => 'required|numeric',
            'trucks_types_id' => 'required|numeric|exists:trucks_types,id'
        ]);
    	$price = PriceModel::find($id);
        if($price == null)
        {
            return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"Undefind Price"
            ]);
        }    	
    	$price->category = $req->category;
    	$price->price = $req->price;
    	$price->trucks_types_id = $req->trucks_types_id;
    	$price->save();
    	return redirect("/_admin/priceList")->with("action","Updated Successfully");
    }
    public function addPrice(){
    	$trucks_types = DB::table('trucks_types')->get();
		return view("priceList.addPrice",["trucks_types"=>$trucks_types]);    	
    }

    public function insert(Request $req){
    	$this->validate($req, [
            'category' => 'required|numeric',
            'price' => 'required|numeric',
            'trucks_types_id' => 'required|numeric|exists:trucks_types,id'
        ]);
        $price = new PriceModel;    	
    	$price->category = $req->category;
    	$price->price = $req->price;
    	$price->trucks_types_id = $req->trucks_types_id;
    	$price->save();
		return back()->with("action","Added Successfully");
    }
}

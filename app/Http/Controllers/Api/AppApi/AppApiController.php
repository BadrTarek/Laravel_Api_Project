<?php

namespace App\Http\Controllers\Api\AppApi;






use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class AppApiController extends Controller
{
    use \App\Http\Controllers\Api\ApiResponseTrait;

     public function appInfo(Request $req){
        $validation = Validator::make($req->all(),[
            'language' => 'required|string|in:ar,en|min:2'
        ]); 
        if($validation->fails()){
            return $this->apiResponseNoObj(400,$validation->errors());
        }else{
            $appInfo = DB::table("settings")->select("*")->get();
            return $this->apiResponseNoMessage(200,$appInfo);
        }   
    }

    public function getTrucksTypes(Request $req){
        $validation = Validator::make($req->all(),[
            'language' => 'required|string|in:ar,en|min:2'
        ]); 
        if($validation->fails()){
            return $this->apiResponseNoObj(400,$validation->errors());
        }
        $trucks_types = DB::table("trucks_types")->where("is_active","=",1)->get();
        return $this->apiResponseNoMessage(200,$trucks_types);    
    }

    public function getGoodsTypes(Request $req){

        $goods_types = DB::table("goods_types")->get();
        return $this->apiResponseNoMessage(200,$goods_types);    
    }

    public function getBankAccounts(Request $req){
        $goods_types = DB::table("bank_accounts")->get();
        return $this->apiResponseNoMessage(200,$goods_types);
    }

    public function changeLanguage(Request $req){
        $validation = Validator::make($req->all(),[
            'language' => 'required|string|in:ar,en|min:2'
        ]); 
        if($validation->fails()){
            return $this->apiResponseNoObj(400,$validation->errors());
        }
        $updateLan = DB::table(auth_table())->where('id', auth_id())->update(['language' => $req->language]);

        return response(["status"=>200]);
    }

    

}


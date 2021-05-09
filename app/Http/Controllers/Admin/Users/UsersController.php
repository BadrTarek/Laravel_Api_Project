<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(){
    	//$users = User::select("*")->paginate(10);
        $users = User::select( "users.*",DB::raw('COUNT(orders.id) as number_of_orders') )->leftJoin('orders','orders.users_id',"users.id")->groupBy("users.id")->paginate(10);

    	if($users->count() <= 0)
    	{
    		return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"undefind users"
            ]); 
    	}
      	return view("users.users",['users'=>$users,"title"=>"Users"]);
    }

    public function search(Request $req,$name=null)
    {
        if($name==null)
            $name = $req['userName'];
        if($req->ajax())
        {
            if($name != null){

                $users = User::select("id","name")->where('name','like',"%".$name."%")->get();
                return response()->json(($users->count()>0)?$users:null );
            }else{
                return response()->json(null);
            }
        }else{
            if($name != null){

                $users = User::select("*")->where('name','like',"%".$name."%")->paginate(10);
                return view("users.users",['users'=>$users,"title"=>"Search Results"]);
            }else{
                return view("pages.undefind",[
                    "title" => "Undefind",
                    "message"=>"Undefind user"
                ]);
            }
        }

    }

    public function activedUsers()
    {

         $users = User::select( "users.*",DB::raw('COUNT(orders.id) as number_of_orders') )->leftJoin('orders','orders.users_id',"users.id")->where("users.is_active","=",1)->groupBy("users.id")->paginate(10);
        if($users->count() <= 0)
    	{
    		return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"No actived users"
            ]); 
    	}
        return view("users.users",['users'=>$users,"title"=>"Actived Users"]);
    }
    public function inActivedUsers()
    {

         $users = User::select( "users.*",DB::raw('COUNT(orders.id) as number_of_orders') )->leftJoin('orders','orders.users_id',"users.id")->where("users.is_active","=",0)->groupBy("users.id")->paginate(10);
        if($users->count() <= 0)
    	{
    		return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"No inactived users"
            ]); 
    	}
        return view("users.users",['users'=>$users,"title"=>"Inactived Users"]);
    }


    public function inactiveUser(Request $req,$id){
    	$user = User::find($id);
    	if($user == null )
    	{	
    		return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"Undefind user to inactivate"
            ]); 
    	}
    	$user->is_active = 0;
    	$user->save();
    	return back()->with("action","User inactived successfully");
    }

    public function activeUser(Request $req,$id){
    	$user = User::find($id);
    	if($user == null )
    	{	
    		return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"Undefind user to activate"
            ]); 
    	}
    	$user->is_active = 1;
    	$user->save();
    	return back()->with("action","User actived successfully");
    }

    public function viewUser(Request $req,$id){
   	
         $user = User::select( "users.*",DB::raw('COUNT(orders.id) as number_of_orders') )->leftJoin('orders','orders.users_id',"users.id")->where("users.id","=",$id)->groupBy("users.id")->first();
        if($user == null )
    	{	
    		return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"Undefind user "
            ]); 
    	}
    	return view("users.viewUser",compact("user"));
    }


}

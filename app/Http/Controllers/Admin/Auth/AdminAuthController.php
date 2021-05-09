<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Providers\RouteServiceProvider;
use App\Models\Admin;

class AdminAuthController extends Controller
{
	public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $req){
    	 $this->validate($req, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8']
        ]);

        if( auth('admin')->attempt( array('email' => $req['email'], 'password' => $req['password']) )){
            if(auth('admin')->user()->type == "company"){
                return redirect(RouteServiceProvider::HOMECOMPANY);                
            }else{            
                return redirect(RouteServiceProvider::HOME);
            }
        }else{
        	return redirect('_admin/login')->with("error","Invalid Login");
        }

    }
    public function logout(){
        auth('admin')->logout();
        return redirect( RouteServiceProvider::LOGIN);
    }

    public function addAdmin(Request $req){
        $this->validate($req, [
            'email' => 'required|string|email|max:255|unique:admins,email',
            'password' => 'required|string|min:8',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|alpha_num|min:6|unique:admins,phone',
            'type' => 'required|string|in:admin,company',
            'role' => 'in:add,edit,update',
            'is_active' => 'required|boolean',
            //'is_super_admins' => 'required|boolean'
        ]);
        
        $admin = new Admin;
        $admin->email = $req->email;
        $admin->password = Hash::make( $req->password );
        $admin->name = $req->name;
        $admin->phone = $req->phone;
        $admin->type = $req->type;
        $admin->role = $req->role;
        $admin->is_active = $req->is_active;
        //$admin->is_super_admins = $req->is_super_admins;
        $admin->is_super_admins = 0;
        $admin->save();

        return back()->with("action","Added Successfully");

    }

    public function admins(){
        $admins =Admin::select("*")->where("type","=","admin")->paginate(10);
        return view("auth.admins",["admins"=>$admins,"search" => "searchForAdmins","title"=>"Admins"]);
    }

    public function companies(){
        $admins = Admin::select("*")->where("type","=","company")->paginate(10);
        return view("auth.admins",["admins"=>$admins,"search" => "searchForCompanies","title"=>"Companies"]);
    }

    public function editAdmin($id){
        $admin = Admin::find($id);
        if($admin == null)
        {
            return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"Undefind Admin"
            ]);
        }
        return view("auth.editAdmin",compact("admin"));
    }

    public function updateAdmin(Request $req , $id){
         $this->validate($req, [
            'email' => 'required|string|email|max:255|unique:admins,email,'.$id.'id',
            'password' => ($req->password!=null)?'string|min:8':'',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|alpha_num|min:6|unique:admins,phone,'.$id.'id',
            'type' => 'required|string|in:admin,company',
            'role' => 'in:add,edit,update',
            'is_active' => 'required|boolean',
            //'is_super_admins' => 'required|boolean'
        ]);
        
        $admin = Admin::find($id);
        if($admin == null)
        {
            return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"Undefind Admin"
            ]);
        }
        $admin->email = $req->email;
        $admin->password = ($req->password != null)?Hash::make($req->password):$admin->password;
        $admin->name = $req->name;
        $admin->phone = $req->phone;
        $admin->type = $req->type;
        $admin->role = $req->role;
        $admin->is_active = $req->is_active;
        //$admin->is_super_admins = $req->is_super_admins;
        $admin->is_super_admins = 0;
        $admin->save();

        return back()->with("action","Updated Successfully");
    }


    public function searchForAdmins(Request $req,$name=null)
    {
        if($name==null)
            $name = $req['adminName'];
        if($req->ajax())
        {
            if($name != null){
                $admins = Admin::select("id","name")->where("type","=","admin")->where('name','like',"%".$name."%")->get();
                return response()->json(($admins->count()>0)?$admins:null );
            }else{
                return response()->json(null);
            }
        }else{
            if($name != null){
                $admins = Admin::select("*")->where("type","=","admin")->where('name','like',"%".$name."%")->paginate(10);

                if($admins->count()<=0)
                {
                    return view("pages.undefind",[
                        "title" => "Undefind",
                        "message"=>"undefind Admin"
                    ]);
                }
                return view("auth.admins",[
                    "title" => "Search Results",
                    "search" => "searchForAdmins",
                    "admins" => $admins
                ]);
            }else{
                return view("pages.undefind",[
                    "title" => "Undefind",
                    "message"=>"Undefind Admin"
                ]);
            }
        }

    }

    public function searchForCompanies(Request $req,$name=null)
    {
        if($name==null)
            $name = $req['adminName'];
        if($req->ajax())
        {
            if($name != null){
                $admins = Admin::select("id","name")->where("type","=","company")->where('name','like',"%".$name."%")->get();
                return response()->json(($admins->count()>0)?$admins:null );
            }else{
                return response()->json(null);
            }
        }else{
            if($name != null){
                $admins = Admin::select("*")->where("type","=","company")->where('name','like',"%".$name."%")->paginate(10);

                if($admins->count()<=0)
                {
                    return view("pages.undefind",[
                        "title" => "Undefind",
                        "message"=>"undefind Admin"
                    ]);
                }
                return view("auth.admins",[
                    "title" => "Search Results",
                    "search" => "searchForCompanies",
                    "admins" => $admins
                ]);
            }else{
                return view("pages.undefind",[
                    "title" => "Undefind",
                    "message"=>"Undefind Admin"
                ]);
            }
        }

    }


}

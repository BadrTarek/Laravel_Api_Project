<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PriceModel;
use Illuminate\Support\Facades\DB;


class SettingsController extends Controller
{
    public function phones(){
    	$phones = DB::table("phones")->get();
    	return view("settings.phones",["phones"=>$phones , "title"=>"Phones"]);
    }

    public function addPhone(Request $req){
    	$this->validate($req, [
	        'phone' => 'required|string|alpha_num|min:6',
            'is_active' => 'required|boolean'
        ]);
        DB::table('phones')->insert([
        	"phone" => $req->phone,
        	"is_active" => $req->is_active,
        	"created_at" => new \DateTime
        ]);
        return back()->with('action',"Added Successfully");
    }

    public function editPhone(Request $req,$id){
    	$this->validate($req, [
    		$id => 'exists:phones,id'
        ]);
        $phone = DB::table('phones')->find($id);
        if($phone == null)
        {
            return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"Undefind Phone"
            ]);
        }  
        return view("settings.editPhone",compact("phone"));
    }
    public function updatePhone(Request $req,$id){
    	$this->validate($req, [
    		$id => 'exists:phones,id',
	        'phone' => 'required|string|alpha_num|min:6',
            'is_active' => 'required|boolean'
        ]);
        DB::table('phones')->where("id","=",$id)->update([
        	"phone" => $req->phone,
        	"is_active" => $req->is_active
        ]);
        return redirect("/_admin/phones")->with('action',"Updated Successfully");
    }
    public function deletePhone(Request $req,$id){
    	$this->validate($req, [
    		$id => 'exists:phones,id'
        ]);
        DB::table('phones')->where('id', '=', $id)->delete();
        return redirect("/_admin/phones")->with("action","Deleted Successfully");
    }

    public function searchForPhones(Request $req,$phone=null)
    {
        if($phone==null)
            $phone = $req['phone'];
        if($req->ajax())
        {
            if($phone != null){
                $phones = DB::table("phones")->select("id","phone")->where('phone','like',"%".$phone."%")->get();
                return response()->json(($phones->count()>0)?$phones:null );
            }else{
                return response()->json(null);
            }
        }else{
            if($phone != null){
                $phones = DB::table("phones")->select("*")->where('phone','like',"%".$phone."%")->get();
                if($phones->count()<=0)
                {
                    return view("pages.undefind",[
                        "title" => "Undefind",
                        "message"=>"undefind phones"
                    ]);
                }
                return view("settings.phones",[
                    "title" => "Search Results",
                    "phones" => $phones
                ]);
            }else{
                return view("pages.undefind",[
                    "title" => "Undefind",
                    "message"=>"Undefind Phones"
                ]);
            }
        }

    }
    
    public function emails(){
    	$emails = DB::table("emails")->get();
    	return view("settings.emails",["emails"=>$emails , "title"=>"Emails"]);
    }

    public function addEmail(Request $req){
    	$this->validate($req, [
	        'email' => 'required|email',
            'is_active' => 'required|boolean'
        ]);
        DB::table('emails')->insert([
        	"email" => $req->email,
        	"is_active" => $req->is_active,
        	"created_at" => new \DateTime
        ]);
        return back()->with('action',"Added Successfully");
    }

    public function editEmail(Request $req,$id){
    	$this->validate($req, [
    		$id => 'exists:emails,id'
        ]);
        $email = DB::table('emails')->find($id);
        return view("settings.editEmail",compact("email"));
    }
    public function updateEmail(Request $req,$id){
    	$this->validate($req, [
    		$id => 'exists:emails,id',
	        'email' => 'required|email',
            'is_active' => 'required|boolean'
        ]);
        DB::table('emails')->where("id","=",$id)->update([
        	"email" => $req->email,
        	"is_active" => $req->is_active
        ]);
        return redirect("/_admin/emails")->with('action',"Updated Successfully");
    }
    public function deleteEmail(Request $req,$id){
    	$this->validate($req, [
    		$id => 'exists:emails,id'
        ]);
        DB::table('emails')->where('id', '=', $id)->delete();
        return redirect("/_admin/emails")->with("action","Deleted Successfully");
    }

    public function searchForEmails(Request $req,$email=null)
    {
        if($email==null)
            $email = $req['email'];
        if($req->ajax())
        {
            if($email != null){
                $emails = DB::table("emails")->select("id","email")->where('email','like',"%".$email."%")->get();
                return response()->json(($emails->count()>0)?$emails:null );
            }else{
                return response()->json(null);
            }
        }else{
            if($email != null){
                $emails = DB::table("emails")->select("*")->where('email','like',"%".$email."%")->get();
                if($emails->count()<=0)
                {
                    return view("pages.undefind",[
                        "title" => "Undefind",
                        "message"=>"undefind emails"
                    ]);
                }
                return view("settings.emails",[
                    "title" => "Search Results",
                    "emails" => $emails
                ]);
            }else{
                return view("pages.undefind",[
                    "title" => "Undefind",
                    "message"=>"Undefind Emails"
                ]);
            }
        }

    }
    

    public function statistics(){
        $number_of_users = DB::table("users")->select(DB::raw('COUNT(id) as number_of_users'))->get()->first();
        $number_of_drivers = DB::table("drivers")->select(DB::raw('COUNT(id) as number_of_drivers'))->get()->first();
        $number_of_orders = DB::table("orders")->select(DB::raw('COUNT(id) as number_of_orders'))->get()->first();
        $number_of_admins = DB::table("admins")->select(DB::raw('COUNT(id) as number_of_admins'))->where("type","=","admin")->get()->first();
        $number_of_companies = DB::table("admins")->select(DB::raw('COUNT(id) as number_of_companies'))->where("type","=","company")->get()->first();
        $good_types = DB::table("goods_types")->select(DB::raw('COUNT(id) as good_types'))->get()->first();
        $truck_types = DB::table("trucks_types")->select(DB::raw('COUNT(id) as truck_types'))->get()->first();
        $totalPays = DB::table("bills")->select(DB::raw('SUM(cost) as totalPays'))->get()->first();
        $number_of_messages = DB::table("contacts")->select(DB::raw('COUNT(id) as number_of_messages'))->get()->first();
        $number_of_users_messages = DB::table("contacts")->select(DB::raw('COUNT(id) as number_of_users_messages'))->where("users_id","!=",null)->get()->first();
         $number_of_drivers_messages = DB::table("contacts")->select(DB::raw('COUNT(id) as number_of_drivers_messages'))->where("drivers_id","!=",null)->get()->first();

        return view("pages.statistics",[
            "number_of_users" => $number_of_users->number_of_users,
            "number_of_drivers" => $number_of_drivers->number_of_drivers,
            "number_of_orders" => $number_of_orders->number_of_orders,
            "number_of_admins" => $number_of_admins->number_of_admins,
            "number_of_companies" => $number_of_companies->number_of_companies,
            "good_types" => $good_types->good_types,
            "truck_types" => $truck_types->truck_types,
            "totalPays" => $totalPays->totalPays,
            
            "number_of_messages" => $number_of_messages->number_of_messages,
            "number_of_users_messages" => $number_of_users_messages->number_of_users_messages,
            "number_of_drivers_messages" => $number_of_drivers_messages->number_of_drivers_messages
        ]);
    }
    
}

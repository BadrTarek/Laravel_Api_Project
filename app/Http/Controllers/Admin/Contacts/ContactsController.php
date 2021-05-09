<?php

namespace App\Http\Controllers\Admin\Contacts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PriceModel;
use Illuminate\Support\Facades\DB;


class ContactsController extends Controller
{
    public function index(){
    	$contactTypes = DB::table("contacts_types")->get("*");
    	return view("contacts.contactTypes",["contactTypes"=>$contactTypes,"title"=>"Contact Types"]);
    }

    public function edit($id){
    	$contactType = DB::table("contacts_types")->find($id);
    	if($contactType==null)
    	{
    		return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"undefind contact type"
            ]);
    	}
    	return view("contacts.editContactType",compact("contactType"));
    }

    public function update(Request $req , $id){
    	$this->validate($req, [
            'name' => 'required|string'
        ]);
    	DB::table('contacts_types')->where('id', $id)->update([
    		'name_en' => $req->name
    	]);
    	return redirect("/_admin/contactTypes")->with("action","Updated Successfully");
    }
    public function insert(Request $req){
    	$this->validate($req, [
            'name' => 'required|string'
        ]);
        DB::table('contacts_types')->insert([
    		'name_en' => $req->name
    	]);
    	return back()->with("action","Added Successfully");
    }

    public function search(Request $req,$name=null)
    {
        if($name==null)
            $name = $req['contactType'];
        if($req->ajax())
        {
            if($name != null){
                $contactTypes = DB::table("contacts_types")->select("id","name_en")->where('name_en','like',"%".$name."%")->get();
                return response()->json(($contactTypes->count()>0)?$contactTypes:null );
            }else{
                return response()->json(null);
            }
        }else{
            if($name != null){
                $contactTypes = DB::table("contacts_types")->select("*")->where('name_en','like',"%".$name."%")->get();

                if($contactTypes->count()<=0)
                {
                    return view("pages.undefind",[
                        "title" => "Undefind",
                        "message"=>"undefind Contact Type"
                    ]);
                }
                return view("contacts.contactTypes",[
                    "title" => "Search Results",
                    "contactTypes" => $contactTypes
                ]);
            }else{
                return view("pages.undefind",[
                    "title" => "Undefind",
                    "message"=>"Undefind Contact Type"
                ]);
            }
        }

    }


    public function contacts(){
        $contacts = DB::table("contacts")
                    ->select("contacts.*","users.name as users_name","users.phone as users_phone","drivers.name as drivers_name","drivers.phone as drivers_phone","contacts_types.name_en")
                    ->leftJoin("drivers","drivers.id","contacts.drivers_id")
                    ->leftJoin("users","users.id","contacts.users_id")
                    ->join("contacts_types","contacts_types.id","contacts.contacts_types_id")
                    ->where("contacts.status","=","open")
                    ->groupBy("contacts.id")->paginate(10);
        return view("contacts.contacts",["contacts"=>$contacts,"title"=>"New Contacts"]);
        //print_r($contacts);
    }

    public function closedContacts(){
        $contacts = DB::table("contacts")
                    ->select("contacts.*","users.name as users_name","users.phone as users_phone","drivers.name as drivers_name","drivers.phone as drivers_phone","contacts_types.name_en")
                    ->leftJoin("drivers","drivers.id","contacts.drivers_id")
                    ->leftJoin("users","users.id","contacts.users_id")
                    ->join("contacts_types","contacts_types.id","contacts.contacts_types_id")
                    ->where("contacts.status","=","closed")
                    ->groupBy("contacts.id")->paginate(10);
        return view("contacts.contacts",["contacts"=>$contacts,"title"=>"Closed Contacts"]);
    }

    public function guestsContacts(){
        $contacts = DB::table("contacts")
                    ->select("contacts.*","users.name as users_name","users.phone as users_phone","drivers.name as drivers_name","drivers.phone as drivers_phone","contacts_types.name_en")
                    ->leftJoin("drivers","drivers.id","contacts.drivers_id")
                    ->leftJoin("users","users.id","contacts.users_id")
                    ->join("contacts_types","contacts_types.id","contacts.contacts_types_id")
                    ->where("contacts.users_id","=",null)->where("contacts.drivers_id","=",null)
                    ->groupBy("contacts.id")->paginate(10);
        return view("contacts.contacts",["contacts"=>$contacts,"title"=>"Guest Contacts"]);
    }

    public function driversContacts(){
        $contacts = DB::table("contacts")
                    ->select("contacts.*","drivers.name as drivers_name","drivers.phone as drivers_phone","contacts_types.name_en")
                    ->leftJoin("drivers","drivers.id","contacts.drivers_id")
                    ->join("contacts_types","contacts_types.id","contacts.contacts_types_id")
                    ->where("contacts.drivers_id","!=",null)
                    ->groupBy("contacts.id")->paginate(10);
        return view("contacts.contacts",["contacts"=>$contacts,"title"=>"Driver Contacts"]);
    }

    public function usersContacts(){
        $contacts = DB::table("contacts")
                    ->select("contacts.*","users.name as users_name","users.phone as users_phone","contacts_types.name_en")
                    ->leftJoin("users","users.id","contacts.users_id")
                    ->join("contacts_types","contacts_types.id","contacts.contacts_types_id")
                    ->where("contacts.users_id","!=",null)
                    ->groupBy("contacts.id")->paginate(10);
        return view("contacts.contacts",["contacts"=>$contacts,"title"=>"Users Contacts"]);
    }

    public function viewContact($id){
        $contact = DB::table("contacts")
                    ->select("contacts.*","users.name as users_name","users.phone as users_phone","drivers.name as drivers_name","drivers.phone as drivers_phone","contacts_types.name_en")
                    ->leftJoin("drivers","drivers.id","contacts.drivers_id")
                    ->leftJoin("users","users.id","contacts.users_id")
                    ->join("contacts_types","contacts_types.id","contacts.contacts_types_id")
                    ->where("contacts.id","=",$id)
                    ->groupBy("contacts.id")->get()->first();
        if($contact == null )
        {
            return view("pages.undefind",[
                    "title" => "Undefind",
                    "message"=>"Undefind This Contact"
                ]);
        }
        DB::table("contacts")->where("id","=",$id)->update([
            "status" => "closed"
        ]);
        return view("contacts.viewContact",compact("contact"));
    }


    public function searchForContacts(Request $req , $code=null){
        if($code==null)
            $code = $req['contactCode'];
        if($req->ajax())
        {
            if($code != null){
                $contacts = DB::table("contacts")->select("id","code")->where('code','like',"%".$code."%")->get();
                return response()->json(($contacts->count()>0)?$contacts:null );
            }else{
                return response()->json(null);
            }
        }else{
            if($code != null){
                $contacts = DB::table("contacts")
                        ->select("contacts.*","users.name as users_name","users.phone as users_phone","drivers.name as drivers_name","drivers.phone as drivers_phone","contacts_types.name_en")
                        ->leftJoin("drivers","drivers.id","contacts.drivers_id")
                        ->leftJoin("users","users.id","contacts.users_id")
                        ->join("contacts_types","contacts_types.id","contacts.contacts_types_id")
                        ->where("contacts.code","like","%".$code."%")
                        ->groupBy("contacts.id")->paginate(10);                
                if($contacts->count()<=0)
                {
                    return view("pages.undefind",[
                        "title" => "Undefind",
                        "message"=>"undefind Contacts"
                    ]);
                }
                return view("contacts.contacts",[
                    "title" => "Search Results",
                    "contacts" => $contacts
                ]);
            }else{
                return view("pages.undefind",[
                    "title" => "Undefind",
                    "message"=>"Undefind Contacts"
                ]);
            }
        }   
    }
}

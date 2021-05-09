<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\LocationModel;


class OrdersController extends Controller
{
    public function index(){
    	$orders = Order::select("*")->with("order_user")->with("order_driver")->paginate(10);
    	if($orders->count()<=0)
    	{
    		return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"undefind orders"
            ]);
    	}
    	return view("orders.orders",["orders"=>$orders,"title"=>"Orders"]);
    }

    public function orderDetails($id){
    	/*$order = Order::select("*","goods_types.*",
    		"trucks_types.*")->where("id","=",$id)->join("goods_types","goods_types.id","orders.goods_types_id")->join("trucks_types","trucks_types.id","orders.trucks_types_id")->with("order_user")->with("order_driver")->get()->first();*/
    	$order = Order::select("*","goods_types.*")->where("orders.id","=",$id)->join("goods_types","goods_types.id","orders.goods_types_id")->with("order_user")->with("order_driver")->get()->first();
    	if($order == null)
    	{
    		return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"undefind orders"
            ]);
    	}
    	$pickupLocation = LocationModel::select("*")->where("id","=",$order->locations_pickup_id)->get()->first();
    	$destinationLocation = LocationModel::select("*")->where("id","=",$order->locations_destination_id)->get()->first();
    	return view("orders.orderDetails",[
    		"order"=>$order,
    		"pickupLocation" => $pickupLocation,
    		"destinationLocation" => $destinationLocation
    	]);
    }


    public function search(Request $req,$code=null)
    {
        if($code==null)
            $code = $req['orderCode'];
        if($req->ajax())
        {
            if($code != null){

                $orders = Order::select("id","code")->where('code','like',"%".$code."%")->get();
                return response()->json(($orders->count()>0)?$orders:null );
            }else{
                return response()->json(null);
            }
        }else{
            if($code != null){

                //$orders = Order::select("*")->where('code','like',"%".$code."%")->get();
                $orders = Order::select("*")->where('code','like',"%".$code."%")->with("order_user")->with("order_driver")->paginate(10);
                if($orders->count()<=0)
                {
                    return view("pages.undefind",[
                        "title" => "Undefind",
                        "message"=>"undefind orders"
                    ]);
                }
                return view("orders.orders",[
                    "title" => "Search Results",
                    "orders" => $orders
                ]);
            }else{
                return view("pages.undefind",[
                    "title" => "Undefind",
                    "message"=>"Undefind order"
                ]);
            }
        }

    }


    public function filter(Request $req,$status=null){
        if($status==null)
            $status = $req['status'];
        $orders = Order::select("*")->where('status','=',$status)->with("order_user")->with("order_driver")->paginate(10);
        if($orders->count()<=0)
        {
            return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"undefind orders"
            ]);
        }
        return view("orders.orders",[
            "title" => orderStatus($status)."Orders",
            "orders" => $orders
        ]);

    }

    public function billsPayRequests(){
        $requests = DB::table("offline_payment")->select("offline_payment.*","bills.cost","bills.discount","bills.orders_id","users.id as users_id","users.name")
                            ->join("bills","bills.id","offline_payment.bills_id")
                            ->join("orders","orders.id","bills.orders_id")
                            ->join("users","orders.users_id","users.id")
                            ->paginate(10);
        if($requests->count()<=0)
        {
            return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"Undefind Request"
            ]);
        }
        return view("orders.billsPayRequests",[
            "requests" => $requests,
            "title" => "Bills Pay Requests"
        ]);
    }

    public function acceptBillPayRequest(Request $req,$id){
        $requests = DB::table("offline_payment")->where("id","=",$id)->update([
            "admin_approve" => 1
        ]); 
        return back()->with("action","Request Accepted Successfully");
    }

    public function searchForBillPayRequests(Request $req,$code=null)
    {
        if($code==null)
            $code = $req['requestCode'];
        if($req->ajax())
        {
            if($code != null){

                $requests = DB::table("offline_payment")->select("id","code")->where('code','like',"%".$code."%")->get();
                return response()->json(($requests->count()>0)?$requests:null );
            }else{
                return response()->json(null);
            }
        }else{
            if($code != null){
                $requests = DB::table("offline_payment")
                            ->select("offline_payment.*","bills.cost","bills.discount","bills.orders_id","users.id as users_id","users.name")
                            ->join("bills","bills.id","offline_payment.bills_id")
                            ->join("orders","orders.id","bills.orders_id")
                            ->join("users","orders.users_id","users.id")
                            ->where('offline_payment.code','like',"%".$code."%")
                            ->paginate(10);               
                if($requests->count()<=0)
                {
                    return view("pages.undefind",[
                        "title" => "Undefind",
                        "message"=>"undefind requests"
                    ]);
                }
                return view("orders.billsPayRequests",[
                    "title" => "Search Results",
                    "requests" => $requests
                ]);
            }else{
                return view("pages.undefind",[
                    "title" => "Undefind",
                    "message"=>"Undefind Request"
                ]);
            }
        }
    }

    public function viewBillPayRequest($id){
        $requests = DB::table("offline_payment")
                            ->select("offline_payment.*","bills.cost","bills.discount","bills.orders_id","users.id as users_id","users.name")
                            ->join("bills","bills.id","offline_payment.bills_id")
                            ->join("orders","orders.id","bills.orders_id")
                            ->join("users","orders.users_id","users.id")
                            ->where('offline_payment.id','=',$id)
                            ->paginate(10);  

        if($requests->count()<=0)
        {
            return view("pages.undefind",[
                "title" => "Undefind",
                "message"=>"Undefind Request"
            ]);
        }
        return view("orders.billsPayRequests",[
            "title" => "Bill Pay Request",
            "requests" => $requests
        ]);
    }
}

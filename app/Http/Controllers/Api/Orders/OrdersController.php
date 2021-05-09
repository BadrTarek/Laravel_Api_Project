<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ReviewModel;
use App\Models\LocationModel;
use App\Models\PriceModel;
use App\Models\DiscountCodeModel;
use App\Models\BillModel;
use App\Models\Financials;
use Str;
use Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    use \App\Http\Controllers\Api\ApiOrderResponseTrait;

    public function createOrder(Request $req){
    	$order = new Order;

        /*Check Status Of Last order*/
        if($order->where("users_id",'=',auth("user-api")->user()->id)->where("status","!=","closed")->count()>0 ){
            return $this->apiResponseNoObj(417,"cannot send the order because you have order not done yet");
        }

        /*Check if last User rate last order*/
        $lastOrder  = $order->select('id')->where("users_id","=",auth("user-api")->user()->id)->latest()->get();
        if($lastOrder->count()>0){
            if(ReviewModel::where("orders_id","=",$lastOrder[0]->id)->where("type","=","userToDriver")->count()<=0){
                return $this->apiResponseNoObj(418,"The request failed because you don't rated the last order.");
            }
        }

        /*Validation of request data*/
    	$validation = Validator::make($req->all(),[
    		"locations_pickup_id" => "required",
    		"locations_destination_id" => "required",
    		"trucks_types_id"  => 'required|numeric',    		
    		"image" => "image|mimes:jpeg,png,jpg,gif,webp|max:2048",
    		"goods_types_id" => "required|string",
    		"descriptions" => "string",
    		"i_am_recipient" => "required|boolean",
    		"recipient_name" =>"string".(($req->i_am_recipient==false)?"|required":"" ),
    		"country_code" => "string".(($req->i_am_recipient==false)?"|required":"" ),
    		"phone" => "string".(($req->i_am_recipient==false)?"|required":"" ),
    		"load_weight" =>"string"
    	]);
    	if($validation->fails())
    	{
    		return $this->apiResponseNoObj(400,$validation->errors());
    	}
    	
        /*Insert Data To Order Table*/
        $order->locations_pickup_id = $req->locations_pickup_id;
    	$order->locations_destination_id = $req->locations_destination_id;
    	$order->trucks_types_id = $req->trucks_types_id;
    	$order->image = ($req->hasFile("image"))?(upload($req->file('image'),"OrderUploads")):"";
    	$order->goods_types_id = $req->goods_types_id;
    	$order->descriptions = $req->descriptions;
    	$order->i_am_recipient = $req->i_am_recipient;
    	$order->recipient_name = $req->recipient_name;
    	$order->country_code = $req->country_code;
    	$order->phone = $req->phone;
    	$order->load_weight = $req->load_weight;
        $order->users_id = auth('user-api')->user()->id;
        $order->code = Str::random(5);
        $order->created_at = new \DateTime();
    	$order->save();

        /*Calculate Distance */
        $location = new LocationModel;
        $locationFrom = $location->find($req->locations_pickup_id);
        $locationTo = $location->find($req->locations_destination_id);
        $distance  = distance($locationFrom->latitude, $locationFrom->longitude , $locationTo->latitude, $locationTo->longitude , "K");

        /*Calculate cost*/
        $allCategoriesObj = PriceModel::where("trucks_types_id","=",$req->trucks_types_id)->get();
        $allCategories[0] = 0 ;
        foreach($allCategoriesObj as $key){
            $allCategories[] = $key->category;
        }
        sort($allCategories);
        if($distance <= min($allCategories)){
            $selectedCategory = min($allCategories);
        }else if($distance >= max($allCategories) ){
            $selectedCategory = max($allCategories);
        }else{ 
            $i = 0;
            while($i < count($allCategories)-1 ){
                    if($distance >= $allCategories[$i] && $distance < $allCategories[$i+1] ){
                        $selectedCategory = $allCategories[$i+1];
                        break;
                    }
                $i++;
            }
        }
        $priceOfOrder = PriceModel::select("price")->where("category","=",$selectedCategory)->get()->first();

        /*Make Bill*/
        $billModel = new BillModel;
        $billModel->orders_id = $order->id;
        $billModel->cost = $priceOfOrder->price;
        $billModel->payment_type = "offline";
        $billModel->status = "waiting";
        $billModel->created_at =  new \DateTime();
        $billModel->save();

        /*retrun data*/
        $orderObj  = Order::where('id','=',$order->id)->with("order_user")->with("order_bill")->first();
        return $this->apiResponse(200,$orderObj,"order successfully submitted");
    }

    public function discountCode(Request $req){
        /*Check Validation*/
        $validation = Validator::make($req->all() , [
            'orders_id' => "required|numeric|exists:orders,id",
            'code' => "required|string"
        ]);
        if($validation->fails()){
            return $this->apiResponseNoObj(400,$validation->errors()); 
        }

        //$discountCodeModel = new DiscountCodeModel;
        $codeData  = DiscountCodeModel::where("code","=",$req->code)->get()->first();

        /*Check if code exist or not*/
        if($codeData==null || $codeData->count()<=0)
        {   
            return $this->apiResponseNoObj(422,"code not exist");
        } /*Check if code is active or not*/
        else if($codeData->is_active == 0 )
        {
            return $this->apiResponseNoObj(419,"code not activated");
        } /*Check if count  > 0 */
        else if($codeData->count <= 0)
        {
            return $this->apiResponseNoObj(420,"code richied to limit");
        }/*Check if end time */
        else if($codeData->end_date < now())
        {
            return $this->apiResponseNoObj(420,"time limit of code was end");
        }/*Check if user use this code before or not */
        else if(DB::table('users_has_discount_code')->where("users_id","=",auth("user-api")->user()->id)->where("discount_code_id","=",$codeData->id)->count() > 0){
            return $this->apiResponseNoObj(421, "code used before");
        }


        /*Active Code by add record to users_has_discount_code table*/
        DB::table('users_has_discount_code')->insert([
            'users_id' => auth("user-api")->user()->id,
            "discount_code_id" => $codeData->id
        ]);

        /*Update Cost in bill*/
        $orderBill =  BillModel::where("orders_id","=",$req->orders_id)->get()->first();
        $orderBill->cost -=  ( ($codeData->discount/100) * $orderBill->cost);
        $orderBill->save();

        /*Decreament Count*/
        $codeData->count--;
        $codeData->save();

        /*return success data*/
        return $this->apiResponseNoObj(200, "discount applied successfully.");
    }

    public function getOrdersPast(Request $req){
        if(auth("driver-api")->check()){
            $type = "drivers_id";
            $auth_id = auth("driver-api")->user()->id;
        }elseif(auth("user-api")->check()){
            $type = "users_id";
            $auth_id = auth("user-api")->user()->id;
        }

        /*$allOrdersPast = Order::select("orders.*","bills.*")//->with("order_bill")
            ->join('bills', function ($join) {
                $join->on('bills.orders_id', '=', 'orders.id');
                $join->on('bills.status', '=', 'paid');
            })->where($type ,"=", $auth_id)->where("orders.status","=","closed")->get();
        */
        
        $allOrdersPast = Order::select("orders.*")->with("order_bill")
            ->where($type ,"=",$auth_id)
            ->where('orders.status','=','closed')->get();


        return $this->apiResponseNoMessage(200,($allOrdersPast->count()>0)?$allOrdersPast:null);
    }

    public function getOrdersPending(Request $req){
        if(auth("driver-api")->check()){
            $type = "drivers_id";
            $auth_id = auth("driver-api")->user()->id;
        }elseif(auth("user-api")->check()){
            $type = "users_id";
            $auth_id = auth("user-api")->user()->id;
        }
        /*$allOrdersPending = Order::select("orders.*","bills.*")->with("order_bill")
            ->join('bills', function ($join) {
                $join->on('bills.orders_id', '=', 'orders.id');
            })->where($type ,"=", $auth_id)->where("orders.status","!=","closed")->get();*/

        $allOrdersPending = Order::select("orders.*")->with("order_bill")
            ->where($type ,"=",$auth_id)
            ->where('orders.status','!=','closed')->get();

        return $this->apiResponseNoMessage(200,($allOrdersPending->count()>0)?$allOrdersPending:null);
    }

    public function cancelOrderByUser(Request $req){
        /*Validation of request data*/
        $validation = Validator::make($req->all(),[
            "orders_id" => "required|numeric|exists:orders,id"
        ]);
        if($validation->fails())
        {
            return $this->apiResponseNoObj(400,$validation->errors());
        }

        /*Check status of this order  */
        $order  = Order::find($req->orders_id);
        if($order->status != "awaitingPayment"){
            return $this->apiResponseNoObj(423,"can't cancel the order");
        }
        
        /*update status of this order*/
        $order->status = "cancelledByUser";
        $order->save();

        /*retrun data*/
        return $this->apiResponseNoObj(200,"Successfully canceled");
    }

    public function acceptOrderByDriver(Request $req){
        /*Validation of request data*/
        $validation = Validator::make($req->all(),[
            "orders_id" => "required|numeric|exists:orders,id"
        ]);
        if($validation->fails())
        {
            return $this->apiResponseNoObj(400,$validation->errors());
        }
        $order  = Order::find($req->orders_id);

        /*Check status of this order  */
        if($order->status != "awaitingDriver"){
            return $this->apiResponseNoObj(424,"action can't completed");
        }/*Check if there an active order  */
        else if(Order::where("status","!=","closed")->where("drivers_id","=",auth("driver-api")->user()->id)->get()->count() > 0){
            return $this->apiResponseNoObj(425,"cannot send the order because you have order not done yet,");
        }

        /*Check if last User rate last order*/
        $lastOrder  = Order::select('id')->where("drivers_id","=",auth("driver-api")->user()->id)->latest()->get();
        if($lastOrder->count()>0){
            if(ReviewModel::where("orders_id","=",$lastOrder[0]->id)->where("type","=","driverToUser")->count()<=0){
                return $this->apiResponseNoObj(426,"cannot send the order because you haven't rated your last order,");
            }
        }

        /*Create a bill for driver*/
        $orderBill = BillModel::where("orders_id","=",$req->orders_id)->get()->first();
        //return response($orderBill);
        if($orderBill->fees == null){
            $fees = DB::table('settings')->select("fees")->get()->first();
            $fees = $fees->fees;  
        }else{
            $fees = $orderBill->fees;
        }
        $financials = new Financials;
        $financials->total_benefit = $orderBill->cost * ($fees/100);  // (cost * fees%)
        $financials->created_at = new \DateTime();  
        $financials->drivers_id = auth("driver-api")->user()->id;  
        $financials->save();

        /*update status of this order*/
        $order->status = "acceptedByDriver";
        $order->drivers_id = auth("driver-api")->user()->id;
        $order->save();

        /*return data*/
        return $this->apiResponseNoObj(200,"Successfully accepted");
    }


    public function cancelOrderByDriver(Request $req){
        $validation = Validator::make($req->all(),[
            "orders_id" => "required|numeric|exists:orders,id"
        ]);
        if($validation->fails())
        {
            return response($this->apiResponseNoObj(400,$validation->errors()));
        }

        $order  = Order::find($req->orders_id);
        if($order->status != "acceptedByDriver"){
            return response($this->apiResponseNoObj(427,"can't cancel the order"));
        }


        $bill = new BillModel;
        $orderBill = $bill->where("orders_id","=",$req->orders_id)->get()->first();


        if($orderBill->fees == null){
            $fees = DB::table('settings')->select("fees")->get()->first();
            $fees = $fees->fees;  
        }else{
            $fees = $orderBill->fees;
        }

        $financials = Financials::where("drivers_id" , "=" , auth("driver-api")->user()->id)->latest()->get();
        $financials[0]->total_benefit -= $orderBill->cost * ($fees/100);
        $financials->save();

        $order->status = "cancelledByDriver";
        $order->save();

        return response($this->apiResponseNoObj(200,"Successfully canceled"));
    }

    public function arrivedToPickUpLocation(Request $req){
        $validation = Validator::make($req->all(),[
            "orders_id" => "required|numeric|exists:orders,id"
        ]);
        if($validation->fails())
        {
            return response($this->apiResponseNoObj(400,$validation->errors()));
        }


        $order  = Order::find($req->orders_id);
        if($order->status != "acceptedByDriver"){
            return response($this->apiResponseNoObj(428,"action can't completed"));
        }

        $order->status = "arrivedPickUpLocation";
        $order->save();

        return response($this->apiResponseNoObj(200,"Action completed successfully"));   
    }

    public function goodsLoading(Request $req){
        $validation = Validator::make($req->all(),[
            "orders_id" => "required|numeric|exists:orders,id"
        ]);
        if($validation->fails())
        {
            return response($this->apiResponseNoObj(400,$validation->errors()));
        }


        $order  = Order::find($req->orders_id);
        if($order->status != "arrivedPickUpLocation"){
            return response($this->apiResponseNoObj(429,"action can't completed"));
        }

        $order->status = "goodsLoading";
        $order->save();

        return response($this->apiResponseNoObj(200,"Action completed successfully"));   
    }

    public function startMoving(Request $req){
        $validation = Validator::make($req->all(),[
            "orders_id" => "required|numeric|exists:orders,id"
        ]);
        if($validation->fails())
        {
            return response($this->apiResponseNoObj(400,$validation->errors()));
        }


        $order  = Order::find($req->orders_id);
        if($order->status != "goodsLoading"){
            return response($this->apiResponseNoObj(430,"action can't completed"));
        }

        $order->status = "startMoving";
        $order->save();

        return response($this->apiResponseNoObj(200,"Action completed successfully"));   
    }

    public function arrivedToDestinationLocation(Request $req){
        $validation = Validator::make($req->all(),[
            "orders_id" => "required|numeric|exists:orders,id"
        ]);
        if($validation->fails())
        {
            return response($this->apiResponseNoObj(400,$validation->errors()));
        }


        $order  = Order::find($req->orders_id);
        if($order->status != "startMoving"){
            return response($this->apiResponseNoObj(431,"action can't completed"));
        }

        $order->status = "arrivedToDestinationLocation";
        $order->save();

        return response($this->apiResponseNoObj(200,"Action completed successfully"));   
    }

    public function finishTripByDriver(Request $req){
        $validation = Validator::make($req->all(),[
            "orders_id" => "required|numeric|exists:orders,id"
        ]);
        if($validation->fails())
        {
            return response($this->apiResponseNoObj(400,$validation->errors()));
        }


        $order  = Order::find($req->orders_id);
        if($order->status != "arrivedToDestinationLocation"){
            return response($this->apiResponseNoObj(432,"action can't completed"));
        }

        $order->status = "finishedTripByDriver";
        $order->save();

        return response($this->apiResponseNoObj(200,"Action completed successfully"));   
    }

    public function finishedTripByUser(Request $req){
        $validation = Validator::make($req->all(),[
            "orders_id" => "required|numeric|exists:orders,id"
        ]);
        if($validation->fails())
        {
            return response($this->apiResponseNoObj(400,$validation->errors()));
        }


        $order  = Order::find($req->orders_id);
        if($order->status != "finishedTripByDriver"){
            return response($this->apiResponseNoObj(432,"action can't completed"));
        }

        $order->status = "fininshedTripByUser";
        $order->save();

        return response($this->apiResponseNoObj(200,"Action completed successfully"));   
    }


    public function paymentType(Request $req){
        $validation = Validator::make($req->all(),[
            'type' => 'required|string|in:online,offline',
            "orders_id" => "required|numeric|exists:orders,id"
        ]); 
        if($validation->fails())
        {
            return $this->apiResponseNoObj(400,$validation->errors());
        }

        $bill = BillModel::where("orders_id","=",$req->orders_id)->get()->first();
        
        if($bill->count() > 0){

            $bill->payment_type = $req->type;
            $bill->save();

            return $this->apiResponseNoObj(200,"Action complete");
        }else{
            return $this->apiResponseNoObj(404,"Undefind order bill");
        }
    } 

    public function offlinePayment(Request $req){
        $validation = Validator::make($req->all(),[
            "image" => "image|mimes:jpeg,png,jpg,gif,webp|max:2048",
            "orders_id" => "required|numeric|exists:orders,id",

        ]); 
        if($validation->fails())
        {
            return $this->apiResponseNoObj(400,$validation->errors());
        }
        $bill = BillModel::where("orders_id","=",$req->orders_id)->get()->first();

        if($bill->count() > 0){

            $offlinePayment = DB::table("offline_payment")->insert([
                "bills_id" => $bill->id,
                "image_deposit" => upload($req->file('image'),"OrderUploads"),
                "code" => Str::random(5),
                "created_at" => new \DateTime()
            ]);
            return $this->apiResponseNoObj(200,"Action complete");
        }else{
            return $this->apiResponseNoObj(404,"Undefind order bill");
        }
    }

    public function codeToCLoseTripByDriver(Request $req){

        $validation = Validator::make($req->all(),[
            "orders_id" => "required|numeric|exists:orders,id",
            "code" => "required|string"
        ]);

        if($validation->fails())
        {
            return response($this->apiResponseNoObj(400,$validation->errors()));
        }


        $order  = Order::find($req->orders_id);
        if($order->status != "fininshedTripByUser"){
            return response($this->apiResponseNoObj(434,"action can't completed"));
        }elseif($order->code != $req->code){
            return response($this->apiResponseNoObj(435,"code is wrong"));
        }

        $order->status = "closed";
        $order->save();

        return response($this->apiResponseNoObj(200,"Action completed successfully"));   
    }


    public function getActiveOrder(Request $req){

        $exceptedStatusArr = ['waiting','awaitingPayment','awaitingDriver','cancelledByUser', 'cancelledByDriver','closed'];
        $orders = Order::select("*")->where(auth_type(),'=',auth_id())->whereNotIn('status',$exceptedStatusArr)->get();
        if($orders->count()>0)
            return $this->apiResponseNoMessage(200,$orders);
        else
            return $this->apiResponseNoMessage(200,null);
        
        //return response($orders);
        //SomeModel::select(..)->whereNotIn('book_price', [100,200])->get();

    }

    public function addRating(Request $req){
        $validation = Validator::make($req->all() , [
            'orders_id' => "required|numeric|exists:orders,id",
            'rate' => "required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/",
            'drivers_id'=> (isUserAuth())?"required|numeric|exists:drivers,id":"",
            'users_id'=> (isDriverAuth())?"required|numeric|exists:users,id":"",
        ]);
        if($validation->fails()){
            return $this->apiResponseNoObj(400,$validation->errors()); 
        }

        $reviewModel = new ReviewModel;

        $reviewModel->orders_id = $req->orders_id;
        if(isUserAuth()){
            $reviewModel->users_id = auth("user-api")->user()->id;
            $reviewModel->drivers_id = $req->drivers_id;
            $reviewModel->type = "userToDriver";
        }elseif(isDriverAuth()){            
            $reviewModel->drivers_id = auth("driver-api")->user()->id;
            $reviewModel->users_id = $req->users_id;
            $reviewModel->type = "driverToUser";
        }
        $reviewModel->created_at = new \DateTime();
        $reviewModel->rate = $req->rate;
        $reviewModel->save();

        return $this->apiResponseNoObj(200,"your rating has been successfully added");

    }

    public function getDriverLocation(Request $req)
    {
        $validation = Validator::make($req->all() , [
            'orders_id' => "required|numeric|exists:orders,id"
        ]);
        if($validation->fails()){
            return $this->apiResponseNoObj(400,$validation->errors()); 
        }     

        $order = Order::find($req->orders_id);
        $driver = DB::table("drivers")->find($order->id);
        $location = LocationModel::find($driver->locations_id);
        return $this->apiResponseNoMessage(200,$location);

    }   

    

}
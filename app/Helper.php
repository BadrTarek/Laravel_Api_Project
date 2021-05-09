<?php


function upload($file , $path){
    $new_image_name = time().$file->getClientOriginalName();
    $file->move(public_path($path),$new_image_name);
    return ('/'.$path.'/'.$new_image_name);
}

function distance($lat1, $lon1, $lat2, $lon2, $unit) {
    if (($lat1 == $lat2) && ($lon1 == $lon2)) {
        return 0;
    }
    else {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}

function sendSMS($number , $name , $message){
    $basic  = new \Vonage\Client\Credentials\Basic("1472dc11", "g9ma8LtKysxYEB4A");
    $client = new \Vonage\Client($basic);
    $response = $client->sms()->send(
        //new \Vonage\SMS\Message\SMS($number, $name, $message)
        new \Vonage\SMS\Message\SMS("201004323202", $name, $message)
    );

    $message = $response->current();

    if ($message->getStatus() == 0) {
        return  "The message was sent successfully" ;
    } else {
        return  "The message failed with status: ".$message->getStatus();
    }
}

// intervinsion
function isAuth(){
    if(auth('user-api')->check() || auth('driver-api')->check())
    {
        return true;
    }
    return false;
}
function isUserAuth(){
    if(auth('user-api')->check())
    {
        return true;
    }
    return false;
}
function isDriverAuth(){
    if(auth('driver-api')->check())
    {
        return true;
    }
    return false;
}
function auth_type(){
    if(auth('user-api')->check())
    {
        return "users_id";
    }
    elseif (auth('driver-api')->check())
    {
        return "drivers_id";
    }
}
function auth_id(){
    if(auth('user-api')->check())
    {
        return auth('user-api')->user()->id;
    }
    elseif (auth('driver-api')->check())
    {
        return auth('driver-api')->user()->id;
    }
}
function auth_table(){
    if(auth('user-api')->check())
    {
        return "users";
    }
    elseif (auth('driver-api')->check())
    {
        return "drivers";
    }
}

function acitveLink($name){
    return (request()->is($name)) ? 'active' : '';
}


function orderStatus($status){
    $goodSyntax = ["Waiting Payment","Canceled By User","Waiting Driver","Accepted By Driver","Canceled By Driver","Arrived Pickup Location","Goods Loading","start Moving","Arrivd To Destination Location","Finished Trip By Driver","Finished Trip By User","Closed"  , "Accepted By Company"];
    $syntaxInDB = ["awaitingPayment","cancelledByUser","awaitingDriver","acceptedByDriver","cancelledByDriver","arrivedPickUpLocation","goodsLoading","startMoving","arrivedToDestinationLocation","finishedTripByDriver","fininshedTripByUser","closed","acceptedByCompany"];//13
    $search = array_search($status, $syntaxInDB); 
    return $goodSyntax[$search];
}

function allOrdersStatus()
{
    return ["Waiting Payment","Canceled By User","Waiting Driver","Accepted By Driver","Canceled By Driver","Arrived Pickup Location","Goods Loading","start Moving","Arrivd To Destination Location","Finished Trip By Driver","Finished Trip By User","Closed"  , "Accepted By Company"];
}

function orderStatusInDB($status){
    $goodSyntax = ["Waiting Payment","Canceled By User","Waiting Driver","Accepted By Driver","Canceled By Driver","Arrived Pickup Location","Goods Loading","start Moving","Arrivd To Destination Location","Finished Trip By Driver","Finished Trip By User","Closed"  , "Accepted By Company"];
    $syntaxInDB = ["awaitingPayment","cancelledByUser","awaitingDriver","acceptedByDriver","cancelledByDriver","arrivedPickUpLocation","goodsLoading","startMoving","arrivedToDestinationLocation","finishedTripByDriver","fininshedTripByUser","closed","acceptedByCompany"];//13
    $search = array_search($status, $goodSyntax); 
    return $syntaxInDB[$search];
}
















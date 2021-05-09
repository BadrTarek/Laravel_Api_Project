<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserAuth\UserAuthController;
use App\Http\Controllers\Api\UserAuth\UserNotficationController;
use App\Http\Controllers\Api\DriverAuth\DriverAuthController;
use App\Http\Controllers\Api\Orders\OrdersController;
use App\Http\Controllers\Api\Contacts\ContactsController;
use App\Http\Controllers\Api\AppApi\AppApiController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post("user/register",[UserAuthController::class,"register"]);
Route::post("user/login",[UserAuthController::class,"login"]);


Route::post("driver/register",[DriverAuthController::class,"register"]);
Route::post("driver/login",[DriverAuthController::class,"login"]);


Route::group(['middleware' => 'auth-user'], function () {
	Route::post("user/logout",[UserAuthController::class,"logout"]);
	Route::post('updatePassword',[UserAuthController::class,'updatePassword']);


	Route::post('updateUserProfile',[UserAuthController::class,'updateUserProfile']);
	Route::post('verificationCodeToUpdatePhone',[UserAuthController::class,'verificationCodeToUpdatePhone']);

	
	Route::post('createOrder',[OrdersController::class,'createOrder']);
	Route::post('discountCode',[OrdersController::class,'discountCode']);
	Route::post('cancelOrderByUser',[OrdersController::class,'cancelOrderByUser']);
	Route::post('finishedTripByUser',[OrdersController::class,'finishedTripByUser']);


	Route::post('paymentType',[OrdersController::class,'paymentType']);
	Route::post('offlinePayment',[OrdersController::class,'offlinePayment']);
	Route::post('getGoodsTypes',[AppApiController::class,'getGoodsTypes']);


	Route::post('unseenNotifications',[UserNotficationController::class,'unseenNotifications']);
	Route::post('notifications',[UserNotficationController::class,'notifications']);


	Route::post('getDriverLocation',[OrdersController::class,'getDriverLocation']);

});




Route::post('appInfo',[AppApiController::class,'appInfo']);
Route::post('getTrucksTypes',[AppApiController::class,'getTrucksTypes']);

Route::post('verificationCode',[UserAuthController::class , "verificationCode"]);
Route::post('resendCode',[UserAuthController::class , "resendCode"]);

Route::post('contact',[ContactsController::class,"contact"]);





Route::group(['middleware' => 'auth-user-driver'], function () {
	Route::post('getOrdersPending',[OrdersController::class,'getOrdersPending']);
	Route::post('getOrdersPast',[OrdersController::class,'getOrdersPast']);


	Route::post('getContactsTypes',[ContactsController::class,'getContactsTypes']);
	Route::post('getBankAccounts',[AppApiController::class,'getbankAccounts']);
	Route::post('changeLanguage',[AppApiController::class,'changeLanguage']);
	Route::post('getActiveOrder',[OrdersController::class,'getActiveOrder']);
	Route::post('addRating',[OrdersController::class,'addRating']);

});





Route::group(['middleware' => 'auth-driver'], function () {
	Route::post("driver/logout",[DriverAuthController::class,"logout"]);
	Route::post('acceptOrderByDriver',[OrdersController::class,'acceptOrderByDriver']);
	Route::post('cancelOrderByDriver',[OrdersController::class,'cancelOrderByDriver']);
	Route::post('arrivedToPickUpLocation',[OrdersController::class,'arrivedToPickUpLocation']);
	Route::post('goodsLoading',[OrdersController::class,'goodsLoading']);
	Route::post('startMoving',[OrdersController::class,'startMoving']);
	Route::post('arrivedToDestinationLocation',[OrdersController::class,'arrivedToDestinationLocation']);
	Route::post('finishTripByDriver',[OrdersController::class,'finishTripByDriver']);



	Route::post('codeToCLoseTripByDriver',[OrdersController::class,'codeToCLoseTripByDriver']);
	Route::post('myProfit',[DriverAuthController::class,'myProfit']);
	Route::post('setDriverLocation',[DriverAuthController::class,'setDriverLocation']);

});



/*Route::get('test',[UserAuthController::class , "test"]);*/

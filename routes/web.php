<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Drivers\DriversController;
use App\Http\Controllers\Admin\Drivers\CompanyDriversController;
use App\Http\Controllers\Admin\Users\UsersController;
use App\Http\Controllers\Admin\Orders\OrdersController;
use App\Http\Controllers\Admin\PriceList\PriceListContoller;
use App\Http\Controllers\Admin\Contacts\ContactsController;
use App\Http\Controllers\Admin\Settings\SettingsController;
use App\Http\Controllers\Admin\DiscountCode\DiscountCodeController;
use App\Http\Controllers\Admin\TruckTypes\TruckTypesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('_company')->group(function(){
	Route::group(['middleware' => 'guest:admin'], function () {
		Route::get('login',function (){
			return view('auth.login');
		})->name('login');
		Route::post('login',[AdminAuthController::class,'login']);
	});
	Route::group(['middleware' => 'auth-admin'], function () {
		Route::post('logout',[AdminAuthController::class,'logout']);
		Route::group(['middleware' => 'company'], function () {

			Route::get('drivers',[CompanyDriversController::class,'index']);
			Route::get('inActivedDrivers',[CompanyDriversController::class,'inActivedDrivers']);
			Route::get('activedDrivers',[CompanyDriversController::class,'activedDrivers']);
			Route::get('addDriver',[CompanyDriversController::class,'addDriverPage']);
			Route::post("addDriver",[CompanyDriversController::class,'addDriver']);
			Route::get("editDriver/{id}",[CompanyDriversController::class,'editDriver']);
			Route::post("updateDriver/{id}",[CompanyDriversController::class,'updateDriver']);
			Route::match(['get', 'post'],'/searchForDrivers/{name?}',[CompanyDriversController::class,'search']);

		});
	});


});

Route::prefix('_admin')->group(function(){
	Route::group(['middleware' => 'guest:admin'], function () {
		Route::get('login',function (){
			return view('auth.login');
		})->name('login');
		Route::post('login',[AdminAuthController::class,'login']);
	});

	Route::group(['middleware' => 'auth-admin'], function () {
		Route::post('logout',[AdminAuthController::class,'logout']);


		Route::group(['middleware' => 'admin'], function () {
			Route::get('addAdmin',function(){
				return view('auth.addAdmin');
			});

			Route::get('statistics',[SettingsController::class,'statistics']);

			Route::get('drivers',[DriversController::class,'index']);

			Route::get('inActivedDrivers',[DriversController::class,'inActivedDrivers']);
			Route::get('activedDrivers',[DriversController::class,'activedDrivers']);
			Route::get('addDriver',[DriversController::class,'addDriverPage']);
			Route::post("addDriver",[DriversController::class,'addDriver']);
			Route::get("editDriver/{id}",[DriversController::class,'editDriver']);
			Route::post("updateDriver/{id}",[DriversController::class,'updateDriver']);
			Route::match(['get', 'post'],'/searchForDrivers/{name?}',[DriversController::class,'search']);


			Route::post('addAdmin',[AdminAuthController::class,'addAdmin']);
			Route::get('editAdmin/{id}',[AdminAuthController::class,"editAdmin"]);
			Route::post('updateAdmin/{id}',[AdminAuthController::class,"updateAdmin"]);
			Route::get('admins',[AdminAuthController::class,"admins"]);
			Route::get('companies',[AdminAuthController::class,"companies"]);
			Route::get('superAdmins',[AdminAuthController::class,"superAdmins"]);
			Route::match(['get', 'post'],'/searchForCompanies/{name?}',[AdminAuthController::class,'searchForCompanies']);
			Route::match(['get', 'post'],'/searchForAdmins/{name?}',[AdminAuthController::class,'searchForAdmins']);
			Route::get('users',[UsersController::class,'index']);
			Route::get('activedUsers',[UsersController::class,'activedUsers']);
			Route::get('inActivedUsers',[UsersController::class,'inActivedUsers']);
			Route::get('viewUser/{id}',[UsersController::class,'viewUser']);
			Route::post('activeUser/{id}',[UsersController::class,'activeUser']);
			Route::post('inactiveUser/{id}',[UsersController::class,'inactiveUser']);
			Route::match(['get', 'post'],'/searchForUsers/{name?}',[UsersController::class,'search']);



			Route::get('orders',[OrdersController::class,'index']);
			Route::get('billsPayRequests',[OrdersController::class,'billsPayRequests']);
			Route::get('viewBillPayRequest/{id}',[OrdersController::class,'viewBillPayRequest']);
			Route::post('acceptBillPayRequest/{id}',[OrdersController::class,'acceptBillPayRequest']);
			//Route::get('ordersWithFilter/{status?}',[OrdersController::class,'filter']);
			Route::get('orderDetails/{id}',[OrdersController::class,'orderDetails']);
			Route::match(['get', 'post'],'/searchForOrders/{code?}',[OrdersController::class,'search']);
			Route::match(['get', 'post'],'/ordersWithFilter/{status?}',[OrdersController::class,'filter']);
			Route::match(['get', 'post'],'/searchForBillPayRequests/{code?}',[OrdersController::class,'searchForBillPayRequests']);



			Route::get('priceList',[PriceListContoller::class,'index']);
			Route::get('addPrice',[PriceListContoller::class,'addPrice']);
			Route::post('addPrice',[PriceListContoller::class,'insert']);
			Route::get('editPrice/{id}',[PriceListContoller::class,'editPrice']);
			Route::post('updatePrice/{id}',[PriceListContoller::class,'update']);



			Route::get('contacts',[ContactsController::class,'contacts']);
			Route::get('closedContacts',[ContactsController::class,'closedContacts']);
			Route::get('guestsContacts',[ContactsController::class,'guestsContacts']);
			Route::get('usersContacts',[ContactsController::class,'usersContacts']);
			Route::get('driversContacts',[ContactsController::class,'driversContacts']);
			Route::get('viewContact/{id}',[ContactsController::class,'viewContact']);
			Route::match(['get', 'post'],'/searchForContacts/{code?}',[ContactsController::class,'searchForContacts']);

			Route::get('addContactType',function(){
				return view("contacts.addContactType");
			});
			Route::post('addContactType',[ContactsController::class,'insert']);
			Route::get('contactTypes',[ContactsController::class,'index']);
			Route::get('editContactType/{id}',[ContactsController::class,'edit']);
			Route::post('updatetContactType/{id}',[ContactsController::class,'update']);
			Route::match(['get', 'post'],'/searchForContactTypes/{name?}',[ContactsController::class,'search']);



			Route::get('phones',[SettingsController::class,"phones"]);
			Route::get('addPhone',function(){
				return view("settings.addPhone");
			});
			Route::post('addPhone',[SettingsController::class,"addPhone"]);
			Route::get('editPhone/{id}',[SettingsController::class,"editPhone"]);
			Route::post('updatePhone/{id}',[SettingsController::class,"updatePhone"]);
			Route::post('deletePhone/{id}',[SettingsController::class,"deletePhone"]);
			Route::match(['get', 'post'],'/searchForPhones/{phone?}',[SettingsController::class,'searchForPhones']);


			Route::get('emails',[SettingsController::class,"emails"]);
			Route::get('addEmail',function(){
				return view("settings.addEmail");
			});
			Route::post('addEmail',[SettingsController::class,"addEmail"]);
			Route::get('editEmail/{id}',[SettingsController::class,"editEmail"]);
			Route::post('updateEmail/{id}',[SettingsController::class,"updateEmail"]);
			Route::post('deleteEmail/{id}',[SettingsController::class,"deleteEmail"]);
			Route::match(['get', 'post'],'/searchForEmails/{phone?}',[SettingsController::class,'searchForEmails']);


			Route::get("discountCodes",[DiscountCodeController::class,"discountCodes"]);
			Route::get("activedDiscountCodes",[DiscountCodeController::class,"activedDiscountCodes"]);
			Route::get("inactivedDiscountCodes",[DiscountCodeController::class,"inactivedDiscountCodes"]);
			Route::get("addDiscountCode",function(){
				return view("discountCodes.addDiscountCode");
			});
			Route::post("addDiscountCode",[DiscountCodeController::class,"addDiscountCode"]);
			Route::post("deleteDiscountCode/{id}",[DiscountCodeController::class,"delete"]);
			Route::post("deactivateDiscountCode/{id}",[DiscountCodeController::class,"deactivateDiscountCode"]);
			Route::post("activateDiscountCode/{id}",[DiscountCodeController::class,"activateDiscountCode"]);
			Route::get("viewCode/{id}",[DiscountCodeController::class,"viewCode"]);
			Route::match(['get', 'post'],'/searchForDiscountCodes/{code?}',[DiscountCodeController::class,'searchForDiscountCodes']);




			Route::get("truckTypes",[TruckTypesController::class,"index"]);
			Route::get("addTruckType",function (){
				return view("truckTypes.addTruckType");
			});
			Route::post("addTruckType",[TruckTypesController::class,"insert"]);
			Route::get("editTruckType/{id}",[TruckTypesController::class,"edit"]);
			Route::post("updatetTruckType/{id}",[TruckTypesController::class,"update"]);
			Route::match(['get', 'post'],'/searchForTruckTypes/{name?}',[TruckTypesController::class,'search']);
		});
		
	});
});

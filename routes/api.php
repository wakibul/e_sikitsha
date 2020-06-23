<?php

use Illuminate\Http\Request;

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
Route::post('/customer/register', 'Api\Customer\Auth\RegisterController@register');
Route::post('/customer/verify-otp', 'Api\Customer\Auth\RegisterController@otp_verify');
Route::post('/customer/resend-otp', 'Api\Customer\Auth\RegisterController@resend_otp');
Route::post('/customer/login', 'Api\Customer\Auth\LoginController@index');
Route::get('/customer/master/location', 'Api\Customer\Master\RegionController@index');
Route::post('/customer/forgot-password', 'Api\Customer\ForgotPasswordController@index');
Route::post('/customer/validate-otp', 'Api\Customer\ForgotPasswordController@validateOtp');
Route::post('/customer/change-password', 'Api\Customer\ForgotPasswordController@changePassword');
Route::post('/customer/forgot-resend-otp', 'Api\Customer\ForgotPasswordController@resendOtp');
Route::post('/doctor/register', 'Api\Doctor\Auth\RegisterController@register');
Route::post('/doctor/verify', 'Api\Doctor\Auth\RegisterController@otp_verify');
Route::post('/doctor/resend-otp', 'Api\Doctor\Auth\RegisterController@resend_otp');
Route::post('/doctor/login', 'Api\Doctor\Auth\LoginController@index');
Route::middleware('auth:api')->group(function(){
    Route::get('/customer/master/departments', 'Api\Customer\Master\DepartmentController@index');
    Route::post('/customer/master/department-doctor', 'Api\Customer\Master\DepartmentController@departments');
    Route::post('/customer/master/clinics', 'Api\Customer\Master\ScheduleController@index');
    Route::post('/customer/master/schedule', 'Api\Customer\Master\ScheduleController@schedule');
    Route::post('/customer/master/slot', 'Api\Customer\Master\ScheduleController@slot');
    Route::post('/customer/temp-book', 'Api\Customer\BookingController@tempBook');
    Route::post('/customer/final-book', 'Api\Customer\BookingController@finalBook');
    Route::post('/customer/master/all-doctors', 'Api\Customer\Master\DoctorController@index');
    Route::post('/customer/master/popular-doctors', 'Api\Customer\Master\DoctorController@popular');
    Route::post('/customer/master/search-doctor', 'Api\Customer\Master\DoctorController@search');
    Route::post('/customer/master/clinic-doctors', 'Api\Customer\Master\DoctorController@clinic');
    Route::post('/customer/master/doctor-details', 'Api\Customer\Master\DoctorController@doctor');
    Route::get('/customer/master/pages', 'Api\Customer\Master\PageController@index');
    Route::get('/customer/my-orders', 'Api\Customer\BookingController@myOrders');
    Route::post('/customer/cancel-order', 'Api\Customer\BookingController@cancelOrder');
    Route::post('/customer/master/special-doctors', 'Api\Customer\Master\DoctorController@special');
});
Route::get('/customer/up', 'Api\Customer\BookingController@updatePic');
Route::get('/customer/version', 'Api\VersionController@index');

<?php

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

Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::get('/search', function () {
    return view('world.search');
});

Route::get('/autocomplete', 'World\SearchController@autocomplete')->name('autocomplete');
Route::get('/location', 'World\SearchController@location')->name('location');

Route::group(['prefix' => 'admin'], function () {
  Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'AdminAuth\RegisterController@register');

  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});

Route::get('/department', 'World\HomeController@departments')->name('department');
Route::get('/department/{slug}', 'World\HomeController@departmentByID')->name('department-doctor');
Route::get('/doctor/{slug}', 'World\HomeController@doctor')->name('doctor');
Route::get('/book/{doctor}/{clinic}', 'World\HomeController@book')->name('book');

//ajax dynamic slot time
Route::get('/slot', 'World\HomeController@ajaxSlot')->name('slot');
Route::post('/patient-info', 'World\HomeController@tempBook')->name('patient_info');
Route::post('/ticket', 'World\HomeController@ticket')->name('ticket');

Route::get('/about-us', 'World\HomeController@about')->name('about_us');
Route::get('/contact-us', 'World\HomeController@contact')->name('contact');
Route::post('/send-feedback', 'World\HomeController@feedback')->name('send_feedback');
Route::get('/service', 'World\HomeController@service')->name('service');
Route::get('/refund-policy', 'World\HomeController@refund')->name('refund_policy');
Route::get('/terms-conditions', 'World\HomeController@termCondition')->name('terms_conditions');
Route::get('/privacy-policy', 'World\HomeController@privacyPolicy')->name('privacy-policy');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => 'franchise'], function () {
       Route::get('/', [
            'as' => 'index',
            'middleware' => ['auth','member'],
            'uses' => 'Franchise\HomeController@index'
  ]);

  Route::get('/booking-details/{id}', [
    'as' => 'franchise.booking_details',
    'middleware' => ['auth','member'],
    'uses' => 'Franchise\HomeController@show'
]);

Route::get('/login/identify', [
  'as' => 'franchise.login.identify',
  'uses' => 'Franchise\ForgotPasswordController@index'
]);

Route::post('/login/identify', [
  'as' => 'franchise.login.send_otp',
  'uses' => 'Franchise\ForgotPasswordController@sendOtp'
]);

Route::post('/login/validate-otp', [
  'as' => 'franchise.login.validate_otp',
  'uses' => 'Franchise\ForgotPasswordController@validateOtp'
]);

Route::get('/login/change-password/{user_id}', [
  'as' => 'franchise.login.change_password',
  'uses' => 'Franchise\ForgotPasswordController@changePasswordIndex'
]);

Route::post('/login/change-password/{user_id}', [
  'as' => 'franchise.login.post_change_password',
  'uses' => 'Franchise\ForgotPasswordController@changePassword'
]);



});


Route::group(['prefix' => 'customer'], function () {
  Route::get('/login', 'CustomerAuth\LoginController@showLoginForm');
  Route::post('/login', 'CustomerAuth\LoginController@login');
  Route::post('/logout', 'CustomerAuth\LoginController@logout');

  Route::get('/register', 'CustomerAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'CustomerAuth\RegisterController@register');

  Route::post('/password/email', 'CustomerAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'CustomerAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'CustomerAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'CustomerAuth\ResetPasswordController@showResetForm');
});

Route::get('/auto-schedule', [
    'as' => 'auto_schedule',
    'uses' => 'Cron\CronController@index'
]);
Route::get('/auto-sms', [
    'as' => 'auto_sms',
    'uses' => 'Cron\CronController@autoSms'
]);





Route::group(['prefix' => 'doctor'], function () {
  Route::get('/login', 'DoctorAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'DoctorAuth\LoginController@login');
  Route::post('/logout', 'DoctorAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'DoctorAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'DoctorAuth\RegisterController@register');

  Route::post('/password/email', 'DoctorAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'DoctorAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'DoctorAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'DoctorAuth\ResetPasswordController@showResetForm');
});

<?php

Route::get('/home', function () {
	$users[] = Auth::user();
	$users[] = Auth::guard()->user();
	$users[] = Auth::guard('admin')->user();

	//dd($users);

	return view('admin.home');
})->name('home');

Route::group(['prefix' => 'city'], function () {
	Route::get('/index', [
		'as' => 'city.index',
		'middleware' => ['admin'],
		'uses' => 'Admin\CityController@index'
	]);

	Route::post('/store', [
		'as' => 'city.store',
		'middleware' => ['admin'],
		'uses' => 'Admin\CityController@store'
	]);

	Route::get('/edit/{id}', [
		'as' => 'city.edit',
		'middleware' => ['admin'],
		'uses' => 'Admin\CityController@edit'
	]);


	Route::post('/update/{id}', [
		'as' => 'city.update',
		'middleware' => ['admin'],
		'uses' => 'Admin\CityController@update'
	]);

	Route::get('/delete/{id}', [
		'as' => 'city.delete',
		'middleware' => ['admin'],
		'uses' => 'Admin\CityController@destroy'
	]);

	Route::post('/clinic', [
		'as' => 'city.ajax.clinic',
		'middleware' => ['admin'],
		'uses' => 'Admin\CityController@ajaxClinic'
	]);
});

Route::group(['prefix' => 'clinic'], function () {
	Route::get('/index', [
		'as' => 'clinic.index',
		'middleware' => ['admin'],
		'uses' => 'Admin\ClinicController@index'
	]);

	Route::get('/create', [
		'as' => 'clinic.create',
		'middleware' => ['admin'],
		'uses' => 'Admin\ClinicController@create'
	]);

	Route::post('/store', [
		'as' => 'clinic.store',
		'middleware' => ['admin'],
		'uses' => 'Admin\ClinicController@store'
	]);

	Route::get('/edit/{id}', [
		'as' => 'clinic.edit',
		'middleware' => ['admin'],
		'uses' => 'Admin\ClinicController@edit'
	]);

	Route::post('/update/{id}', [
		'as' => 'clinic.update',
		'middleware' => ['admin'],
		'uses' => 'Admin\ClinicController@update'
	]);

	Route::get('/delete/{id}', [
		'as' => 'clinic.delete',
		'middleware' => ['admin'],
		'uses' => 'Admin\ClinicController@destroy'
	]);
});

Route::group(['prefix' => 'department'], function () {
	Route::get('/index', [
		'as' => 'department.index',
		'middleware' => ['admin'],
		'uses' => 'Admin\DepartmentController@index'
	]);


	Route::post('/store', [
		'as' => 'department.store',
		'middleware' => ['admin'],
		'uses' => 'Admin\DepartmentController@store'
	]);

	Route::get('/edit/{id}', [
		'as' => 'department.edit',
		'middleware' => ['admin'],
		'uses' => 'Admin\DepartmentController@edit'
	]);

	Route::post('/update/{id}', [
		'as' => 'department.update',
		'middleware' => ['admin'],
		'uses' => 'Admin\DepartmentController@update'
	]);

	Route::get('/delete/{id}', [
		'as' => 'department.delete',
		'middleware' => ['admin'],
		'uses' => 'Admin\DepartmentController@destroy'
	]);
});

Route::group(['prefix' => 'doctor'], function () {

	Route::get('/index', [
		'as' => 'doctor.index',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@index'
	]);

	Route::get('/create', [
		'as' => 'doctor.create',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@create'
	]);

	Route::get('/edit/{doctor}', [
		'as' => 'doctor.edit',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@edit'
	]);

	Route::POST('/update/{id}', [
		'as' => 'doctor.update',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@update'
	]);

	Route::post('/store', [
		'as' => 'doctor.store',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@store'
	]);

	Route::post('/make-available', [
		'as' => 'doctor.make_available',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@makeAvailable'
	]);

	Route::get('/view-available/{doctor}', [
		'as' => 'doctor.view_available',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@viewAvailable'
	]);

	Route::get('/make-day-unavailable/{id}', [
		'as' => 'doctor.make_day_unavailable',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@dayUnAvailable'
	]);

	Route::get('/make-day-available/{id}', [
		'as' => 'doctor.make_day_available',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@dayAvailable'
	]);

	Route::get('/add-remarks/{doctor}/{clinic_id}', [
		'as' => 'doctor.add_remarks',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@addRemark'
	]);

	Route::post('/add-remarks/store', [
		'as' => 'doctor.add_remarks.store',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@addRemarkStore'
	]);

	Route::get('/remove-remarks/{doctor_id}/{clinic_id}', [
		'as' => 'doctor.remove_remarks',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@removeRemark'
    ]);
    Route::get('/add-note/{doctor}', [
		'as' => 'doctor.add_note',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@addNote'
    ]);
    Route::post('/add-note', [
		'as' => 'doctor.add_note.store',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@postNote'
    ]);

    Route::get('/remove-note/{doctor_id}', [
		'as' => 'doctor.remove_note',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@removeNote'
    ]);
	Route::get('/delete/{id}', [
		'as' => 'doctor.delete',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@destroy'
	]);
	Route::get('/add-fees/{doctor}', [
		'as' => 'doctor.add-fees',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@addFees'
	]);

	Route::post('/store-fees/{id}', [
		'as' => 'doctor.store_fees',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@storeFees'
	]);

	Route::get('/edit-fees/{doctor}', [
		'as' => 'doctor.edit-fees',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@editFees'
	]);

	Route::post('/update-fees/{doctor}', [
		'as' => 'doctor.udpate_fees',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@updateFees'
	]);

	Route::get('/view-schedule/{doctor}', [
		'as' => 'doctor.view_schedule',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@viewSchedule'
	]);

	Route::get('/edit-schedule/{id}', [
		'as' => 'doctor.edit_schedule',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@editSchedule'
	]);

	Route::post('/update-schedule/{id}', [
		'as' => 'doctor.update_schedule',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@updateSchedule'
	]);

	Route::get('/add-more-schedule/{doctor}', [
		'as' => 'doctor.add_more_schedule',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@addMoreSchedule'
	]);

	Route::post('/post-add-more-schedule/{id}', [
		'as' => 'doctor.post_add_more_schedule',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@storeMoreSchedule'
	]);

	Route::get('/delete-schedule{id}', [
		'as' => 'doctor.delete_schedule',
		'middleware' => ['admin'],
		'uses' => 'Admin\DoctorController@deleteSchedule'
	]);
});


Route::get('/daily/store', [
	'as' => 'daily.store',
	'middleware' => ['admin'],
	'uses' => 'Admin\DailyAvailableController@store'
]);

Route::group(['prefix' => 'franchise'], function () {

	Route::get('/create', [
		'as' => 'franchise.create',
		'middleware' => ['admin'],
		'uses' => 'Admin\FranchiseController@create'
	]);
	Route::get('/index', [
		'as' => 'franchise.index',
		'middleware' => ['admin'],
		'uses' => 'Admin\FranchiseController@index'
	]);
	Route::post('/create', [
		'as' => 'franchise.store',
		'middleware' => ['admin'],
		'uses' => 'Admin\FranchiseController@store'
	]);
	Route::get('/suspend/{id}', [
		'as' => 'franchise.suspend',
		'middleware' => ['admin'],
		'uses' => 'Admin\FranchiseController@suspend'
	]);
	Route::get('/activate/{id}', [
		'as' => 'franchise.activate',
		'middleware' => ['admin'],
		'uses' => 'Admin\FranchiseController@activate'
	]);
	Route::get('/view-transaction/{id}', [
		'as' => 'franchise.view_transaction',
		'middleware' => ['admin'],
		'uses' => 'Admin\FranchiseController@viewTransaction'
    ]);

    Route::get('/filter-transaction/{id}', [
		'as' => 'franchise.filter_transaction',
		'middleware' => ['admin'],
		'uses' => 'Admin\FranchiseController@filterTransaction'
    ]);

    Route::get('/booking/{id}', [
		'as' => 'franchise.booking',
		'middleware' => ['admin'],
		'uses' => 'Admin\FranchiseController@booking'
    ]);

    Route::get('/filter-booking/{id}', [
		'as' => 'franchise.filter_booking',
		'middleware' => ['admin'],
		'uses' => 'Admin\FranchiseController@filterBooking'
    ]);

    Route::get('/recharge/{id}', [
		'as' => 'franchise.recharge',
		'middleware' => ['admin'],
		'uses' => 'Admin\FranchiseController@recharge'
	]);
});

Route::group(['prefix' => 'report'], function () {
    Route::get('/bookings', [
        'as' => 'report.index',
        'middleware' => ['admin'],
        'uses' => 'Admin\ReportController@index'
    ]);

    Route::get('/bookings-filter', [
        'as' => 'report.filter',
        'middleware' => ['admin'],
        'uses' => 'Admin\ReportController@filter'
    ]);

    Route::get('/booking-details/{id}', [
        'as' => 'booking-details',
        'middleware' => ['admin'],
        'uses' => 'Admin\ReportController@show'
    ]);

    Route::get('/doctors', [
        'as' => 'report.doctors',
        'middleware' => ['admin'],
        'uses' => 'Admin\ReportController@doctors'
    ]);
    Route::get('/doctors/show-patient', [
        'as' => 'report.doctors.show_patient',
        'middleware' => ['admin'],
        'uses' => 'Admin\ReportController@showPatient'
    ]);

    Route::get('/reschedule/{id}', [
        'as' => 'report.reschedule',
        'middleware' => ['admin'],
        'uses' => 'Admin\ReportController@reschedule'
    ]);
    Route::post('/reschedule/store', [
        'as' => 'report.reschedule.store',
        'middleware' => ['admin'],
        'uses' => 'Admin\ReportController@storeReschedule'
    ]);

    Route::get('/attemtped-booking', [
        'as' => 'report.attempted_booking',
        'middleware' => ['admin'],
        'uses' => 'Admin\ReportController@attemptedBooking'
    ]);

    Route::get('/post-attemtped-booking', [
        'as' => 'report.post_attempted_booking',
        'middleware' => ['admin'],
        'uses' => 'Admin\ReportController@PostAttemptedBooking'
    ]);

});
Route::get('/reorder-department', [
    'as' => 'department.order',
    'middleware' => ['admin'],
    'uses' => 'Admin\DepartmentController@order'
]);

Route::get('/post-ordering-department', [
    'as' => 'department.post_order',
    'middleware' => ['admin'],
    'uses' => 'Admin\DepartmentController@postOrder'
]);

Route::get('/order-doctor', [
    'as' => 'doctor.order',
    'middleware' => ['admin'],
    'uses' => 'Admin\DoctorController@order'
]);

Route::get('/view-department-doctors/{id}', [
    'as' => 'doctor.view_list',
    'middleware' => ['admin'],
    'uses' => 'Admin\DoctorController@viewDeptDoctors'
]);

Route::get('/post-doctors-order', [
    'as' => 'doctor.post_order',
    'middleware' => ['admin'],
    'uses' => 'Admin\DoctorController@postOrder'
]);

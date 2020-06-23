@extends('admin.layout.master')

@section('content')
 <div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
              <h1 class="page-title">
                Booking Details
              </h1>
            </div>
            <div class="card-body">
                    <div class="row">
                          <div class="col-md-12">
                             @if ($errors->any())
                                <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                                </div>
                              @endif

                              @if(Session::has('success'))
                                        <div class="alert alert-success">
                                        {!! session('success') !!}
                                        </div>
                              @endif

                              <div class="row">
                                  <div class="col-md-4">
                                    <h3>  Patient Information </h3>
                                    <div class="col-md-12">Name : {{$bookingDetails->patient_name}}</div>
                                    <div class="col-md-12">Phone : {{$bookingDetails->patient_phone}}</div>
                                    <div class="col-md-12">City : {{$bookingDetails->patient_city}}</div>
                                    <div class="col-md-12">Booking Date : {{date('d-M-Y',strtotime($bookingDetails->booking_date))}}</div>
                                    <div class="col-md-12">Appointment Date : {{date('d-M-Y',strtotime($bookingDetails->date))}}</div>
                                    <div class="col-md-12">Gender : {{$bookingDetails->patient_gender}}</div>
                                    <div class="col-md-12">Age : {{$bookingDetails->patient_age}}</div>
                                    <div class="col-md-12">Timing : {{$bookingDetails->slot}}</div>
                                </div>

                                <div class="col-md-4">
                                    <h3>  Doctor Information </h3>
                                    <div class="col-md-4"><img src="{{$bookingDetails->picture}}" class="avatar avatar-xxl" height="200" width="200"></div>
                                    <div class="col-md-12">Name : {{$bookingDetails->doctor_name}}</div>
                                    <div class="col-md-12">Phone : {{$bookingDetails->dr_phone_no}}</div>
                                    <div class="col-md-12">Department : {{$bookingDetails->department_name}}</div>
                                </div>

                                <div class="col-md-4">
                                    <h3>  Payment Details </h3>

                                    <div class="col-md-12">Consultaion Fees : {{$bookingDetails->consultation_fees}}</div>
                                    <div class="col-md-12">Booking Charge : {{$bookingDetails->service_charge}}</div>
                                    <div class="col-md-12">Agent Charge : {{$bookingDetails->agent_charge}}</div>
                                    <div class="col-md-12">Paid Amount : {{$bookingDetails->amount_payable}}</div>
                                </div>

                              </div>
                          </div>


                    </div>
            </div>

        </div>
    </div>

</div>
@endsection

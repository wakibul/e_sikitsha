@extends('admin.layout.master')
@section('content')
 <div class="container card">
    <div class="row">
        <div class="col-12">

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



                 <h3>{{$doctor->name}}</h3>
                    @if(request('from'))
                    <h4>Showing Repport from {{date('d-F-Y',strtotime(request('from')))}} to {{date('d-F-Y',strtotime(request('to')))}}</h4>
                    @else
                    <h4>Showing Repport for {{date('d-F-Y')}}</h4>
                    @endif

                    @forelse ($bookingDetails as $booking)
                        @if($booking->date == date('Y-m-d'))
                        <div class="row">
                            <div class="col-md-12  alert alert-success">
                                <strong>{{$booking->patient_name}}</strong><br>
                                Transaction ID: {{$booking->transaction_id}} | Clinic : {{$booking->clinic_name}} |  Booking Time : {{date('d F Y h:i:s a',strtotime($booking->booking_date))}} <br>
                                Appointment Date : {{date('d F Y',strtotime($booking->date))}} | Appointment Time: {{$booking->slot}} <br>
                                Phone No : {{$booking->patient_phone}} : Email: {{$booking->patient_email}} : City: {{$booking->patient_city}} : Gender: {{$booking->patient_gender}} : Age: {{$booking->patient_age}}<br>
                                Total Amount : Rs. {{$booking->amount_payable}} | Amount Paid : Rs. {{$booking->fees_mode == 1?$booking->amount_payable:intval($booking->service_charge)+intval($booking->agent_charge)}}
                                | Booked By : {{$booking->user_type}}<br>
                                {!!$booking->fees_mode == 0?"<strong style='color:#ff0000'>Have to pay Rs. ".$booking->consultation_fees." in the clinic</strong>":''!!}
                                @if($booking->date >= date('Y-m-d'))
                                <a href="{{route('admin.report.reschedule',Crypt::encrypt($booking->id))}}" class="btn btn-sm btn-success">Reschedule</a> | <a href="#" class="btn btn-sm btn-success">Cancel</a>
                                @endif
                            </div>
                        </div>
                        @else

                        @if($booking->date > date('Y-m-d'))
                            @php
                                $class = "alert alert-warning";
                            @endphp
                        @else
                            @php
                                $class = "alert alert-danger";
                            @endphp
                        @endif
                        <div class="row">
                            <div class="col-md-12 {!! $class !!}">
                                <strong>{{$booking->patient_name}}</strong><br>
                                Transaction ID: {{$booking->transaction_id}} | Clinic : {{$booking->clinic_name}} |  Booking Time : {{date('d F Y h:i:s a',strtotime($booking->booking_date))}} <br>
                                Appointment Date : {{date('d F Y',strtotime($booking->date))}} | Appointment Time: {{$booking->slot}} <br>
                                Phone No : {{$booking->patient_phone}} : Email: {{$booking->patient_email}} : City: {{$booking->patient_city}} : Gender: {{$booking->patient_gender}} : Age: {{$booking->patient_age}}<br>
                                Total Amount : Rs. {{$booking->amount_payable}} | Amount Paid : Rs. {{$booking->fees_mode == 1?$booking->amount_payable:intval($booking->service_charge)+intval($booking->agent_charge)}}
                                | Booked By : {{$booking->user_type}}<br>
                                {!!$booking->fees_mode == 0?"<strong style='color:#ff0000'>Have to pay Rs. ".$booking->consultation_fees." in the clinic</strong>":''!!}
                                @if($booking->date >= date('Y-m-d'))
                                <a href="{{route('admin.report.reschedule',Crypt::encrypt($booking->id))}}" class="btn btn-sm btn-success">Reschedule</a>  | <a href="#" class="btn btn-sm btn-success">Cancel</a>
                                @endif
                            </div>
                        </div>

                        @endif
                    @empty
                        <div class="alert alert-danger">
                            The is no record found
                        </div>
                    @endforelse

                    </div>


                    </div>
            </div>

        </div>
    </div>

</div>
@endsection

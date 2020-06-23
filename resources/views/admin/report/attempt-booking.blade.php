@extends('admin.layout.master')
@section('content')
<div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="card-body">

              <form name="f1" action="{{route('admin.report.post_attempted_booking')}}" method="GET">
                <div class="row">

                    <div class="col-md-1">
                      From Date
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control datepicker" name="from" required value="{{request('from')}}">
                     </div>

                    <div class="col-md-1">
                       To Date
                    </div>
                    <div class="col-md-2">
                       <input type="text" class="form-control datepicker" name="to" required value="{{request('to')}}">
                    </div>

                    <div class="col-md-3">
                       <button type="submit" class="btn btn-primary">Filter</button>
                       <a href="{{route('admin.report.attempted_booking')}}" class="btn btn-danger">Clear</a>
                     </div>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>

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



                              <div class="row">

                 <div class="table-responsive">

                    <table class="table card-table table-vcenter text-nowrap">
                      <thead>
                        <tr>
                          <th class="w-1">Sl.</th>
                          <th>Patient Name</th>
                          <th>Patient Phone</th>
                          <th>Patient City</th>
                          <th>Patient Gender</th>
                          <th>Patient Age</th>
                          <th>Doctor Name</th>
                          <th>Clinic Name</th>
                          <th>Date of Appointment</th>
                          <th>Date of Booking</th>
                          <th>User Type</th>
                        </tr>
                      </thead>
                      <tbody>


                        @forelse($bookings as $key=>$booking)
                        <tr>
                          <td>
                            <span class="text-muted">{{$key+1}}</span></td>
                          <td><b>{{$booking->patient_name}}</b>
                          <td> <span class="tag tag-green">{{$booking->patient_phone}}</span></td>
                          <td> <span class="tag tag-red">{{$booking->patient_city}}</span></td>
                          <td> {{$booking->patient_gender}}</td>
                          <td> <span class="tag tag-red">{{$booking->patient_age}}</span></td>
                          <td> {{$booking->doctor->name ?? 'N/A'}}</td>
                          <td> {{$booking->clinic_name->name ?? 'N/A'}}</td>
                          <td> {{date('d-M-Y',strtotime($booking->date))}}</td>
                          <td> {{date('d-M-Y h:i:s a',strtotime($booking->created_at))}}</td>
                          <td> {{$booking->user_type}}</td>
                        </tr>
                        @empty
                        <tr><td colspan="9">There is no record</td></tr>
                        @endforelse
                      </tbody>
                    </table>
                    {{$bookings->links()}}
                  </div>
                                  </div>

                              </div>
                          </div>


                    </div>
            </div>

        </div>
    </div>


@endsection

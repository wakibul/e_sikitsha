@extends('admin.layout.master')
@section('content')
<div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="card-body">

              <form name="f1" action="{{route('admin.report.filter')}}" method="GET">
                <div class="row">
                    <div class="col-md-2">
                       Doctor Name
                    </div>
                    <div class="col-md-3">
                       <select name="doctor" class="form-control" required>
                           <option value="">Select</option>
                           <option value="all" {{("all" == request('doctor')) ? 'selected':'' }}>All</option>
                           @foreach($doctors as $key=>$value)
                           <option value="{{$value->id}}" {{($value->id == request('doctor')) ? 'selected':'' }}>
                             {{$value->name}}
                            </option>
                           @endforeach
                       </select>
                    </div>
                    <div class="col-md-2">
                       Booking Date
                    </div>
                    <div class="col-md-3">
                       <input type="text" class="form-control datepicker" name="date" required value="{{request('date')}}">
                    </div>

                    <div class="col-md-2">
                       <button type="submit" class="btn btn-primary">Filter</button>
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
                              <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                      <thead>
                        <tr>
                          <th class="w-1">Sl.</th>
                          <th>Transaction No</th>
                          <th>Appointment Date</th>
                          <th>Slot</th>
                          <th>Doctor Name</th>
                          <th>Doctor Phone no</th>
                          <th>Patient Name</th>
                          <th>Patient Email</th>
                          <th>Amount Paid</th>
                        </tr>
                      </thead>
                      <tbody>


                        @forelse($appointments as $key=>$appointment)
                        <tr>
                          <td><span class="text-muted">{{$key+1}}</span></td>
                          <td>{{$appointment->transaction_id}}</td>
                          <td>
                          {{date('d-M-Y',strtotime($appointment->date))}}
                          </td>
                          <td>
                           {{$appointment->slot}}
                          </td>
                          <td>
                          {{$appointment->doctor_name}}
                          </td>

                          <td>{{$appointment->dr_phone_no}}</td>
                          <td>
                          {{$appointment->patient_name}}
                          </td>

                          <td>
                            {{$appointment->patient_email}}
                            </td>

                          <!-- <td>
                            <span class="status-icon bg-success"></span> Paid
                          </td> -->
                          <td>{{$appointment->amount_payable}}</td>
                          <td class="text-right">
                            <a href="{{route('admin.booking-details',Crypt::encrypt($appointment->id))}}" class="btn btn-primary btn-sm">View</a>
                            <a href="{{route('admin.booking.delete',Crypt::encrypt($appointment->id))}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete?')">Delete</a>
                          </td>
                        </tr>
                        @empty
                        <tr><td colspan="9">There is no record</td></tr>
                        @endforelse

                      </tbody>
                    </table>
                  </div>

                              </div>
                          </div>


                    </div>
            </div>

        </div>
    </div>

</div>
@endsection

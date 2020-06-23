@extends('admin.layout.master')

@section('content')
 <div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
              <h1 class="page-title">
                Franchise Booking
              </h1>
            </div>
            <div class="card-body">
                    <div class="row">
                          <div class="col-md-12 col-lg-12">
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
                            <form name="franchise" action="{{route('admin.franchise.filter_booking',request()->id)}}" method="GET">
                            @csrf
                            <div class="form-group">
                               <h3> Filter By Booking Date </h3>
                            <div class="row">
                                  <div class="col-md-1">From Date</div>
                                  <div class="col-md-2">
                                    <input type="text" name="from_date" class="form-control datepicker" readOnly="true" value="{{Request('from_date')}}" required>
                                  </div>

                                  <div class="col-md-1">To Date</div>
                                  <div class="col-md-2">
                                    <input type="text" name="to_date" class="form-control datepicker"  readOnly="true"  value="{{Request('to_date')}}" required>
                                  </div>

                                  <div class="col-md-2">
                                    <button type="submit" class="btn btn-success">Filter </button>
                                  </div>
                             </div>
                             </div>
                            </form>
                          </div>
                    </div>
            </div>
            @if(isset($appointments))
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
              <a href="{{route('admin.booking-details',Crypt::encrypt($appointment->id))}}" target="_blank" class="btn btn-primary btn-sm">View</a>
            </td>
          </tr>
          @empty
          <tr><td colspan="9">There is no record</td></tr>
          @endforelse

        </tbody>
      </table>
    </div>

        </div>
        @endif
    </div>

</div>
@endsection

@extends('franchise.layout.master')

@section('content')
 <div class="container">
            <div class="page-header">
              <h1 class="page-title">
                Dashboard
              </h1>
            </div>
            <div class="row row-cards">
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">

                  <div class="h1 m-0">{{$bookingDetailCount}}</div>
                    <div class="text-muted mb-4">Total Bookings</div>
                  </div>
                </div>
              </div>

              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">

                  <div class="h1 m-0">Rs. {{auth()->user()->amount}}</div>
                    <div class="text-muted mb-4">Balance</div>
                  </div>
                </div>
              </div>

            </div>



                @if(isset($appointments))
                <div class="row row-cards row-deck">
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
                  <a href="{{route('franchise.booking_details',Crypt::encrypt($appointment->id))}}" target="_blank" class="btn btn-primary btn-sm">View</a>
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
@endsection

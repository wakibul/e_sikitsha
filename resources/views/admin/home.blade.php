@extends('admin.layout.master')

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

                    <div class="h1 m-0">{{todaysBookings()}}</div>
                    <div class="text-muted mb-4">Todays Booking</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">

                    <div class="h1 m-0">{{totalBookings()}}</div>
                    <div class="text-muted mb-4">Total Bookings</div>
                  </div>
                </div>
              </div>

              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{totalDoctors()}}</div>
                    <div class="text-muted mb-4">Total Doctors</div>
                  </div>
                </div>
              </div>

              <div class="col-6 col-sm-4 col-lg-6">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div id="piechart_3d" style="width: 500px; height: 300px;"></div>
                  </div>
                </div>
              </div>





            </div>

            <div class="row row-cards row-deck">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Bookings (Recent 20 bookings)</h3>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                      <thead>
                        <tr>
                          <th class="w-1">Sl.</th>
                          <th>Transaction No</th>
                          <th>Appointment Date</th>
                          <th>Email</th>
                          <th>Slot</th>
                          <th>Doctor Name</th>
                          <th>Doctor Phone no</th>
                          <th>Patient Name</th>
                          <th>Amount Paid</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                        $appointments = bookingDetails();
                        @endphp

                        @foreach($appointments as $key=>$appointment)
                        <tr>
                          <td><span class="text-muted">{{$key+1}}</span></td>
                          <td>{{$appointment->transaction_id}}</td>
                          <td>
                          {{date('d-M-Y',strtotime($appointment->date))}}
                          </td>
                          <td>
                            {{$appointment->patient_email}}
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

                          <!-- <td>
                            <span class="status-icon bg-success"></span> Paid
                          </td> -->
                          <td>{{$appointment->amount_payable}}</td>
                          <td class="text-right">
                            <a href="{{route('admin.booking-details',Crypt::encrypt($appointment->id))}}" class="btn btn-primary btn-sm">View</a>
                          </td>
                        </tr>
                        @endforeach

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection

@section('js')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Bookings'],
          ['Total Doctors',     {{totalDoctors()}}],
          ['Customer Booking',      {{guestBooking()}}],
          ['Todays booking', {{todaysBookings()}}]
        ]);

        var options = {
          title: 'Booking Average',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>

@endsection

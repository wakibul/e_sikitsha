@extends('admin.layout.master')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.12/css/bootstrap/zebra_datepicker.css">
@endsection

@section('content')
<div class="container card">
  <div class="row">
    <div class="col-12">
      <div class="page-header">
        <h1 class="page-title">
          View Availability for <b>{{strtoupper(strtolower($doctor->name))}}</b>
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
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Clinic</th>
                  <th>Date</th>
                  <th>Timing</th>
                  <th>Available Seat</th>
                  <th>Booked Seat</th>
                  <th>Is Available</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                @forelse($availables as $key=>$available)
                <tr>
                  <td>{{ $key+ 1 + ($availables->perPage() * ($availables->currentPage() - 1)) }}</td>
                  <td>{{$available->schedule->clinic->name}}</td>
                  <td>{{date('d-M-Y',strtotime($available->date))}}</td>
                  <td>{{date('h:i a',strtotime($available->schedule->starttime))}} - {{date('h:i a',strtotime($available->schedule->endtime))}}</td>
                  <td>{{$available->available_seat}}</td>
                  <td>{{$available->booked_seat}}</td>
                  <td>@if($available->status == 1) <span class="badge badge-success">Available</span> @else <span class="badge badge-warning">Not Available</span> @endif</td>
                  <td>@if($available->status == 1) <a href="{{route('admin.doctor.make_day_unavailable',Crypt::encrypt($available->id))}}" class="btn btn-danger btn-sm" onclick="return confirmMsg(' make it unavailable')">Make Unavailable</a> @else  <a href="{{route('admin.doctor.make_day_available',Crypt::encrypt($available->id))}}" class="btn btn-success  btn-sm" onclick="return confirmMsg(' make it available')">Make Available</a> @endif

                   @if($available->schedule->remarks == "")
                   <a href="{{route('admin.doctor.add_remarks',[$doctor->slug,Crypt::encrypt($available->clinic_id)])}}" class="btn btn-primary btn-sm">Remarks</a>
                   @else
                   <a href="{{route('admin.doctor.remove_remarks',[$doctor->id,Crypt::encrypt($available->clinic_id)])}}" class="btn btn-danger btn-sm" onclick="return confirmMsg(' remove the remark?')">Remove Remark</a>
                   @endif
                </td>
                </tr>
                @empty
                <tr>
                  <td colspan="9" class="alert alert-danger">
                    No record available
                  </td>
                </tr>
                @endforelse

              </tbody>
            </table>
            {{$availables->links()}}
          </div>
        </div>
      </div>

    </div>
  </div>

</div>

<!-- Modal -->

@endsection

@section('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.12/zebra_datepicker.src.js"></script>
<script type="text/javascript">
  $('.start').click(function() {
    var id = $(this).attr("data-id");
    $('#doctor_id').val(id);
    $('#myModal').modal('show');

  })

  $('#from_date').Zebra_DatePicker({
    view: 'years'
  });

function confirmMsg(msg){
  var x = confirm("Are you sure to"+msg);
  if(x)
    return true;
  else
    return false;
}
</script>

@endsection

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
          Doctor Clinics ({{$doctor->name}})
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
            <form action="{{route('admin.doctor.store_fees',Crypt::encrypt($doctor->id))}}" action="" method="post">
              @csrf
            <table class="table">
            @forelse($scheduleMaster as $key=>$val)
            <tr>
                <td>{{$val->clinic->name}} ({{$val->clinic->region->name}})</td>
                <td>Doctor Fees <input type="number" name="doctor_fees[]" class="form-control" required>
                <input type="hidden" name="clinic_id[]" class="form-control" value="{{$val->clinic->id}}">
                </td>
                <td>Booking Fees <input type="number" name="booking_charge[]" class="form-control" required></td>
                <td>Agent Fees <input type="number" name="agent_charge[]" class="form-control" required></td>
            </tr>
            @empty
            <tr><td colspan="4">
            No clinics found
            </td></tr>
            
            @endforelse
            <tr>
                <td><button type="submit" class="btn btn-success">Submit</button></td>
            </tr>   
            </table>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>

<!-- Modal -->
<form name="f1" action="{{route('admin.doctor.make_available')}}" method="post">
  @csrf
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <label class="col-md-3">From Date</label>
            <div class="col-md-5"><input type="text" id="from_date" name="from_date" class="form-control" placeholder="{{date('Y-m-d')}}">
              <input type="hidden" id="doctor_id" name="doctor_id" readonly="true">
            </div>
            <div class="col-md-2"><button type="submit" class="btn btn-success">Make Available</button></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>
</form>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.13/zebra_datepicker.min.js"></script>

<script type="text/javascript">
  $('.start').click(function() {
    var id = $(this).attr("data-id");
    $('#doctor_id').val(id);
    $('#myModal').modal('show');

  })
</script>

@endsection
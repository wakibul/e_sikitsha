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
          Add a remark for <b>{{strtoupper(strtolower($doctor->name))}}</b> for the clinic <strong>{{strtoupper(strtolower($clinic->name))}}</strong>
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
        <form class="form-horizontal" action="{{route('admin.doctor.add_remarks.store')}}" method="POST">
            @csrf
              <label>Remarks</label>
              <input type="hidden" name="clinic_id" value="{{$clinic->id}}">
              <input type="hidden" name="doctor_id" value="{{$doctor->id}}">
              <textarea name="remarks" class="form-control" rows="5" required="true"></textarea>
              <button type="submit" class="btn btn-success">Add remark</button>
        </form>
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
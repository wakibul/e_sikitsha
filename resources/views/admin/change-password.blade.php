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
          Change Password
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
          <div class="col-md-6">
        <form class="form-horizontal" action="{{route('admin.change_password.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        Current Password
                    </div>
                    <div class="col-md-8">
                        <input type="password" name="old_password" class="form-control" required>
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        New Password
                    </div>
                    <div class="col-md-8">
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                    Confirm Password
                    </div>
                    <div class="col-md-8">
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        
                    </div>
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-primary">Change Password </button>
                    </div>
                </div>
              </div>
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

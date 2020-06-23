@extends('admin.layout.master')
@section('css')
<style>
.datepicker{
  width: 200px !important;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.12/css/bootstrap/zebra_datepicker.css">
@endsection

@section('content')
<div class="container card">
  <div class="row">
    <div class="col-12">
      <div class="page-header">
        <h1 class="page-title">
          Doctor Master
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
                  <th>Name</th>
                  <th>Department</th>
                  <th>Home city</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($doctors as $key=>$doctor)
                <tr>
                  <td>{{ $key+ 1 + ($doctors->perPage() * ($doctors->currentPage() - 1)) }}</td>
                  <td>{{$doctor->name}}</td>
                  <td>{{$doctor->department->name}}</td>
                  <td>{{$doctor->current_city}}</td>
                  <td><a href="{{route('admin.doctor.edit',$doctor->slug)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                  <a href="{{route('admin.doctor.delete',Crypt::encrypt($doctor->id))}}" onclick="return conf()" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                  @php
                  $feesCount = checkInitDoctorCharges($doctor->id);
                  @endphp
                  @if($feesCount > 0)
                  <a href="{{route('admin.doctor.edit-fees',$doctor->slug)}}" class="btn btn-success btn-sm "><i class="fa fa-edit"></i> Fees</a>
                  @else
                  <a href="{{route('admin.doctor.add-fees',$doctor->slug)}}" class="btn btn-success btn-sm "> <i class="fa fa-plus"></i> Fees</a>
                  @endif
                  <a href="{{route('admin.doctor.view_schedule',$doctor->slug)}}" class="btn btn-primary btn-sm "><i class="fa fa-edit"></i> Schedule</a>
                  @if(count($doctor->available)==0)
                  <a href="javascript:void(0)" class="btn btn-success btn-sm start" data-id="{{$doctor->id}}"><i class="fa fa-hourglass-start"></i> Publish</a>
                  @else
                    <a href="{{route('admin.doctor.view_available',$doctor->slug)}}" class="btn btn-warning btn-sm"><i class="fa fa-calendar"></i> View</a>
                  @endif
                  @php
                  $notes = DB::table('notes')->where('doctor_id',$doctor->id)->count();
                  @endphp

                  @if($notes == 0)
                  <a href="{{route('admin.doctor.add_note',$doctor->slug)}}" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Add a note</a>
                  @else
                  <a href="{{route('admin.doctor.remove_note',Crypt::encrypt($doctor->id))}}" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i> Remove note</a>
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
            {{$doctors->links()}}
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
            <div class="col-md-5"><input type="text" id="from_date" name="from_date" class="form-control datepicker" placeholder="{{date('Y-m-d')}}">
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

<script type="text/javascript">
  $('.start').click(function() {
    var id = $(this).attr("data-id");
    //alert(id);
    $('#doctor_id').val(id);
    $('#myModal').modal('show');

  })
</script>

@endsection

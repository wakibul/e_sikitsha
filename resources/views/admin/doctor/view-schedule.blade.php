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
         Schedule ({{$doctor->name}})
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
            <a href="{{route('admin.doctor.add_more_schedule',$doctor->slug)}}" class="btn btn-success">Add More Schedule</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Clinic Name</th>
                        <th>Days</th>
                        <th>Slot</th>
                        <th>Maximum  Booking</th>
                    </tr>    
                </thead>
                <tbody>
                @forelse($schedule as $key=>$val)
                <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$val->clinic->name}}</td>
                        <td>{{$val->days}}</td>
                        <td>{{$val->slot}}</td>
                        <td>{{$val->max_booking}}</td>
                        <td><a href="{{route('admin.doctor.edit_schedule',Crypt::encrypt($val->id))}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a> <a href="{{route('admin.doctor.delete_schedule',Crypt::encrypt($val->id))}}" class="btn btn-danger btn-sm" onclick="return conf()"> <i class="fa fa-trash"></i> Delete</a></td>
                </tr> 
                @empty
                <tr>
                    <td colspan="4">There is no schedule</td>
                </tr>       
                @endforelse
                </tbody>
            </table>

          </div>
        </div>
      </div>

    </div>
  </div>

</div>

<!-- Modal -->

@endsection

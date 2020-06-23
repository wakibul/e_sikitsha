@extends('admin.layout.master')
@section('content')
<div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="card-body">

              <form name="f1" action="{{route('admin.report.doctors')}}" method="GET">
                <div class="row">

                    <div class="col-md-1">
                      From Date
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control datepicker" name="from" required value="{{request('from')}}">
                     </div>

                    <div class="col-md-1">
                       To Date
                    </div>
                    <div class="col-md-2">
                       <input type="text" class="form-control datepicker" name="to" required value="{{request('to')}}">
                    </div>

                    <div class="col-md-3">
                       <button type="submit" class="btn btn-primary">Filter</button>
                       <a href="{{route('admin.report.doctors')}}" class="btn btn-danger">Clear</a>
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
                          <th>Doctor Name</th>
                          <th>Book</th>
                          <th>Visit</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>


                        @forelse($doctors as $key=>$doctor)
                        <tr>
                          <td>

                            <span class="text-muted">{{$key+1}}</span></td>
                          <td><h4>{{$doctor->name}}</h4>
                          <td> <span class="tag tag-green">{{$doctor->booking_count}}</span></td>
                          <td> <span class="tag tag-red">{{$doctor->visit_count}}</span></td>

                          <td>
                            @if(request('from') && request('to'))
                            <a href="{{route('admin.report.doctors.show_patient',["doctor_id"=>$doctor->id,"from"=>request('from'),"to"=>request('to')])}}" class="btn btn-primary">Show Patient</a>
                            @else
                            <a href="{{route('admin.report.doctors.show_patient',["doctor_id"=>$doctor->id])}}" class="btn btn-primary">Show Patient</a>
                            @endif 
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

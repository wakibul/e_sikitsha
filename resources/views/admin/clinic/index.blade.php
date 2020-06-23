@extends('admin.layout.master')

@section('content')
 <div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
              <h1 class="page-title">
                Clinic Master
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
                                <th>City / Region</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Clinic Type</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse($clinics as $key=>$clinic)
                              <tr>
                                <td>{{ $key+ 1 + ($clinics->perPage() * ($clinics->currentPage() - 1)) }}</td>
                                <td>{{$clinic->name}}</td>
                                <td>{{$clinic->region->name}}</td>
                                <td>{{$clinic->address}}</td>
                                <td>{{$clinic->phone}}</td>
                                <td>{{$clinic->latitude}}</td>
                                <td>{{$clinic->longitude}}</td>
                                <td>@if($clinic->clinic_type == 2)
                                    Clinc
                                    @else
                                    Home
                                    @endif

                                 </td>
                                <td><a href="{{route('admin.clinic.edit',Crypt::encrypt($clinic->id))}}">Edit <i class="fa fa-edit"></i></a> <a href="{{route('admin.clinic.delete',Crypt::encrypt($clinic->id))}}" onclick="return conf()" onclick="return conf()">Delete <i class="fa fa-trash"></i></a></td>

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
                          {{$clinics->links()}}

                        </div>
                    </div>
            </div>            

        </div>
    </div>    
                      
</div>
@endsection

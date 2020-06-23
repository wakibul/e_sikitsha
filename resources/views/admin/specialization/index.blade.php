@extends('admin.layout.master')

@section('content')
 <div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
              <h1 class="page-title">
                Specialzation Master
              </h1>
            </div>
            <div class="card-body">
                    <div class="row">
                          <div class="col-md-6">
                             @if(session()->has('error'))
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
                            <form name="city" action="{{route('admin.specialization.store')}}" method="POST">
                            @csrf
                            <div class="row">
                           
                                  <div class="col-md-4">Name</div>
                                  <div class="col-md-6">
                                    <input type="text" name="name" class="form-control">
                                  </div>
                                  <div class="col-md-2">
                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                  </div>
                               
                             </div>   
                            </form> 
                          </div>

                          <div class="col-md-6">
                                <table class="table">
                                  <thead>
                                    <tr>
                                      <th>#</th>
                                      <th>Specialization</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @forelse($specializations as $key=>$specialization)
                                    <tr>
                                      <td>{{ $key+ 1 + ($specializations->perPage() * ($specializations->currentPage() - 1)) }}</td>
                                      <td>{{$specialization->name}}</td>
                                    
                                      <td>
                                          <div class="btn-group">
                                            <a href="{{route('admin.city.edit',Crypt::encrypt($specialization->id))}}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                                              <a href="{{route('admin.city.delete',Crypt::encrypt($specialization->id))}}" class="btn btn-xs btn-danger" onclick="return conf()"><i class="fa fa-trash"></i></a>
                                          </div>
                                      </td>
                                    </tr>
                                    @empty
                                    <tr>
                                    <td colspan="3">No data</td>
                                    </tr>
                                    @endforelse
                                    
                                  </tbody>
                                </table>
                                <span class="pull-right"> {{ $specializations->links()}}</span>
                        </div>  
     
                    </div>
            </div>            

        </div>
    </div>    
                      
</div>
@endsection

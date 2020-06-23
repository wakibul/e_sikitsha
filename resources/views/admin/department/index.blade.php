@extends('admin.layout.master')

@section('content')
 <div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
              <h1 class="page-title">
                Department Master
              </h1>
            </div>
            <div class="card-body">
                    <div class="row">
                          <div class="col-md-6">
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
                            <form name="city" action="{{route('admin.department.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row form-group">
                                  <div class="col-md-4">Name</div>
                                  <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" required>
                                  </div>
                             </div> 

                             <div class="row form-group">
                                  <div class="col-md-4">Picture</div>
                                  <div class="col-md-6">
                                    <input type="file" name="picture" class="form-control" required>
                                  </div>
                             </div>   

                             <div class="row form-group">
                                  <div class="col-md-6">
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
                                      <th>Department</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @forelse($departments as $key=>$department)
                                    <tr>
                                      <td>{{ $key+ 1 + ($departments->perPage() * ($departments->currentPage() - 1)) }}</td>
                                      <td>{{$department->name}}</td>
                                    
                                      <td>
                                          <div class="btn-group">
                                            <a href="{{route('admin.department.edit',Crypt::encrypt($department->id))}}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                                              <a href="{{route('admin.department.delete',Crypt::encrypt($department->id))}}" class="btn btn-xs btn-danger" onclick="return conf()"><i class="fa fa-trash"></i></a>
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
                                <span class="pull-right"> {{ $departments->links()}}</span>
                        </div>  
     
                    </div>
            </div>            

        </div>
    </div>    
                      
</div>
@endsection

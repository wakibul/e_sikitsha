@extends('admin.layout.master')

@section('content')
 <div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
              <h1 class="page-title">
                Edit {{$department->name}} Department 
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
                            <form name="city" action="{{route('admin.department.update',Crypt::encrypt($department->id))}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row form-group">
                                  <div class="col-md-4">Name</div>
                                  <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" required value="{{$department->name}}">
                                  </div>
                             </div> 

                             <div class="row form-group">
                                  <div class="col-md-4">Picture</div>
                                  <div class="col-md-6">
                                    <input type="file" name="picture" class="form-control">
                                  </div>
                             </div>   

                             <div class="row form-group">
                                  <div class="col-md-6">
                                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                  </div>
                             </div> 
                            </form> 
                          </div>

                           
     
                    </div>
            </div>            

        </div>
    </div>    
                      
</div>
@endsection

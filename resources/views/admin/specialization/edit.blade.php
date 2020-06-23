@extends('admin.layout.master')

@section('content')
 <div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
              <h1 class="page-title">
                City Master
              </h1>
            </div>
            <div class="card-body">
                    <div class="row">
                          <div class="col-md-6 col-lg-4">
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
                            <form name="city" action="{{route('admin.city.update',CRypt::encrypt($city->id))}}" method="POST">
                            @csrf
                            <div class="row">
                               
                                  <div class="col-md-4">Name</div>
                                  <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" value="{{$city->name}}">
                                  </div>
                                  <div class="col-md-2">
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

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
                            <form name="city" action="{{route('admin.clinic.update',Crypt::encrypt($clinic->id))}}" method="POST">
                            @csrf
                            <div class="form-group">
                            <div class="row">
                                  <div class="col-md-2">Name</div>
                                  <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" value="{{$clinic->name}}">
                                  </div>
                             </div>
                             </div>


                             <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">City</div>
                                  <div class="col-md-6">
                                    <select name="region_id" class="form-control">
                                      <option value="">Select</option>
                                      @foreach($cities as $city)
                                      <option value="{{$city->id}}" @if($clinic->region_id == $city->id) selected @endif>{{$city->name}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                             </div>
                           </div>


                            <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Address</div>
                                  <div class="col-md-6">
                                    <textarea name="address" class="form-control">{{$clinic->address}}</textarea>
                                  </div>
                             </div>
                           </div>

                           <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Phone No</div>
                                  <div class="col-md-6">
                                    <input type="text" name="phone" class="form-control" value="{{$clinic->phone}}">
                                  </div>
                             </div>
                           </div>

                           <div class="form-group">
                            <div class="row">
                                 <div class="col-md-2">Mobile (SMS) No</div>
                                 <div class="col-md-6">
                                   <input type="text" name="mobile_no" class="form-control" value="{{$clinic->mobile_no}}">
                                 </div>
                            </div>
                          </div>

                            <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Latitude</div>
                                  <div class="col-md-6">
                                    <input type="text" name="latitude" class="form-control" value="{{$clinic->latitude}}">
                                  </div>
                             </div>
                           </div>

                           <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Longitude</div>
                                  <div class="col-md-6">
                                    <input type="text" name="longitude" class="form-control" value="{{$clinic->longitude}}">
                                  </div>
                             </div>
                           </div>

                           <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Clinic Type</div>
                                  <div class="col-md-6">
                                    <select name="clinic_type" class="form-control">
                                      <option value="">Select</option>
                                      <option value="1" @if($clinic->clinic_type == 1) selected @endif>Home</option>
                                      <option value="2"  @if($clinic->clinic_type == 2) selected @endif>Clinic</option>
                                    </select>
                                  </div>
                             </div>
                           </div>

                           <div class="form-group">
                             <div class="row">

                                  <div class="col-md-6 col-md-offset-4">
                                   <button type="submit" class="btn btn-primary">Update</button>
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
@endsection

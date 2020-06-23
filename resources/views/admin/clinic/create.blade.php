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
                            <form name="city" action="{{route('admin.clinic.store')}}" method="POST">
                            @csrf
                            <div class="form-group">
                            <div class="row">
                                  <div class="col-md-2">Name</div>
                                  <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" value="">
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
                                      <option value="{{$city->id}}">{{$city->name}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                             </div>
                           </div>


                            <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Address</div>
                                  <div class="col-md-6">
                                    <textarea name="address" class="form-control"></textarea>
                                  </div>
                             </div>
                           </div>

                           <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Phone No</div>
                                  <div class="col-md-6">
                                    <input type="text" name="phone" class="form-control">
                                  </div>
                             </div>
                           </div>

                           <div class="form-group">
                            <div class="row">
                                 <div class="col-md-2">Mobile (SMS) No</div>
                                 <div class="col-md-6">
                                   <input type="text" name="mobile_no" class="form-control">
                                 </div>
                            </div>
                          </div>

                            <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Latitude</div>
                                  <div class="col-md-6">
                                    <input type="text" name="latitude" class="form-control">
                                  </div>
                             </div>
                           </div>

                           <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Longitude</div>
                                  <div class="col-md-6">
                                    <input type="text" name="longitude" class="form-control">
                                  </div>
                             </div>
                           </div>

                           <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Clinic Type</div>
                                  <div class="col-md-6">
                                    <select name="clinic_type" class="form-control">
                                      <option value="">Select</option>
                                      <option value="1">Home</option>
                                      <option value="2">Clinic</option>
                                    </select>
                                  </div>
                             </div>
                           </div>

                           <div class="form-group">
                             <div class="row">

                                  <div class="col-md-6 col-md-offset-4">
                                   <button type="submit" class="btn btn-primary">Submit</button>
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

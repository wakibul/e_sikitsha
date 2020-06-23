@extends('admin.layout.master')

@section('content')
 <div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
              <h1 class="page-title">
               Add Franchise
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
                            <form name="franchise" action="{{route('admin.franchise.store')}}" method="POST">
                            @csrf
                            <div class="form-group">
                            <div class="row">
                                  <div class="col-md-2">Name</div>
                                  <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" value="{{old('name')}}" required>
                                  </div>
                             </div>
                             </div>


                             <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">City</div>
                                  <div class="col-md-6">
                                    <select name="city" class="form-control" required>
                                      <option value="">Select</option>
                                      @foreach($cities as $city)
                                      <option value="{{$city->id}}" @if(old('city') == $city->id) selected @endif>{{$city->name}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                             </div>
                           </div>

                           <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Email</div>
                                  <div class="col-md-6">
                                    <input name="email" type="email" class="form-control" value="{{old('email')}}">
                                  </div>
                             </div>
                           </div>

                           <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Password</div>
                                  <div class="col-md-6">
                                    <input name="password" type="password" class="form-control" required>
                                  </div>
                             </div>
                           </div>

                           <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Retype Password</div>
                                  <div class="col-md-6">
                                    <input name="password_confirmation" type="password" class="form-control" required>
                                  </div>
                             </div>
                           </div>


                            <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Address</div>
                                  <div class="col-md-6">
                                    <textarea name="address" class="form-control">{{old('address')}}</textarea>
                                  </div>
                             </div>
                           </div>

                           <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Phone No</div>
                                  <div class="col-md-6">
                                    <input type="text" name="phone" class="form-control" required value="{{old('phone')}}">
                                  </div>
                             </div>
                           </div>

                           <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Amount</div>
                                  <div class="col-md-6">
                                    <input type="number" name="amount" class="form-control" required value="{{old('amount')}}">
                                  </div>
                             </div>
                           </div>



                           <div class="form-group">
                             <div class="row">
                                 <div class="col-md-3"></div>
                                  <div class="col-md-3">
                                   <button type="submit" class="btn btn-success">Add Franchise</button>
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

  @extends('world.layout.master')
      <!-- slider -->

  @section('content')

  <section class="doctors-block">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center appointment-block" style="margin: 0 auto;">
            <h1> Change Password</h1>

  </div>

          </div>
        </div>
      </div>
    </section>

  <section id="recomended_doctors" class="pb-5">
  <form action="{{route('franchise.login.post_change_password',$user_id)}}" method="POST">
  @csrf
  <div class="container">

  <div class="row ">

    <div class="col-md-5">
                <div class="card ">
                  <div class="card-status bg-blue"></div>
                  <div class="card-header">
                    <h3 class="card-title">Change Password</h3>
                    <div class="card-options">
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

                    @if(Session::has('error'))
                            <div class="alert alert-danger">
                            {!! session('error') !!}
                            </div>
                    @endif
                      <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                       <div class="row">
                            <div class="col-md-12">
                                <p>New Password</p>
                                <input type="password" name="password" class="form-control">
                            </div>
                       </div>     

                       <div class="row">
                            <div class="col-md-12">
                                <p>Confirm Password</p>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                       </div> 
                    </div>
                  </div>
                  <div class="card-body">
                  <div class="row ">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                   </div>     
                  </div>
                </div>
              </div>
    </div>
  </div>
  </div>
  </form>
  </section>
  @endsection

  @section('js')
  @endsection


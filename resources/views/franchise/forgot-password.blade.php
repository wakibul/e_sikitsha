  @extends('world.layout.master')
      <!-- slider -->

  @section('content')

  <section class="doctors-block">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center appointment-block" style="margin: 0 auto;">
            <h1> Forgot Password</h1>

  </div>

          </div>
        </div>
      </div>
    </section>

  <section id="recomended_doctors" class="pb-5">
  <form action="{{route('franchise.login.send_otp')}}" method="POST">
  @csrf
  <div class="container">

  <div class="row ">

    <div class="col-md-5">
                <div class="card ">
                  <div class="card-status bg-blue"></div>
                  <div class="card-header">
                    <h3 class="card-title">Find Your Account</h3>
                    <div class="card-options">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                    </div>
                    @endif

                    @if(Session::has('error'))
                            <div class="alert alert-danger" style="font-size:12px">
                            {!! session('error') !!}
                            </div>
                    @endif

                    @if(Session::has('success'))
                            <div class="alert alert-success">
                            {!! session('success') !!}
                            </div>
                    @endif
                      <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                      <p style="font-size:12px;color:#000">Please enter your phone number to search for your account.</p>
                        <input type="text" maxlength="10" required name="phone" class="form-control" onkeyup="this.value=this.value.replace(/[^0-9 -]/g,'')">
                    </div>
                  </div>
                  <div class="card-body">
                  <div class="row ">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            <button type="reset" class="btn btn-default btn-sm">Clear</button>
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


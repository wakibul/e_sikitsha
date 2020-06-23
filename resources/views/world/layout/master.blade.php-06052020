<!DOCTYPE html>
<html lang="en">
  <head>
    @include('world.layout.head')
    @yield('css')
    <link rel="stylesheet" href="{{asset('public/css/compiled-4.8.10.min.css')}}">
    <style type="text/css">
    #modalLRForm{
      z-index: 999999 !important;
    }  
    </style>
  </head>
<body>

 @include('world.layout.header')
    <!-- slider -->
@yield('content')



<!-- Modal -->
<!--Modal: Login / Register Form-->

<div class="modal fade" id="modalLRForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog cascading-modal" role="document">
    <!--Content-->
    <div class="modal-content">

      <!--Modal cascading tabs-->
      <div class="modal-c-tabs">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs md-tabs tabs-2 light-blue darken-3" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#panel7" role="tab"><i class="fa fa-user mr-1"></i>
              Login</a>
          </li>
         {{--  <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#panel8" role="tab"><i class="fa fa-user-plus mr-1"></i>
              Register</a>
          </li> --}}
        </ul>

        <!-- Tab panels -->
        <div class="tab-content">
          <!--Panel 7-->
          <form method="POST" action="{{ route('login') }}">
              @csrf
          <div class="tab-pane fade in show active" id="panel7" role="tabpanel">
              @if ($errors->has('email'))
                  <div class="alert alert-danger" id="danger-alert">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                      <strong>{{ $errors->first('email') }}</strong>
                  </div>
              @endif
            <!--Body-->
            <div class="modal-body mb-1">
              <div class="md-form form-sm mb-5">
                <input type="text" name="email" id="modalLRInput10" class="form-control form-control-sm validate" placeholder="Your email / phone" required value="{{old('email')}}">
              </div>

              <div class="md-form form-sm mb-4">
                <input type="password" name="password" id="modalLRInput11" placeholder="Your Password" class="form-control form-control-sm validate" required>
              </div>
              <div class="text-center mt-2">
                <button class="btn btn-info" type="submit">Log in <i class="fa fa-sign-in ml-1"></i></button>
              </div>
            </div>
            <!--Footer-->
            <div class="modal-footer">
              <div class="options text-center text-md-right mt-1">
                {{-- <p>Forgot <a href="#" class="blue-text">Password?</a></p> --}}
              </div>
              <button type="button" class="btn btn-outline-info waves-effect ml-auto" data-dismiss="modal">Close</button>
            </div>

          </div>
          </form>
          <!--/.Panel 7-->

          <!--Panel 8-->

          <!--/.Panel 8-->
        </div>

      </div>
    </div>
    <!--/.Content-->
  </div>
</div>

<!--Modal: Login / Register Form-->


@include('world.layout.footer')
    <!-- Bootstrap core JavaScript -->
@include('world.layout.scripts')

@yield('js') 
</body>

</html>

@extends('world.layout.master')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.12/css/bootstrap/zebra_datepicker.css" />
<style type="text/css">
  .label {
    color: white;
    padding: 4px;
    margin-left: 4px;
    margin-top:4px;
    border-radius:30px;
  }

  .available_dates {background-color: #4CAF50 !important;} 
  .jumbotron{
    background-color:#ffffff;
    border:1px solid #AAA;
    border-bottom:3px solid #BBB;
    padding:0px;
    overflow:hidden;
    box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    -webkit-transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);    
    font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
  }
  .header{
    background: #33357e;

  }
  .blue h1, h2, h3 {

  }
  .headline {
    color: #FFFFFF;
    margin: 1em;
  }
  .card {
    background:#FFF;
    display: block;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    border:1px solid #AAA;
    border-bottom:3px solid #BBB;
    padding:0px;
    overflow:hidden;
    box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    -webkit-transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji"
  }

  .card p{
    font-size:14px !important;
  }
  .card-body{
   margin:1em;   
 }

 .pull-left {
  float: left;
}

.pull-none {
  float: none !important;
}

.pull-right {
  float: right;
}

.card-header{
  width:100%;
  color:#2196F3;
  border-bottom:3px solid #BBB;
  box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji"
  padding:0px;
  margin-top:0px;
  overflow:hidden;
  -webkit-transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);

}
.card-header-blue{
  background-color:#33357e;
  border-bottom:3px solid #BBB;
  box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji"
  padding:0px;
  margin-top:0px;
  overflow:hidden;
  -webkit-transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.card-heading {
  display: block;
  font-size: 24px;
  line-height: 28px;
  margin-bottom: 24px;
  margin-left:1em;
  border-bottom: 1px #2196F3;
  color:#fff;

}
.card-footer{
 border-top:1px solid #000;   

}

.padding-lr-30px {
  padding-left: 30px;
  padding-right: 30px;
}
.padding-top-20px {
  padding-top: 20px;
}
.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
  font-weight: 500;
}
.h3, h3 {
  font-size: 20px;
  line-height: 27px;
  letter-spacing: -1px;
}
.error{
  color: #ff0000;
  font-size: 12px;
}
</style>
@endsection
<!-- slider -->

@section('content')
<section class="doctors-block-chamber">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 text-center appointment-block">
        <div class="results">
         <h3>Sign In</h3>
       </div>
     </div>


     <div class="col-md-7">
      <div class="doctor-desk text-left">
        <h3> From Doctor's Desk </h3>
        <div class="doctor-desk-para">
          <p>&nbsp;</p>
        </div>
      </div>
    </div>
  </div>
</div>
</section>

<section class="clinic">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail / Phone') }}</label>

                <div class="col-md-6">
                  <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                  @if ($errors->has('email'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-6">
                  <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                  @if ($errors->has('password'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                  </span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                      {{ __('Remember Me') }}
                    </label>
                  </div>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                  </button>

                  @if (Route::has('password.request'))
                  <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                  </a>
                  @endif
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</section>



@endsection

@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
@endsection


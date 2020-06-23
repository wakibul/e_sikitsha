<header class="header-absolute">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-3 col-sm-3">
        <a class="logo" href="#"> <img src="{{asset('public/vendor/images/logo.png')}}" alt="logo" class="img-fluid"></a>
      </div>

      <div class="col-md-6 col-9 col-sm-9">

        <div class="contact-block">
           <div class="contact"><i class="fa fa-phone" aria-hidden="true" ></i>&nbsp;8812907328/8876657929 </div>
           <div class="contact"><i class="fa fa-envelope" aria-hidden="true" ></i>&nbsp;info@bookurdoc.com</div>
        </div>
      <!-- Navigation -->
      <nav class="navbar navbar-expand-lg navbar-dark static-top">
      <div class="container">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
      <a class="nav-link" href="{{url('/')}}">Home
      <span class="sr-only">(current)</span>
      </a>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="{{route('department')}}">Department</a>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="{{route('about_us')}}">About</a>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="{{route('service')}}">Services</a>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="{{route('contact')}}">Contact</a>
      </li>
      </ul>
      </div>
      </div>
      </nav>

      <div class="f-login">
         <ul class="sign-block">
           @if($user = Auth::user())
          <li class="sign-in"> <a href="{{url('/franchise')}}">{{ucwords(strtolower($user->name)) }} (Balance : <i class="fa fa-inr"></i> {{$user->amount}} )</a></li>
          @else
          <li class="sign-in"> <a href="#" data-toggle="modal" data-target="#modalLRForm">Franchise Login </a></li>
           @endif
          </ul>
      </div>

        </div>
      </div>
<div class="row">
  {{-- <div class="offset-md-8 col-md-4  d-none d-sm-block text-right">
          <ul class="sign-block">
           @if($user = Auth::user())
          <li class="sign-in"> <a href="{{url('/franchise')}}">{{ucwords(strtolower($user->name)) }} (Balance : <i class="fa fa-inr"></i> {{$user->amount}} )</a></li>
          @else
          <li class="sign-in"> <a href="#" data-toggle="modal" data-target="#modalLRForm">Franchise Login </a></li>
           @endif
          </ul>
  </div> --}}
</div>

</div>
{{--   <div class="row d-block d-sm-none">
    <div class="col-md-4">
       <ul class="mobile sign-block">
           @if($user = Auth::user())
          <li class="sign-in"> <a href="{{url('/franchise')}}">{{ucwords(strtolower($user->name)) }} (Balance : <i class="fa fa-inr"></i> {{$user->amount}} )</a></li>
          @else
          <li class="sign-in"> <a href="#" data-toggle="modal" data-target="#modalLRForm">Franchise Login </a></li>
           @endif
        </ul>
      </div>
  </div> --}}
</div>
</header>
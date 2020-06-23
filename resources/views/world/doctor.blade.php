@extends('world.layout.master')
@section('css')
<style type="text/css">
  .label {
  color: white;
  padding: 4px;
  margin-left: 4px;
  margin-top:4px;
  border-radius:30px;
}

.available_dates {background-color: #4CAF50 !important;}
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
    <!-- slider -->

@section('content')
<section class="doctors-block-chamber">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 text-center appointment-block">
<div class="doctor-desc-box text-left">
<h3> {{$doctor->name}} </h3>
<span class="adress">{{$doctor->current_city}}</span>
<span class="department">{{$doctor->department->name}} </span>
</div>

<div class="results">
 <h3>Showing <span>{{count($doctor->schedule)}} Clinics(S)</span> for this Doctors </h3>
</div>
</div>


<div class="col-md-7">
<div class="doctor-desk text-left">
<h3> From Doctor's Desk </h3>
<div class="doctor-desk-para">
@if($doctor_notes != null)
<p>{{$doctor_notes->notes}}</p>
@else
<p> &nbsp; </p>
@endif
</div>
</div>
</div>


      </div>
    </div>
  </section>

<section class="clinic">
<div class="container">
@foreach($doctor->schedule as $key=>$clinic)
<div class="row">
<div class="col-md-12">
<h3> Clinic {{$key+1}} of {{count($doctor->schedule)}} </h3>
</div>
</div>


<div class="clinic-details">
<div class="row">
<div class="col-md-8">

<ul class="clinic-details-ul">
<li> <p> <i class="fa fa-home" aria-hidden="true"></i> {{$clinic->clinic->name}} </p> </li>
<li><p> <i class="fa fa-map-marker" aria-hidden="true"></i> {{$clinic->clinic->address}} </p><a href="https://www.google.com/maps/search/{{$clinic->clinic->latitude}}, {{$clinic->clinic->longitude}}" target="_blank" class="how_to_reach_btn"> How to Reach? </a></li>
</ul>

@php
$future_date = date('Y-m-d').'+ '.intval($clinic->book_before_days).' days';
$date = date('Y-m-d',strtotime($future_date));

$available_dates = getAvailableDates($doctor->id,$clinic->clinic->id,$date);
$available_days = getAvailableDays($doctor->id,$clinic->clinic->id);
@endphp

<p>Doctor visits on <strong>{{$available_days}}</strong> .Tickets can be booked
  @if($clinic->book_before_days == 0)
  <strong> same day </strong>
  @else
  <strong>{{$clinic->book_before_days}} days</strong>
  @endif
  before <strong>{{date('h:i a',strtotime($clinic->book_before_time))}}</strong>
<p>&nbsp;</p>
@if($available_dates != false)
    <p>Seats available for {!!$available_dates!!}</p>
  <div class="preceed-div">
  <a href="{{route('book',[$doctor->slug,$clinic->clinic->slug])}}">Take Appointment</a>
  </div>
@else
    <p style="color: #ff0000"> <strong>No seat available</strong>  </p>
@endif
</p>
@if($clinic->remarks != null)
<p><span style="color:#ff0000">{{$clinic->remarks}} </span></p>
@endif
</div>

<div class="col-md-4">

<ul class="clinic-details-ul">
@php
$charges = getCharges($doctor->id,$clinic->clinic_id);
//dd($charges);
@endphp
<li> <i class="fa fa-inr" aria-hidden="true"></i> Doctor's Fee: @if($charges != null) {{ $charges->doctor_fees }} @endif</li>
<li> <i class="fa fa-inr" aria-hidden="true"></i> Booking Charges:   @if($charges != null) {{ $charges->booking_charge }} @endif </li>
</ul>
@if($doctor->fees_online == 1)
<p>Pay <strong> ₹{{$charges->booking_charge}}</strong> Booking Charge, Doctor's Fee <strong> ₹{{$charges->doctor_fees}} </strong> online</p>
@else
<p>Pay <strong> ₹{{$charges->booking_charge}}</strong> Online  and Doctor's Fee <strong> ₹{{$charges->doctor_fees}} </strong> at clinic</p>
@endif

</div>

</div>
</div>

@endforeach
</div>
</section>


<!-- Team -->
@if (!$recomend_doctors->isEmpty())
<section id="details_recomended_doctors" class="pb-5">
<div class="container">

<div class="row">
  <div class="col-md-6 text-left">
<h3> Recomended Doctors </h3>
  </div>
</div>


<div class="row">
<!-- Team member -->
@foreach($recomend_doctors as $key=>$recomend_doctor)
<div class="col-xs-12 col-sm-6 col-md-4">
<div class="frontside">
<div class="card">
<div class="card-body text-center">
<p><img class=" img-fluid" src="{{$recomend_doctor->picture}}" alt="{{$recomend_doctor->name}}"></p>
<h4 class="card-title"> {{$recomend_doctor->name}} </h4>
<p class="card-text">{{$recomend_doctor->department->name}}</p>
<a href="{{route('doctor',$recomend_doctor->slug)}}" class="btn btn-success"> Book Now </a>
</div>
</div>
</div>
</div>
@endforeach
<!-- ./Team member -->
<!-- Team member -->

<!-- ./Team member -->
<!-- Team member -->
<!-- ./Team member -->
<!-- Team member -->

<!-- ./Team member -->
<!-- Team member -->
<!-- ./Team member -->
<!-- Team member -->
<!-- ./Team member -->
</div>
</div>
</section>
@endif
@endsection

@section('js')
 <script src="{{ asset('public/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('public/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
@endsection


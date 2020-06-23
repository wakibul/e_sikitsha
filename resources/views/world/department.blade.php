@extends('world.layout.master')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
    <!-- slider -->

@section('content')

<section class="doctors-block">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center appointment-block" style="margin: 0 auto;">
          <h1> Doctor List </h1>

{{-- <div class="form-group col-md-3">
<label for="region"> Probable Date (optional): </label>
<div class="input-wrapper">
<input id="date" class="form-control" placeholder="Select Date">
</div>
</div> --}}
</form>
</div>

        </div>
      </div>
    </div>
  </section>

<section id="recomended_doctors" class="pb-5">
<div class="container">
@if(!isset(Request()->slug))
<div class="row">
  <div class="col-md-12 text-left alert alert-success" style="background-color: #3e4095 !important;">
<h3 style=" color:#fff !important"> Special Visit List </h3>
  </div>
</div>

<div class="row">
<!-- Team member -->
@foreach($special_doctors as $key=>$special_doctor)
<div class="col-xs-12 col-sm-6 col-md-4">
{{-- <div class="image-flip">
<div class="mainflip"> --}}
<div class="frontside">
<div class="card">
<div class="card-body text-center">
<p><img class=" img-fluid" src="{{$special_doctor->picture}}" alt="{{$special_doctor->name}}"></p>
<h4 class="card-title"> {{$special_doctor->name}} </h4>
<p class="card-text">{{$special_doctor->current_city}}</p>
@if($special_doctor->available->isNotEmpty())
<a href="{{route('doctor',$special_doctor->slug)}}" class="btn btn-success">Check Availability</a>
@else
<button type="button" class="btn btn-warning">Not Available</button>
@endif
</div>
</div>
</div>
</div>
{{-- <div class="backside">
<div class="card">
<div class="card-body text-center mt-4">
<h4 class="card-title"> {{$special_doctor->name}} </h4>
<p class="card-text">{{$special_doctor->department->name}}</p>

<a href="#" class="check-available"> Check Availibilty </a>

</div>
</div> --}}
{{-- </div>
</div> --}}
@endforeach
</div>
@endif


@foreach($departments as $key=>$department)
<div class="row">
  <div class="col-md-12 text-left alert alert-success" style="background-color: #3e4095 !important;">
<h3 style=" color:#fff !important"> {{$department->name}} </h3>
  </div>
</div>

<div class="row">
<!-- Team member -->
@foreach($department->doctors as $key=>$doctor)
<div class="col-xs-12 col-sm-6 col-md-4">
{{-- <div class="image-flip">
<div class="mainflip"> --}}
<div class="frontside">
<div class="card">
<div class="card-body text-center">
<p><img class=" img-fluid" src="{{$doctor->picture}}" alt="{{$doctor->name}}"></p>
<h4 class="card-title"> {{$doctor->name}} </h4>
<p class="card-text">{{$doctor->current_city}}</p>
@if($doctor->available->isNotEmpty())
<a href="{{route('doctor',$doctor->slug)}}" class="btn btn-success">Book Now</a>
@else
<button type="button" class="btn btn-warning">Not Available</button>
@endif
</div>
</div>
</div>
</div>
{{-- <div class="backside">
<div class="card">
<div class="card-body text-center mt-4">
<h4 class="card-title"> {{$special_doctor->name}} </h4>
<p class="card-text">{{$special_doctor->department->name}}</p>

<a href="#" class="check-available"> Check Availibilty </a>

</div>
</div> --}}
{{-- </div>
</div> --}}
@endforeach
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
@endsection

@section('js')
 <script src="{{ asset('public/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('public/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
  $(function() {
  $('#date').daterangepicker({
    "singleDatePicker": true,
    "timePicker": false,
    "linkedCalendars": false,
  "autoUpdateInput": false
}, function(start, end, label) {
  console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
});

$('#date').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });

  $('#date').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('Select Date');
  });

});

</script>

@endsection


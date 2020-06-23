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
<div class="doctor-list text-left">
<form class="form-inline" action="#" method="post">
<div class="form-group col-md-3">
<label for="region"> Select Region </label>
<select class="form-control" id="region">
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
</select>
</div>

<div class="form-group col-md-3">
<label for="region"> Probable Date (optional): </label>
<div class="input-wrapper">
<input id="date" class="form-control" placeholder="Select Date">
</div>
</div>

<div class="form-group col-md-3">
<label for="region"> Select Specialization* : </label>
<select class="form-control" id="region">
<option>-Specialization-</option>
<option>Cardiac Surgeon</option>
<option>Cardiologist</option>
<option>Cardiologist and Diabetologist</option>
</select>
</div>

<div class="form-group col-md-3">
<button type="submit" class="btn btn-primary mb-2">Refine Search</button>
</div>
</form>
</div>

        </div>
      </div>
    </div>
  </section>

<!-- Team -->
<section id="doctors" class="pb-5">
<div class="container">
<div class="row">
<!-- Team member -->
<div class="col-xs-12 col-sm-6 col-md-4">
<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
<div class="mainflip">
<div class="frontside">
<div class="card">
<div class="card-body text-center">
<p><img class=" img-fluid" src="https://sunlimetech.com/portfolio/boot4menu/assets/imgs/team/img_01.png" alt="card image"></p>
<h4 class="card-title"> Sunlimetech </h4>
<p class="card-text">This is basic card with image on top, title, description and button.</p>
</div>
</div>
</div>
<div class="backside">
<div class="card">
<div class="card-body text-center mt-4">
<h4 class="card-title"> Sunlimetech </h4>
<p class="card-text">This is basic card with image on top, title, description and button.This is basic card with image on top, title, description and button.This is basic card with image on top, title, description and button.</p>

<a href="#" class="check-available"> Check Availibilty </a>

</div>
</div>
</div>
</div>
</div>
</div>
<!-- ./Team member -->
<!-- Team member -->
<div class="col-xs-12 col-sm-6 col-md-4">
<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
<div class="mainflip">
<div class="frontside">
<div class="card">
<div class="card-body text-center">
<p><img class=" img-fluid" src="https://sunlimetech.com/portfolio/boot4menu/assets/imgs/team/img_02.png" alt="card image"></p>
<h4 class="card-title">Sunlimetech</h4>
<p class="card-text">This is basic card with image on top, title, description and button.</p>
</div>
</div>
</div>
<div class="backside">
<div class="card">
<div class="card-body text-center mt-4">
<h4 class="card-title">Sunlimetech</h4>
<p class="card-text">This is basic card with image on top, title, description and button.This is basic card with image on top, title, description and button.This is basic card with image on top, title, description and button.</p>

<a href="#" class="check-available"> Check Availibilty </a>

</div>
</div>
</div>
</div>
</div>
</div>
<!-- ./Team member -->
<!-- Team member -->
<div class="col-xs-12 col-sm-6 col-md-4">
<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
<div class="mainflip">
<div class="frontside">
<div class="card">
<div class="card-body text-center">
<p><img class=" img-fluid" src="https://sunlimetech.com/portfolio/boot4menu/assets/imgs/team/img_03.png" alt="card image"></p>
<h4 class="card-title">Sunlimetech</h4>
<p class="card-text">This is basic card with image on top, title, description and button.</p>
</div>
</div>
</div>
<div class="backside">
<div class="card">
<div class="card-body text-center mt-4">
<h4 class="card-title">Sunlimetech</h4>
<p class="card-text">This is basic card with image on top, title, description and button.This is basic card with image on top, title, description and button.This is basic card with image on top, title, description and button.</p>

<a href="#" class="check-available"> Check Availibilty </a>


</div>
</div>
</div>
</div>
</div>
</div>
<!-- ./Team member -->
<!-- Team member -->
<div class="col-xs-12 col-sm-6 col-md-4">
<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
<div class="mainflip">
<div class="frontside">
<div class="card">
<div class="card-body text-center">
<p><img class=" img-fluid" src="https://sunlimetech.com/portfolio/boot4menu/assets/imgs/team/img_04.jpg" alt="card image"></p>
<h4 class="card-title">Sunlimetech</h4>
<p class="card-text">This is basic card with image on top, title, description and button.</p>
</div>
</div>
</div>
<div class="backside">
<div class="card">
<div class="card-body text-center mt-4">
<h4 class="card-title">Sunlimetech</h4>
<p class="card-text">This is basic card with image on top, title, description and button.This is basic card with image on top, title, description and button.This is basic card with image on top, title, description and button.</p>

<a href="#" class="check-available"> Check Availibilty </a>

</div>
</div>
</div>
</div>
</div>
</div>
<!-- ./Team member -->
<!-- Team member -->
<div class="col-xs-12 col-sm-6 col-md-4">
<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
<div class="mainflip">
<div class="frontside">
<div class="card">
<div class="card-body text-center">
<p><img class=" img-fluid" src="https://sunlimetech.com/portfolio/boot4menu/assets/imgs/team/img_05.png" alt="card image"></p>
<h4 class="card-title">Sunlimetech</h4>
<p class="card-text">This is basic card with image on top, title, description and button.</p>
</div>
</div>
</div>
<div class="backside">
<div class="card">
<div class="card-body text-center mt-4">
<h4 class="card-title">Sunlimetech</h4>
<p class="card-text">This is basic card with image on top, title, description and button.This is basic card with image on top, title, description and button.This is basic card with image on top, title, description and button.</p>

<a href="#" class="check-available"> Check Availibilty </a>

</div>
</div>
</div>
</div>
</div>
</div>
<!-- ./Team member -->
<!-- Team member -->
<div class="col-xs-12 col-sm-6 col-md-4">
<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
<div class="mainflip">
<div class="frontside">
<div class="card">
<div class="card-body text-center">
<p><img class=" img-fluid" src="https://sunlimetech.com/portfolio/boot4menu/assets/imgs/team/img_06.jpg" alt="card image"></p>
<h4 class="card-title">Sunlimetech</h4>
<p class="card-text">This is basic card with image on top, title, description and button.</p>
</div>
</div>
</div>
<div class="backside">
<div class="card">
<div class="card-body text-center mt-4">
<h4 class="card-title">Sunlimetech</h4>
<p class="card-text">This is basic card with image on top, title, description and button.This is basic card with image on top, title, description and button.This is basic card with image on top, title, description and button.</p>

<a href="#" class="check-available"> Check Availibilty </a>

</div>
</div>
</div>
</div>
</div>
</div>
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


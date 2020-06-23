@extends('world.layout.master')
@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
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
 <h3>Proceed with the patient details</h3>
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
  <div class="row">
      <div class="col-md-4">
            <div class="card">
                    <div class="card-content">
                      <div class="card-header-blue">
                           <h3 class="padding-lr-30px padding-top-20px" style="color: #FFF"><i class="fa fa-calendar margin-right-10px"></i> <strong>Schedule of Visit</strong></h3>
                        </div>
                        <div class="card-body">
                        <p class="card-p">
                             @foreach($availableDays as $key=>$val)
                             <div class="row">
                               <div class="col-md-5"><p><i class="fa fa-calendar" aria-hidden="true"></i> {{$val->days}}</p></div>
                               <div class="col-md-7">
                                @php
                                $timings = getAlltiming($val->days,$val->doctor_id,$val->clinic_id);
                                @endphp
                                @foreach($timings as $key=>$val)
                                <p><i class="fa fa-clock-o" aria-hidden="true"></i>
                                 {{date('h:i a',strtotime($val->starttime))}} - {{date('h:i a',strtotime($val->endtime))}}</p>
                                 @endforeach
                                </div>
                             </div>
                             <hr>
                              @endforeach

                        </p>
                      </div>

                    </div>
                </div>

  </div>
  @php
$charges = getCharges($doctor->id,$clinic->id);
@endphp
  <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
            <i class="fa fa-home"></i> {{$clinic->name}}
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <i class="fa fa-map-marker"></i> {{$clinic->address}}
            <a href="https://www.google.com/maps/search/{{$clinic->latitude}}, {{$clinic->longitude}}" target="_blank" class="btn btn-warning">How to Reach?</a>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            Doctor Fees
          </div>
          <div class="col-md-2">
            <i class="fa fa-inr"></i> {{$charges->doctor_fees}}
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            Booking Charge
          </div>
          <div class="col-md-2">
            <i class="fa fa-inr"></i> {{$charges->booking_charge}}
          </div>
        </div>

<form name="f1" action="{{route('patient_info')}}" method="POST" id="f1">
  @csrf

   @if ($errors->any())
   <div class="row">
    <div class="alert alert-danger">
    @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach
    </div>
  </div>
  @endif

  @if(Session::has('success'))
  <div class="row">
            <div class="alert alert-success">
            {{ session()->get('success') }}
            </div>
   </div>
  @endif

  @if (session()->has('error'))
    <div class="alert alert-danger">
            {{session()->get('error')}}
    </div>
@endif

<input type="hidden" name="doctor_id" id="doctor_id" value="{{$doctor->id}}">
<input type="hidden" name="clinic_id" id="clinic_id" value="{{$clinic->id}}">
<input type="hidden" name="fees_mode" value="{{$doctor->fees_online}}">
<input type="hidden" name="agent_charge" value="{{$charges->agent_charge}}">
         <div class="row mt-5  form-group">
          <div class="col-md-6">
            <p>Redeem  Coupon (Optional)</p>
             <input type="text" class="form-control" name="coupon_id" id="coupon_id" value="{{old('coupon')}}">
          </div>
          <div class="col-md-6">
            <p>Date</p>
             <input type="text" class="form-control" name="date" id="date" readonly required>
          </div>
        </div>

         <div class="row form-group">
          <div class="col-md-4">
            <p>Time</p>
            <select name="slot_id" id="time" class="form-control" required>
              <option value="">Select Time</option>
            </select>
          </div>
          <div class="col-md-4">
            <p>Consultation Fees</p>
             <input type="consultation_fees" class="form-control" name="consultation_fees" id="consultation_fees" readonly value=" {{ $charges->doctor_fees }} " required>
          </div>
          <div class="col-md-4">
            <p>Service Charge</p>
             <input type="service_charge" class="form-control" name="service_charge" id="service_charge" readonly  value="{{$charges->booking_charge}}" required>
          </div>
        </div>

        <div class="row form-group">
            <div class="col-md-12">
              <h4>Patient Details</h4><hr>
              <span id="seatMassage"></span>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-12">
              <p>Patient Name</p>
              <input type="text" class="form-control" name="patient_name" id="patient_name" value="{{old('patient_name')}}" required>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-12">
              <p>Patient's City</p>
              <input type="text" class="form-control" name="patient_city" id="patient_city" value="{{old('patient_city')}}" required>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-12">
              <p>Email (Optional)</p>
              <input type="email" class="form-control" name="email" id="email" value="{{old('email')}}">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-12">
              <p>Phone (without starting 0/+91): </p>
              <input type="number" class="form-control" name="phone_no" id="phone_no" required  value="{{old('phone_no')}}">
             <p style="font-size: 11px; color: #ff0000"> You will receive SMS to this number after successful booking, which you must show to chamber else your booking may be treated as invalid</p>
            </div>

        </div>

        <div class="row form-group">
            <div class="col-md-12">
              <p>Gender : </p>
              <input type="radio" class="custom-switch-input" name="gender" id="genderM" required  value="Male">
              Male

              <input type="radio" class="custom-switch-input" name="gender" id="genderM" required  value="Female">
              Female
            </div>

        </div>

        <div class="row form-group">
            <div class="col-md-12">
              <p>Age : </p>
              <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="3" class="form-control" name="age" id="age" required  value="{{old('age')}}">
            </div>

        </div>



        <div class="row form-group">
            <div class="col-md-3 col-md-offset-3">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
  </form>
  </div>
</div>
</div>
@php
$future_date = date('Y-m-d').'+ '.intval($doctor->schedule[0]->book_before_days).' days';
$d = date('Y-m-d',strtotime($future_date));
$calenderDate = getDatesForCalender($doctor->id,$clinic->id,$d);
//dd($calenderDate);
@endphp
</section>



@endsection

@section('js')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.12/zebra_datepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
<script>
$('#f1').validate();
var availableDates = [{!! $calenderDate !!}];
//console.log(availableDates);
function available(date) {
 var month = date.getMonth()+1;
 if(month < 10){
    month = "0"+(date.getMonth()+1);
 }

 var days = date.getDate();
 if(days < 10){
    days = "0"+date.getDate();
 }
  dmy = days + "-" + month + "-" + date.getFullYear();
  //console.log(dmy);
  if ($.inArray(dmy, availableDates) != -1) {
    return [true, "","Available"];
  } else {
    return [false,"","unAvailable"];
  }
}
 $('#date').datepicker({
    dateFormat: 'dd-mm-yy',
   // direction: [{!!$calenderDate!!}],
    beforeShowDay: available,
    onSelect: function(){
      $('#time').html('');
      var doctor_id = {{$doctor->id}};
      var date = $('#date').val();
      var clinic_id = $('#clinic_id').val();
      $.ajax
      ({
      type: "GET",
      url: "{{route('slot')}}",
      data: {doctor_id:doctor_id,date:date,clinic_id:clinic_id},
      dataType:'json',
      cache: false,
      success: function(html)
      {
          var data = '';
          console.log(html);
          if(html.length != 0){
             data += "<option value=''>Select Time</option>";
              $.each(html,function(k,v){
                  data += "<option value='"+v.schedule.id+"'>"+v.schedule.slot+"</option>";
               });
              $('#time').append(data);
              // var msg = '';
              // if(parseInt(v.available_seat)<=5){
              //    msg += "<p stylle='color:#ff0000'>Hurry only "+v.available_seat+" left</p>";
              //    $('#seatMassage').html(msg);
              // }
            }else{
              alert('No booking available! Please select an another date');
              $('#date').val('');
            }


      },
      error: function(html){
        alert('Oops something went wrong');
      }
      });
    }
});
</script>
@endsection


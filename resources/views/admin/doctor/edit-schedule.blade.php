@extends('admin.layout.master')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.12/css/bootstrap/zebra_datepicker.css">
@endsection

@section('content')
<div class="container card">
  <div class="row">
    <div class="col-12">
      <div class="page-header">
        <h1 class="page-title">
         Edit Schedule
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
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <form action="{{route('admin.doctor.update_schedule',Crypt::encrypt($schedule->id))}}"  method="POST">
                @csrf
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            Days
                        </div>
                        <div class="col-md-4">
                        <input type="radio" name="days" id="day" class="required" value="Sunday" @if($schedule->days == "Sunday") checked @endif>
                                                Sunday<br>
                        <input type="radio" name="days" id="day" class="required" value="Monday"  @if($schedule->days == "Monday") checked @endif>
                                                Monday<br>
                        <input type="radio" name="days" id="day" class="required" value="Tuesday"  @if($schedule->days == "Tuesday") checked @endif>
                        Tuesday<br>
                        <input type="radio" name="days" id="day" class="required" value="Wednesday"  @if($schedule->days == "Wednesday") checked @endif>
                        Wednesday<br>
                        <input type="radio" name="days" id="day" class="required" value="Thursday"  @if($schedule->days == "Thursday") checked @endif>
                        Thursday<br>
                        <input type="radio" name="days" id="day" class="required" value="Friday"  @if($schedule->days == "Friday") checked @endif>
                        Friday<br>
                        <input type="radio" name="days" id="day" class="required" value="Saturday"  @if($schedule->days == "Saturday") checked @endif>
                        Saturday<br>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            Start Time
                        </div>
                        <div class="col-md-3">
                        <select name="starttime"  class="form-control"  required="true">
            <option value="">Select</option>
            <option value="12:00" @if($schedule->starttime == "12:00") selected @endif>12:00 PM</option>
            <option value="12:30" @if($schedule->starttime == "12:30") selected @endif>12:30 PM</option>
            <option value="13:00" @if($schedule->starttime == "13:00") selected @endif>01:00 PM</option>
            <option value="13:30" @if($schedule->starttime == "13:30") selected @endif>01:30 PM</option>
            <option value="14:00" @if($schedule->starttime == "14:00") selected @endif>02:00 PM</option>
            <option value="14:30" @if($schedule->starttime == "14:30") selected @endif>02:30 PM</option>
            <option value="15:00" @if($schedule->starttime == "15:00") selected @endif>03:00 PM</option>
            <option value="15:30" @if($schedule->starttime == "15:30") selected @endif>03:30 PM</option>
            <option value="16:00" @if($schedule->starttime == "16:00") selected @endif>04:00 PM</option>
            <option value="16:30" @if($schedule->starttime == "16:30") selected @endif>04:30 PM</option>
            <option value="17:00" @if($schedule->starttime == "17:00") selected @endif>05:00 PM</option>
            <option value="17:30" @if($schedule->starttime == "17:30") selected @endif>05:30 PM</option>
            <option value="18:00" @if($schedule->starttime == "18:00") selected @endif>06:00 PM</option>
            <option value="18:30" @if($schedule->starttime == "18:30") selected @endif>06:30 PM</option>
            <option value="19:00" @if($schedule->starttime == "19:00") selected @endif>07:00 PM</option>
            <option value="19:30" @if($schedule->starttime == "19:30") selected @endif>07:30 PM</option>
            <option value="20:00" @if($schedule->starttime == "20:00") selected @endif>08:00 PM</option>
            <option value="20:30" @if($schedule->starttime == "20:30") selected @endif>08:30 PM</option>
            <option value="21:00" @if($schedule->starttime == "21:00") selected @endif>09:00 PM</option>
            <option value="21:30" @if($schedule->starttime == "21:30") selected @endif>09:30 PM</option>
            <option value="22:00" @if($schedule->starttime == "22:00") selected @endif>10:00 PM</option>
            <option value="22:30" @if($schedule->starttime == "22:30") selected @endif>10:30 PM</option>
            <option value="23:00" @if($schedule->starttime == "23:00") selected @endif>11:00 PM</option>
            <option value="23:30" @if($schedule->starttime == "23:30") selected @endif>11:30 PM</option>
            <option value="00:00" @if($schedule->starttime == "00:00") selected @endif>12:00 AM</option>
            <option value="00:30" @if($schedule->starttime == "00:00") selected @endif>12:30 AM</option>
            <option value="01:00" @if($schedule->starttime == "01:00") selected @endif>01:00 AM</option>
            <option value="01:30" @if($schedule->starttime == "01:30") selected @endif>01:30 AM</option>
            <option value="02:00" @if($schedule->starttime == "02:00") selected @endif>02:00 AM</option>
            <option value="02:30" @if($schedule->starttime == "02:30") selected @endif>02:30 AM</option>
            <option value="03:00" @if($schedule->starttime == "03:00") selected @endif>03:00 AM</option>
            <option value="03:30" @if($schedule->starttime == "03:30") selected @endif>03:30 AM</option>
            <option value="04:00" @if($schedule->starttime == "04:00") selected @endif>04:00 AM</option>
            <option value="04:30" @if($schedule->starttime == "04:30") selected @endif>04:30 AM</option>
            <option value="05:00" @if($schedule->starttime == "05:00") selected @endif>05:00 AM</option>
            <option value="05:30" @if($schedule->starttime == "05:30") selected @endif>05:30 AM</option>
            <option value="06:00" @if($schedule->starttime == "06:00") selected @endif>06:00 AM</option>
            <option value="06:30" @if($schedule->starttime == "06:30") selected @endif>06:30 AM</option>
            <option value="07:00" @if($schedule->starttime == "07:00") selected @endif>07:00 AM</option>
            <option value="07:30" @if($schedule->starttime == "07:30") selected @endif>07:30 AM</option>
            <option value="08:00" @if($schedule->starttime == "08:00") selected @endif>08:00 AM</option>
            <option value="08:30" @if($schedule->starttime == "08:30") selected @endif>08:30 AM</option>
            <option value="09:00" @if($schedule->starttime == "09:00") selected @endif>09:00 AM</option>
            <option value="09:30" @if($schedule->starttime == "09:30") selected @endif>09:30 AM</option>
            <option value="10:00" @if($schedule->starttime == "10:00") selected @endif>10:00 AM</option>
            <option value="10:30" @if($schedule->starttime == "10:30") selected @endif>10:30 AM</option>
            <option value="11:00" @if($schedule->starttime == "11:00") selected @endif>11:00 AM</option>
            <option value="11:30" @if($schedule->starttime == "11:30") selected @endif>11:30 AM</option>
            </select>
                        </div>


                        <div class="col-md-2">
                            End Time
                        </div>
                        <div class="col-md-3">
                        <select name="endtime"  class="form-control"  required="true">
            <option value="">Select</option>
            <option value="12:00" @if($schedule->endtime == "12:00") selected @endif>12:00 PM</option>
            <option value="12:30" @if($schedule->endtime == "12:30") selected @endif>12:30 PM</option>
            <option value="13:00" @if($schedule->endtime == "13:00") selected @endif>01:00 PM</option>
            <option value="13:30" @if($schedule->endtime == "13:30") selected @endif>01:30 PM</option>
            <option value="14:00" @if($schedule->endtime == "14:00") selected @endif>02:00 PM</option>
            <option value="14:30" @if($schedule->endtime == "14:30") selected @endif>02:30 PM</option>
            <option value="15:00" @if($schedule->endtime == "15:00") selected @endif>03:00 PM</option>
            <option value="15:30" @if($schedule->endtime == "15:30") selected @endif>03:30 PM</option>
            <option value="16:00" @if($schedule->endtime == "16:00") selected @endif>04:00 PM</option>
            <option value="16:30" @if($schedule->endtime == "16:30") selected @endif>04:30 PM</option>
            <option value="17:00" @if($schedule->endtime == "17:00") selected @endif>05:00 PM</option>
            <option value="17:30" @if($schedule->endtime == "17:30") selected @endif>05:30 PM</option>
            <option value="18:00" @if($schedule->endtime == "18:00") selected @endif>06:00 PM</option>
            <option value="18:30" @if($schedule->endtime == "18:30") selected @endif>06:30 PM</option>
            <option value="19:00" @if($schedule->endtime == "19:00") selected @endif>07:00 PM</option>
            <option value="19:30" @if($schedule->endtime == "19:30") selected @endif>07:30 PM</option>
            <option value="20:00" @if($schedule->endtime == "20:00") selected @endif>08:00 PM</option>
            <option value="20:30" @if($schedule->endtime == "20:30") selected @endif>08:30 PM</option>
            <option value="21:00" @if($schedule->endtime == "21:00") selected @endif>09:00 PM</option>
            <option value="21:30" @if($schedule->endtime == "21:30") selected @endif>09:30 PM</option>
            <option value="22:00" @if($schedule->endtime == "22:00") selected @endif>10:00 PM</option>
            <option value="22:30" @if($schedule->endtime == "22:30") selected @endif>10:30 PM</option>
            <option value="23:00" @if($schedule->endtime == "23:00") selected @endif>11:00 PM</option>
            <option value="23:30" @if($schedule->endtime == "23:30") selected @endif>11:30 PM</option>
            <option value="00:00" @if($schedule->endtime == "00:00") selected @endif>12:00 AM</option>
            <option value="00:30" @if($schedule->endtime == "00:00") selected @endif>12:30 AM</option>
            <option value="01:00" @if($schedule->endtime == "01:00") selected @endif>01:00 AM</option>
            <option value="01:30" @if($schedule->endtime == "01:30") selected @endif>01:30 AM</option>
            <option value="02:00" @if($schedule->endtime == "02:00") selected @endif>02:00 AM</option>
            <option value="02:30" @if($schedule->endtime == "02:30") selected @endif>02:30 AM</option>
            <option value="03:00" @if($schedule->endtime == "03:00") selected @endif>03:00 AM</option>
            <option value="03:30" @if($schedule->endtime == "03:30") selected @endif>03:30 AM</option>
            <option value="04:00" @if($schedule->endtime == "04:00") selected @endif>04:00 AM</option>
            <option value="04:30" @if($schedule->endtime == "04:30") selected @endif>04:30 AM</option>
            <option value="05:00" @if($schedule->endtime == "05:00") selected @endif>05:00 AM</option>
            <option value="05:30" @if($schedule->endtime == "05:30") selected @endif>05:30 AM</option>
            <option value="06:00" @if($schedule->endtime == "06:00") selected @endif>06:00 AM</option>
            <option value="06:30" @if($schedule->endtime == "06:30") selected @endif>06:30 AM</option>
            <option value="07:00" @if($schedule->endtime == "07:00") selected @endif>07:00 AM</option>
            <option value="07:30" @if($schedule->endtime == "07:30") selected @endif>07:30 AM</option>
            <option value="08:00" @if($schedule->endtime == "08:00") selected @endif>08:00 AM</option>
            <option value="08:30" @if($schedule->endtime == "08:30") selected @endif>08:30 AM</option>
            <option value="09:00" @if($schedule->endtime == "09:00") selected @endif>09:00 AM</option>
            <option value="09:30" @if($schedule->endtime == "09:30") selected @endif>09:30 AM</option>
            <option value="10:00" @if($schedule->endtime == "10:00") selected @endif>10:00 AM</option>
            <option value="10:30" @if($schedule->endtime == "10:30") selected @endif>10:30 AM</option>
            <option value="11:00" @if($schedule->endtime == "11:00") selected @endif>11:00 AM</option>
            <option value="11:30" @if($schedule->endtime == "11:30") selected @endif>11:30 AM</option>
            </select>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                           Max Booking
                        </div>
                        <div class="col-md-3">
                       <input type="text" class="form-control" value="{{$schedule->max_booking}}" name="max_booking">
                        </div>
                        <div class="col-md-2">
                            SMS Time
                        </div>
                        <div class="col-md-3">
                        <select name="sms_time"  class="form-control"  required="true">
            <option value="">Select</option>
            <option value="12:00" @if($schedule->sms_time == "12:00") selected @endif>12:00 PM</option>
            <option value="12:30" @if($schedule->sms_time == "12:30") selected @endif>12:30 PM</option>
            <option value="13:00" @if($schedule->sms_time == "13:00") selected @endif>01:00 PM</option>
            <option value="13:30" @if($schedule->sms_time == "13:30") selected @endif>01:30 PM</option>
            <option value="14:00" @if($schedule->sms_time == "14:00") selected @endif>02:00 PM</option>
            <option value="14:30" @if($schedule->sms_time == "14:30") selected @endif>02:30 PM</option>
            <option value="15:00" @if($schedule->sms_time == "15:00") selected @endif>03:00 PM</option>
            <option value="15:30" @if($schedule->sms_time == "15:30") selected @endif>03:30 PM</option>
            <option value="16:00" @if($schedule->sms_time == "16:00") selected @endif>04:00 PM</option>
            <option value="16:30" @if($schedule->sms_time == "16:30") selected @endif>04:30 PM</option>
            <option value="17:00" @if($schedule->sms_time == "17:00") selected @endif>05:00 PM</option>
            <option value="17:30" @if($schedule->sms_time == "17:30") selected @endif>05:30 PM</option>
            <option value="18:00" @if($schedule->sms_time == "18:00") selected @endif>06:00 PM</option>
            <option value="18:30" @if($schedule->sms_time == "18:30") selected @endif>06:30 PM</option>
            <option value="19:00" @if($schedule->sms_time == "19:00") selected @endif>07:00 PM</option>
            <option value="19:30" @if($schedule->sms_time == "19:30") selected @endif>07:30 PM</option>
            <option value="20:00" @if($schedule->sms_time == "20:00") selected @endif>08:00 PM</option>
            <option value="20:30" @if($schedule->sms_time == "20:30") selected @endif>08:30 PM</option>
            <option value="21:00" @if($schedule->sms_time == "21:00") selected @endif>09:00 PM</option>
            <option value="21:30" @if($schedule->sms_time == "21:30") selected @endif>09:30 PM</option>
            <option value="22:00" @if($schedule->sms_time == "22:00") selected @endif>10:00 PM</option>
            <option value="22:30" @if($schedule->sms_time == "22:30") selected @endif>10:30 PM</option>
            <option value="23:00" @if($schedule->sms_time == "23:00") selected @endif>11:00 PM</option>
            <option value="23:30" @if($schedule->sms_time == "23:30") selected @endif>11:30 PM</option>
            <option value="00:00" @if($schedule->sms_time == "00:00") selected @endif>12:00 AM</option>
            <option value="00:30" @if($schedule->sms_time == "00:00") selected @endif>12:30 AM</option>
            <option value="01:00" @if($schedule->sms_time == "01:00") selected @endif>01:00 AM</option>
            <option value="01:30" @if($schedule->sms_time == "01:30") selected @endif>01:30 AM</option>
            <option value="02:00" @if($schedule->sms_time == "02:00") selected @endif>02:00 AM</option>
            <option value="02:30" @if($schedule->sms_time == "02:30") selected @endif>02:30 AM</option>
            <option value="03:00" @if($schedule->sms_time == "03:00") selected @endif>03:00 AM</option>
            <option value="03:30" @if($schedule->sms_time == "03:30") selected @endif>03:30 AM</option>
            <option value="04:00" @if($schedule->sms_time == "04:00") selected @endif>04:00 AM</option>
            <option value="04:30" @if($schedule->sms_time == "04:30") selected @endif>04:30 AM</option>
            <option value="05:00" @if($schedule->sms_time == "05:00") selected @endif>05:00 AM</option>
            <option value="05:30" @if($schedule->sms_time == "05:30") selected @endif>05:30 AM</option>
            <option value="06:00" @if($schedule->sms_time == "06:00") selected @endif>06:00 AM</option>
            <option value="06:30" @if($schedule->sms_time == "06:30") selected @endif>06:30 AM</option>
            <option value="07:00" @if($schedule->sms_time == "07:00") selected @endif>07:00 AM</option>
            <option value="07:30" @if($schedule->sms_time == "07:30") selected @endif>07:30 AM</option>
            <option value="08:00" @if($schedule->sms_time == "08:00") selected @endif>08:00 AM</option>
            <option value="08:30" @if($schedule->sms_time == "08:30") selected @endif>08:30 AM</option>
            <option value="09:00" @if($schedule->sms_time == "09:00") selected @endif>09:00 AM</option>
            <option value="09:30" @if($schedule->sms_time == "09:30") selected @endif>09:30 AM</option>
            <option value="10:00" @if($schedule->sms_time == "10:00") selected @endif>10:00 AM</option>
            <option value="10:30" @if($schedule->sms_time == "10:30") selected @endif>10:30 AM</option>
            <option value="11:00" @if($schedule->sms_time == "11:00") selected @endif>11:00 AM</option>
            <option value="11:30" @if($schedule->sms_time == "11:30") selected @endif>11:30 AM</option>
            </select>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="row">
                <div class="col-md-2">Book before Days</div>
                        <div class="col-md-3">
                        <select name="book_before_days" class="form-control" required>
                            <option value="">Select</option>
                            @for($i=0;$i<30;$i++)
                            <option value="{{$i}}"  @if($schedule->book_before_days == $i) selected @endif>{{$i}}</option>
                            @endfor
                            </select>
                        </div>

                        <div class="col-md-2">
                            Book before Time
                        </div>
                        <div class="col-md-3">
                        <select name="book_before_time"  class="form-control"  required="true">
            <option value="">Select</option>
            <option value="12:00" @if($schedule->book_before_time == "12:00") selected @endif>12:00 PM</option>
            <option value="12:30" @if($schedule->book_before_time == "12:30") selected @endif>12:30 PM</option>
            <option value="13:00" @if($schedule->book_before_time == "13:00") selected @endif>01:00 PM</option>
            <option value="13:30" @if($schedule->book_before_time == "13:30") selected @endif>01:30 PM</option>
            <option value="14:00" @if($schedule->book_before_time == "14:00") selected @endif>02:00 PM</option>
            <option value="14:30" @if($schedule->book_before_time == "14:30") selected @endif>02:30 PM</option>
            <option value="15:00" @if($schedule->book_before_time == "15:00") selected @endif>03:00 PM</option>
            <option value="15:30" @if($schedule->book_before_time == "15:30") selected @endif>03:30 PM</option>
            <option value="16:00" @if($schedule->book_before_time == "16:00") selected @endif>04:00 PM</option>
            <option value="16:30" @if($schedule->book_before_time == "16:30") selected @endif>04:30 PM</option>
            <option value="17:00" @if($schedule->book_before_time == "17:00") selected @endif>05:00 PM</option>
            <option value="17:30" @if($schedule->book_before_time == "17:30") selected @endif>05:30 PM</option>
            <option value="18:00" @if($schedule->book_before_time == "18:00") selected @endif>06:00 PM</option>
            <option value="18:30" @if($schedule->book_before_time == "18:30") selected @endif>06:30 PM</option>
            <option value="19:00" @if($schedule->book_before_time == "19:00") selected @endif>07:00 PM</option>
            <option value="19:30" @if($schedule->book_before_time == "19:30") selected @endif>07:30 PM</option>
            <option value="20:00" @if($schedule->book_before_time == "20:00") selected @endif>08:00 PM</option>
            <option value="20:30" @if($schedule->book_before_time == "20:30") selected @endif>08:30 PM</option>
            <option value="21:00" @if($schedule->book_before_time == "21:00") selected @endif>09:00 PM</option>
            <option value="21:30" @if($schedule->book_before_time == "21:30") selected @endif>09:30 PM</option>
            <option value="22:00" @if($schedule->book_before_time == "22:00") selected @endif>10:00 PM</option>
            <option value="22:30" @if($schedule->book_before_time == "22:30") selected @endif>10:30 PM</option>
            <option value="23:00" @if($schedule->book_before_time == "23:00") selected @endif>11:00 PM</option>
            <option value="23:30" @if($schedule->book_before_time == "23:30") selected @endif>11:30 PM</option>
            <option value="00:00" @if($schedule->book_before_time == "00:00") selected @endif>12:00 AM</option>
            <option value="00:30" @if($schedule->book_before_time == "00:00") selected @endif>12:30 AM</option>
            <option value="01:00" @if($schedule->book_before_time == "01:00") selected @endif>01:00 AM</option>
            <option value="01:30" @if($schedule->book_before_time == "01:30") selected @endif>01:30 AM</option>
            <option value="02:00" @if($schedule->book_before_time == "02:00") selected @endif>02:00 AM</option>
            <option value="02:30" @if($schedule->book_before_time == "02:30") selected @endif>02:30 AM</option>
            <option value="03:00" @if($schedule->book_before_time == "03:00") selected @endif>03:00 AM</option>
            <option value="03:30" @if($schedule->book_before_time == "03:30") selected @endif>03:30 AM</option>
            <option value="04:00" @if($schedule->book_before_time == "04:00") selected @endif>04:00 AM</option>
            <option value="04:30" @if($schedule->book_before_time == "04:30") selected @endif>04:30 AM</option>
            <option value="05:00" @if($schedule->book_before_time == "05:00") selected @endif>05:00 AM</option>
            <option value="05:30" @if($schedule->book_before_time == "05:30") selected @endif>05:30 AM</option>
            <option value="06:00" @if($schedule->book_before_time == "06:00") selected @endif>06:00 AM</option>
            <option value="06:30" @if($schedule->book_before_time == "06:30") selected @endif>06:30 AM</option>
            <option value="07:00" @if($schedule->book_before_time == "07:00") selected @endif>07:00 AM</option>
            <option value="07:30" @if($schedule->book_before_time == "07:30") selected @endif>07:30 AM</option>
            <option value="08:00" @if($schedule->book_before_time == "08:00") selected @endif>08:00 AM</option>
            <option value="08:30" @if($schedule->book_before_time == "08:30") selected @endif>08:30 AM</option>
            <option value="09:00" @if($schedule->book_before_time == "09:00") selected @endif>09:00 AM</option>
            <option value="09:30" @if($schedule->book_before_time == "09:30") selected @endif>09:30 AM</option>
            <option value="10:00" @if($schedule->book_before_time == "10:00") selected @endif>10:00 AM</option>
            <option value="10:30" @if($schedule->book_before_time == "10:30") selected @endif>10:30 AM</option>
            <option value="11:00" @if($schedule->book_before_time == "11:00") selected @endif>11:00 AM</option>
            <option value="11:30" @if($schedule->book_before_time == "11:30") selected @endif>11:30 AM</option>
            </select>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-3">
                       <button type="submit" class="btn btn-success">Submit</button>
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

<!-- Modal -->

@endsection

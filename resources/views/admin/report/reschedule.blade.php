@extends('admin.layout.master')
@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('content')
 <div class="container card">
    <div class="row">
        <div class="col-12">

            <div class="card-body">
                    <div class="row">
                          <div class="col-md-12">
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
                                    <form name="f1" action="{{route('admin.report.reschedule.store')}}" method="POST">
                        @csrf
                                        <input type="hidden" name="booking_id" value="{{$bookingDetails->id}}">
                        <input type="hidden" name="clinic_id" value="{{$bookingDetails->schedule->clinic_id}}">
                        <input type="hidden" name="schedule_id" value="{{$bookingDetails->schedule->id}}">
                        <input type="hidden" name="doctor_id" value="{{$bookingDetails->doctor_id}}">
                        <h3>Transaction ID : {{$bookingDetails->transaction_id}}</h3>
                        <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                Patient Name
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="{{$bookingDetails->patient_name}}" name="patient_name" required>
                            </div>
                        </div>
                        </div>

                        <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                Patient Phone
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="{{$bookingDetails->patient_phone}}" name="patient_phone" required>
                            </div>
                        </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    Original Date
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" readonly value="{{date('d-m-Y',strtotime($bookingDetails->date))}}" name="date" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    Original Time
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" readonly value="{{$bookingDetails->slot}}" name="time" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    Shift Date
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="" name="shift_date" id="shift_date" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    Shift Time
                                </div>
                                <div class="col-md-6">
                                    <select name="slot_id" id="time" class="form-control" required>
                                        <option value="">Select Time</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Re Schedule Now</button>
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
 $('#shift_date').datepicker({
    dateFormat: 'dd-mm-yy',
    beforeShowDay: available,
    onSelect: function(){
      $('#time').html('');
      var doctor_id = {{$bookingDetails->doctor_id}};
      var date = $('#shift_date').val();
      var clinic_id = {{$bookingDetails->schedule->clinic_id}};
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

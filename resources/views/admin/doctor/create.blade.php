@extends('admin.layout.master')
@section('css')
<style>

        fieldset { border:none; width:100%;}
        legend { font-size:18px; margin:0px; padding:10px 0px; color:#b0232a; font-weight:bold;}
        label { display:block; margin:15px 0 5px;}
               button, .prev, .next { background-color:#b0232a; padding:5px 10px; color:#fff; text-decoration:none;}
        button:hover, .prev:hover, .next:hover { background-color:#000; text-decoration:none;}

    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/validationEngine.jquery.min.css" />
    <style>
        .prev{float:left}
        .next{float:right}
        .steps{list-style:none;width:100%;overflow:hidden;margin:0;padding:0}
        .steps li{color:#b0b1b3;font-size:24px;float:left;padding:10px;transition:all .3s;-moz-transition:all .3s;-webkit-transition:all .3s;-o-transition:all .3s}
        .steps li span{font-size:11px;display:block}
        .steps li.current{color:#000}
        .breadcrumb{height:37px}
        .breadcrumb li{background:#eee;font-size:14px}
        .breadcrumb li.current:after{border-top:18px solid transparent;border-bottom:18px solid transparent;border-left:6px solid #666;content:' ';position:absolute;top:0;right:-6px}
        .breadcrumb li.current{background:#666;color:#eee;position:relative}
        .breadcrumb li:last-child:after{border:none}
        .row.child{
            margin-top: 5px;
        }
    </style>
	<link rel="stylesheet" href="{{asset('public/css/bootstrap-material-datetimepicker.css')}}" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

@endsection
@section('content')
 <div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
              <h1 class="page-title">
                Doctor Master
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


                            <form name="city" action="{{route('admin.doctor.store')}}" method="POST" id="SignupForm" enctype="multipart/form-data">
                            @csrf
                          <fieldset>
                            <legend>Basic information</legend>

                            <div class="form-group">
                            <div class="row">
                                  <div class="col-md-2">Name</div>
                                  <div class="col-md-6">
                                    <input type="text" name="name" class="form-control validate[required]" value="{{old('name')}}">
                                  </div>
                             </div>
                             </div>

                             <div class="form-group">
                            <div class="row">
                                  <div class="col-md-2">Email</div>
                                  <div class="col-md-6">
                                    <input type="text" name="email" class="form-control" value="{{old('email')}}">
                                  </div>
                             </div>
                             </div>

                             <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Phone No</div>
                                  <div class="col-md-6">
                                    <input type="number" name="phone_no" class="form-control" value="{{old('phone_no')}}">
                                  </div>
                             </div>
                           </div>


                          <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Department</div>
                                  <div class="col-md-6">
                                    <select name="department_id" class="form-control validate[required]">
                                      <option value="">Select</option>
                                      @foreach($departments as $department)
                                      <option value="{{$department->id}}" @if(old('department_id') == $department->id) selected @endif>{{$department->name}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                             </div>
                           </div>


                            <div class="form-group">
                             <div class="row">
                                  <div class="col-md-2">Home City</div>
                                  <div class="col-md-6">
                                    <input type="text" name="current_city" value="" class="form-control validate[required]" value="{{old('current_city')}}">
                                  </div>
                             </div>
                           </div>

                         </fieldset>


                          <fieldset>
                            <legend>Academic & fees information</legend>
                            <div class="form-group">
                            <div class="row">
                                  <div class="col-md-2">Qualification</div>
                                  <div class="col-md-6">
                                    <input type="text" name="qualification" class="form-control validate[required]" value="{{old('qualification')}}">
                                  </div>
                             </div>
                             </div>

                             <div class="form-group">
                              <div class="row">
                                    <div class="col-md-2">Experience</div>
                                    <div class="col-md-3">
                                      <select name="year" class="form-control validate[required]">
                                        <option value="">Select</option>

                                        @for($i=0;$i<=10;$i++)
                                        <option value="{{$i}}" @if(old('year') == $i) selected @endif>{{$i}} Year</option>
                                        @endfor

                                      </select>
                                    </div>

                                    <div class="col-md-3">
                                      <select name="month" class="form-control validate[required]">
                                        <option value="">Select</option>
                                        @for($i=1;$i<=12;$i++)
                                        <option value="{{$i}}" @if(old('month') == $i) selected @endif>{{$i}} Months</option>
                                        @endfor
                                      </select>
                                    </div>
                               </div>
                             </div>


                          <div class="form-group">
                              <div class="row">
                                    <div class="col-md-2">Licence no</div>
                                    <div class="col-md-6">
                                      <input type="text" name="licence_no" id="licence_no" class="form-control" value="{{old('licence_no')}}">
                                    </div>
                               </div>
                          <div>



                          <div class="form-group">
                              <div class="row">
                                    <div class="col-md-2">Fees Mode</div>
                                    <div class="col-md-6">
                                      <select name="fees_online"  class="form-control validate[required]">
                                        <option value="">Select</option>
                                        <option value="0" @if(old('fees_online') == 0) selected @endif>Offline</option>
                                        <option value="1" @if(old('fees_online') == 1) selected @endif>Online</option>

                                      </select>
                                    </div>
                               </div>
                          </div>
                         </fieldset>

                         <fieldset>
                            <legend>Schedule information</legend>




                          <div class="form-group">
                              <div class="row">
                                    <div class="col-md-2">Dr Available</div>
                                    <div class="col-md-6">
                                      <select name="dr_available_days" class="form-control" required>
                                      	<option value="">No of Weeks</option>
                                      	@for($i=1;$i<30;$i++)
                                      	<option value="{{$i}}"  @if(old('dr_available_days') == $i) selected @endif>{{$i}}</option>
                                      	@endfor
	                                     </select>
                                    </div>
                               </div>
                          </div>

                                <div class="row">
                                    <div class="col-md-2">Days</div>
                                    <div class="col-md-10">
                                    	<div class="row">
                                            <div class="col-md-12 week_days">
                                                <input type="checkbox" name="days[]" id="day" class="validate[required]" value="Sunday" onclick="getSubItem(this)">
                                                Sunday
                                                <div class="parent" id="">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 week_days">
                                                <input type="checkbox" name="days[]" id="day" class="validate[required]" value="Monday"
                                                    onclick="getSubItem(this)">
                                                Mondays
                                                <div class="parent" id="monday_timepicker_parent">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 week_days">
                                                <input type="checkbox" name="days[]"  id="day" class="validate[required]" value="Tuesday" onclick="getSubItem(this)">
                                                Tuesday
                                                <div class="parent" id="">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 week_days">
                                                <input type="checkbox" name="days[]" id="day" class="validate[required]" value="Wednesday"  onclick="getSubItem(this)">
                                                Wednesday
                                                <div class="parent" id="">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 week_days">
                                                <input type="checkbox" name="days[]" id="day" class="validate[required]" value="Thursday"  onclick="getSubItem(this)">
                                                Thursday
                                                <div class="parent" id="">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 week_days">
                                                <input type="checkbox" name="days[]" id="day" class="validate[required]" value="Friday" onclick="getSubItem(this)">
                                                Friday
                                                <div class="parent" id="">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 week_days">
                                                <input type="checkbox" name="days[]" id="day" class="validate[required]" value="Saturday" onclick="getSubItem(this)">
                                                Saturday
                                                <div class="parent" id="">

                                                </div>
                                            </div>
                                        </div>



                                        <div class="form-group">
                                        <div class="row">
                                              <div class="col-md-2">Picture</div>
                                              <div class="col-md-6">
                                                <input type="file" name="picture" id="picture" class="validate[required]">
                                              </div>
                                         </div>
                                       </div>

                                       <div class="form-group">
    			                              <div class="row">
    			                                    <div class="col-md-2">Special Doctors</div>
    			                                    <div class="col-md-6">
    			                                      <input type="radio" name="special_doctor" id="special_doctor" class="validate[required]" value="1"> Yes

    			                                      <input type="radio" name="special_doctor" id="special_doctor" class="validate[required]" value="0"> NO
    			                                    </div>
    			                               </div>
			                                 </div>

                                        <div class="row">
                                            <div class="col-md-12 week_days">
                                               <button type="submit" class="btn">Finish</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                         </fieldset>

                           {{-- <div class="form-group">
                             <div class="row">

                                  <div class="col-md-6 col-md-offset-4">
                                   <button type="submit" class="btn btn-primary">Submit</button>
                                  </div>
                             </div>
                           </div> --}}
                            </form>
                          </div>



                    </div>
            </div>

        </div>
    </div>

</div>
@endsection
@section('js')

<script src="{{asset('public/js/jquery.formtowizard.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-en.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/material.min.js"></script>
<script type="text/javascript" src="{{asset('public/js/bootstrap-material-datetimepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('public/assets/js/moment.js')}}"></script>
    <script>
      x=0;
        function getSubItem(Obj){
            var $this = $(Obj);
            var checkbox_value = $(Obj).val();
            var html_data = $(get_row_data(checkbox_value));
                html_data.find(".remove_me").remove();
                html_data.hide();
            if($this.prop('checked') == true){

                $this.parents(".row").eq(0).find(".parent").append(html_data);
                $this.parents(".row").eq(0).find(".parent").find(".child:first").show("slow");
            } else{
                $this.parents(".row").eq(0).find(".parent").find(".child").hide("slow", function(){
                    $(this).remove();
                });
            }
        }
        function AddMore(Obj){
            var $this = $(Obj);
            var checkbox_value = $this.parents(".week_days").find("#day").val();
            var html_data = $(get_row_data(checkbox_value));
                html_data.find(".add_more").remove();
                html_data.hide();
            var current_child = $this.parents(".child");
            var currnet_child_parent = current_child.parents(".parent");
            currnet_child_parent.append(html_data);
            currnet_child_parent.find(".child:last").show("slow");
        }
        function RemoveMe(Obj){
            var $this = $(Obj);
            $this.parents(".child").hide("slow", function(){
                $(this).remove();
            })
        }

        function getClinic(obj){
          $obj = $(obj);
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

             $.ajax({
               type:'POST',
               url:'{{route("admin.city.ajax.clinic")}}',
               dataType:'json',
               data:{"id":$obj.val()},
               success:function(data){
                let loc = "<option value=''>Select Clinic</option>";
                 $.each(data,function(k,v){
                    loc += "<option value='"+v.id+"'>"+v.name+"</option>";
                 });
                 $obj.parents('.child').find('.clinic').html(loc);
               },
              error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                  console.log(JSON.stringify(jqXHR));
                  console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
              }
            });
        }

        function gettimedata(start){
            // $this = $(obj);
             console.log(start);
            $('#'+start).bootstrapMaterialDatePicker
            ({
              date: false,
              shortTime: false,
              format: 'HH:mm'
            });
            $.material.init();
        }


        function get_row_data(checkbox_value){
            var start = "start_time"+x;
            var data = '<div class="row child">';
            data += '<div class="col-md-2">';
            data += '<select name="schedule['+checkbox_value+'][starttime][]"  class="form-control" required="true">';
            data += '<option value="">Start Time</option>';
            data += '<option value="12:00">12:00 PM</option>';
            data += '<option value="12:30">12:30 PM</option>';
            data += '<option value="13:00">01:00 PM</option>';
            data += '<option value="13:30">01:30 PM</option>';
            data += '<option value="14:00">02:00 PM</option>';
            data += '<option value="14:30">02:30 PM</option>';
            data += '<option value="15:00">03:00 PM</option>';
            data += '<option value="15:30">03:30 PM</option>';
            data += '<option value="16:00">04:00 PM</option>';
            data += '<option value="16:30">04:30 PM</option>';
            data += '<option value="17:00">05:00 PM</option>';
            data += '<option value="17:30">05:30 PM</option>';
            data += '<option value="18:00">06:00 PM</option>';
            data += '<option value="18:30">06:30 PM</option>';
            data += '<option value="19:00">07:00 PM</option>';
            data += '<option value="19:30">07:30 PM</option>';
            data += '<option value="20:00">08:00 PM</option>';
            data += '<option value="20:30">08:30 PM</option>';
            data += '<option value="21:00">09:00 PM</option>';
            data += '<option value="21:30">09:30 PM</option>';
            data += '<option value="22:00">10:00 PM</option>';
            data += '<option value="22:30">10:30 PM</option>';
            data += '<option value="23:00">11:00 PM</option>';
            data += '<option value="23:30">11:30 PM</option>';
            data += '<option value="00:00">12:00 AM</option>';
            data += '<option value="00:30">12:30 AM</option>';
            data += '<option value="01:00">01:00 AM</option>';
            data += '<option value="01:30">01:30 AM</option>';
            data += '<option value="02:00">02:00 AM</option>';
            data += '<option value="02:30">02:30 AM</option>';
            data += '<option value="03:00">03:00 AM</option>';
            data += '<option value="03:30">03:30 AM</option>';
            data += '<option value="04:00">04:00 AM</option>';
            data += '<option value="04:30">04:30 AM</option>';
            data += '<option value="05:00">05:00 AM</option>';
            data += '<option value="05:30">05:30 AM</option>';
            data += '<option value="06:00">06:00 AM</option>';
            data += '<option value="06:30">06:30 AM</option>';
            data += '<option value="07:00">07:00 AM</option>';
            data += '<option value="07:30">07:30 AM</option>';
            data += '<option value="08:00">08:00 AM</option>';
            data += '<option value="08:30">08:30 AM</option>';
            data += '<option value="09:00">09:00 AM</option>';
            data += '<option value="09:30">09:30 AM</option>';
            data += '<option value="10:00">10:00 AM</option>';
            data += '<option value="10:30">10:30 AM</option>';
            data += '<option value="11:00">11:00 AM</option>';
            data += '<option value="11:30">11:30 AM</option>';
            data += '</select>';
            data += '</div>';
            data += '<div class="col-md-2">';
            data += '<select name="schedule['+checkbox_value+'][endtime][]"  class="form-control"  required="true">';
            data += '<option value="">End Time</option>';
            data += '<option value="12:00">12:00 PM</option>';
            data += '<option value="12:30">12:30 PM</option>';
            data += '<option value="13:00">01:00 PM</option>';
            data += '<option value="13:30">01:30 PM</option>';
            data += '<option value="14:00">02:00 PM</option>';
            data += '<option value="14:30">02:30 PM</option>';
            data += '<option value="15:00">03:00 PM</option>';
            data += '<option value="15:30">03:30 PM</option>';
            data += '<option value="16:00">04:00 PM</option>';
            data += '<option value="16:30">04:30 PM</option>';
            data += '<option value="17:00">05:00 PM</option>';
            data += '<option value="17:30">05:30 PM</option>';
            data += '<option value="18:00">06:00 PM</option>';
            data += '<option value="18:30">06:30 PM</option>';
            data += '<option value="19:00">07:00 PM</option>';
            data += '<option value="19:30">07:30 PM</option>';
            data += '<option value="20:00">08:00 PM</option>';
            data += '<option value="20:30">08:30 PM</option>';
            data += '<option value="21:00">09:00 PM</option>';
            data += '<option value="21:30">09:30 PM</option>';
            data += '<option value="22:00">10:00 PM</option>';
            data += '<option value="22:30">10:30 PM</option>';
            data += '<option value="23:00">11:00 PM</option>';
            data += '<option value="23:30">11:30 PM</option>';
            data += '<option value="00:00">12:00 AM</option>';
            data += '<option value="00:30">12:30 AM</option>';
            data += '<option value="01:00">01:00 AM</option>';
            data += '<option value="01:30">01:30 AM</option>';
            data += '<option value="02:00">02:00 AM</option>';
            data += '<option value="02:30">02:30 AM</option>';
            data += '<option value="03:00">03:00 AM</option>';
            data += '<option value="03:30">03:30 AM</option>';
            data += '<option value="04:00">04:00 AM</option>';
            data += '<option value="04:30">04:30 AM</option>';
            data += '<option value="05:00">05:00 AM</option>';
            data += '<option value="05:30">05:30 AM</option>';
            data += '<option value="06:00">06:00 AM</option>';
            data += '<option value="06:30">06:30 AM</option>';
            data += '<option value="07:00">07:00 AM</option>';
            data += '<option value="07:30">07:30 AM</option>';
            data += '<option value="08:00">08:00 AM</option>';
            data += '<option value="08:30">08:30 AM</option>';
            data += '<option value="09:00">09:00 AM</option>';
            data += '<option value="09:30">09:30 AM</option>';
            data += '<option value="10:00">10:00 AM</option>';
            data += '<option value="10:30">10:30 AM</option>';
            data += '<option value="11:00">11:00 AM</option>';
            data += '<option value="11:30">11:30 AM</option>';
            data += '</select>';
            data += '</div>';
            data += '<div class="col-md-2">';
            data += '<select name="schedule['+checkbox_value+'][region_id][]" class="form-control" onchange="getClinic(this)"  required="true"><option value="">Location</option> @foreach($cities as $city)<option value="{{$city->id}}">{{$city->name}}</option>@endforeach</select>';
            data += '</div>';
            data += '<div class="col-md-2">';
            data += '<select name="schedule['+checkbox_value+'][clinic_id][]" class="form-control clinic"  required="true"><option value="">Clinic</option></select>';
            data += '</div>';
            data += '<div class="row">';
            data += '<div class="col-md-3">';
            data += '<input type="number" name="schedule['+checkbox_value+'][max_booking][]" class="form-control"  required="true" placeholder="Max Booking">';
            data += '</div>';

            data += '<div class="col-md-3">';
            data += '<select name="schedule['+checkbox_value+'][book_before_days][]"  class="form-control"  required="true">';
            data += '<option value="">Before Days</option>';
            data += '<option value="0">0</option>';
            data += '<option value="1">1</option>';
            data += '<option value="2">2</option>';
            data += '<option value="3">3</option>';
            data += '<option value="4">4</option>';
            data += '<option value="5">5</option>';
            data += '<option value="6">6</option>';
            data += '<option value="7">7</option>';
            data += '<option value="8">8</option>';
            data += '<option value="9">9</option>';
            data += '<option value="10">10</option>';
            data += '</select>';
            data += '</div>';

            data += '<div class="col-md-3">';
            data += '<select name="schedule['+checkbox_value+'][book_before_time][]"  class="form-control"  required="true">';
            data += '<option value="">Before Time</option>';
            data += '<option value="12:00">12:00 PM</option>';
            data += '<option value="13:00">01:00 PM</option>';
            data += '<option value="14:00">02:00 PM</option>';
            data += '<option value="15:00">03:00 PM</option>';
            data += '<option value="16:00">04:00 PM</option>';
            data += '<option value="17:00">05:00 PM</option>';
            data += '<option value="18:00">06:00 PM</option>';
            data += '<option value="19:00">07:00 PM</option>';
            data += '<option value="20:00">08:00 PM</option>';
            data += '<option value="21:00">09:00 PM</option>';
            data += '<option value="22:00">10:00 PM</option>';
            data += '<option value="23:00">11:00 PM</option>';
            data += '<option value="00:00">12:00 AM</option>';
            data += '<option value="01:00">01:00 AM</option>';
            data += '<option value="02:00">02:00 AM</option>';
            data += '<option value="03:00">03:00 AM</option>';
            data += '<option value="04:00">04:00 AM</option>';
            data += '<option value="05:00">05:00 AM</option>';
            data += '<option value="06:00">06:00 AM</option>';
            data += '<option value="07:00">07:00 AM</option>';
            data += '<option value="08:00">08:00 AM</option>';
            data += '<option value="09:00">09:00 AM</option>';
            data += '<option value="10:00">10:00 AM</option>';
            data += '<option value="11:00">11:00 AM</option>';
            data += '</select>';
            data += '</div>';

            data += '<div class="col-md-2">';
            data += '<select name="schedule['+checkbox_value+'][sms_time][]"  class="form-control"  required="true">';
            data += '<option value="">SMS Time</option>';
            data += '<option value="12:00">12:00 PM</option>';
            data += '<option value="12:30">12:30 PM</option>';
            data += '<option value="13:00">01:00 PM</option>';
            data += '<option value="13:30">01:30 PM</option>';
            data += '<option value="14:00">02:00 PM</option>';
            data += '<option value="14:30">02:30 PM</option>';
            data += '<option value="15:00">03:00 PM</option>';
            data += '<option value="15:30">03:30 PM</option>';
            data += '<option value="16:00">04:00 PM</option>';
            data += '<option value="16:30">04:30 PM</option>';
            data += '<option value="17:00">05:00 PM</option>';
            data += '<option value="17:30">05:30 PM</option>';
            data += '<option value="18:00">06:00 PM</option>';
            data += '<option value="18:30">06:30 PM</option>';
            data += '<option value="19:00">07:00 PM</option>';
            data += '<option value="19:30">07:30 PM</option>';
            data += '<option value="20:00">08:00 PM</option>';
            data += '<option value="20:30">08:30 PM</option>';
            data += '<option value="21:00">09:00 PM</option>';
            data += '<option value="21:30">09:30 PM</option>';
            data += '<option value="22:00">10:00 PM</option>';
            data += '<option value="22:30">10:30 PM</option>';
            data += '<option value="23:00">11:00 PM</option>';
            data += '<option value="23:30">11:30 PM</option>';
            data += '<option value="00:00">12:00 AM</option>';
            data += '<option value="00:30">12:30 AM</option>';
            data += '<option value="01:00">01:00 AM</option>';
            data += '<option value="01:30">01:30 AM</option>';
            data += '<option value="02:00">02:00 AM</option>';
            data += '<option value="02:30">02:30 AM</option>';
            data += '<option value="03:00">03:00 AM</option>';
            data += '<option value="03:30">03:30 AM</option>';
            data += '<option value="04:00">04:00 AM</option>';
            data += '<option value="04:30">04:30 AM</option>';
            data += '<option value="05:00">05:00 AM</option>';
            data += '<option value="05:30">05:30 AM</option>';
            data += '<option value="06:00">06:00 AM</option>';
            data += '<option value="06:30">06:30 AM</option>';
            data += '<option value="07:00">07:00 AM</option>';
            data += '<option value="07:30">07:30 AM</option>';
            data += '<option value="08:00">08:00 AM</option>';
            data += '<option value="08:30">08:30 AM</option>';
            data += '<option value="09:00">09:00 AM</option>';
            data += '<option value="09:30">09:30 AM</option>';
            data += '<option value="10:00">10:00 AM</option>';
            data += '<option value="10:30">10:30 AM</option>';
            data += '<option value="11:00">11:00 AM</option>';
            data += '<option value="11:30">11:30 AM</option>';
            data += '</select>';
            data += '</div>';

            data += '<div class="col-md-1 add_more">';
            data += '<button type="button" class="btn btn-sm btn-primary" onclick="AddMore(this)" data-toggle="tooltip" data-title="Add More"><span class="fa fa-plus-circle" aria-hidden="true"></span></button>';
            data += '</div>';
            data += '<div class="col-md-1 remove_me">';
            data += '<button type="button" class="btn btn-sm btn-danger" onclick="RemoveMe(this)" data-toggle="tooltip"  data-title="Remove"><span class="fa fa-times-circle" aria-hidden="true"></span></button>';
            data += '</div>';
            data += '</div>';
            data += '</div>';
            x++;

            return data;


        }

        $( function() {
            var $signupForm = $( '#SignupForm' );

            $signupForm.validationEngine();

            $signupForm.formToWizard({
                submitButton: 'SaveAccount',
                showProgress: true, //default value for showProgress is also true
                nextBtnName: 'Forward >>',
                prevBtnName: '<< Previous',
                showStepNo: false,
                validateBeforeNext: function() {
                    return $signupForm.validationEngine( 'validate' );
                }
            });


            $( '#txt_stepNo' ).change( function() {
                $signupForm.formToWizard( 'GotoStep', $( this ).val() );
                $.material.init();
            });

            $( '#btn_next' ).click( function() {
                $signupForm.formToWizard( 'NextStep' );
                $.material.init();
            });

            $( '#btn_prev' ).click( function() {
                $signupForm.formToWizard( 'PreviousStep' );
                $.material.init();
            });
        });

        // $('#licence_no').bootstrapMaterialDatePicker
        //     ({
        //       date: false,
        //       shortTime: false,
        //       format: 'HH:mm'
        //     });
        //     $.material.init();
  </script>
@endsection

@extends('world.layout.master')
<!-- slider -->
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('public/css/style.css')}}">
@endsection
@section('content')
<section class="main-slider-banner">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 text-center appointment-block" style="margin: 0 auto;">
        <img src="{{asset('public/vendor/images/title.png')}}"
        <p><strong style="color:#3e4095; font-size:24px;display:block">Hello Visitors </strong> <br>
         <strong>Find your Doctor with us.
         For any query contact us - 
         8812907328/8876657929 <br>
       You can also mail us at info@bookurdoc.com</strong></p> 

       <form class="doctor-search" method="get" action="{{route('department')}}" autocomplete="off">
        <div class="row">
          <div class="col-md-3  doctor-search">
            <select name="region" id="region" class="form-control">
              @foreach($regions as $key=>$region)
              <option value="{{$region->id}}">{{$region->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-9  doctor-search">
            <input class="typeahead form-control" name="search" id="sea" type="text" placeholder=" Doctor Name/Specialization/Clinics ">   
            <ul id="searchResult"></ul>
          </div>

        </div>
      </form>



    </div>
  </div>
</div>
</section>

<section class="specialities">  
  <div class="container">

    <div class="row title-head">
      <div class="col-md-12 text-center"> <h3> Specialities </h3></div>
    </div>

    <div class="row">

      @php
      $rowCount = 0;
      @endphp
      @foreach($departments as $key=>$department)
      <div class="col-md-3">
        <a href="{{route('department-doctor',$department->slug)}}"> 
          <div class="spel-block">
            <figure><img title="{{$department->name}}" alt="{{$department->name}}" src="{{asset('public/images/'.$department->picture)}}" class="img-responsive"></figure>
            <span> {{$department->name}} </span>
          </div>
        </a>
      </div>
      @php
      $rowCount++;
      @endphp

      @if($rowCount % 4 == 0)
    </div><div class='row' style='margin-top: 20px'>
      @endif    
      @endforeach    


    </div>


  </div>
</section>  
@endsection

@section('js')
<script type="text/javascript" src="{{asset('public/js/script.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
<script type="text/javascript">
  $("#sea").keyup(function(){
  var min_length = 3; // min caracters to display the autocomplete
  var region = $('#region').val();
  var path = "{{ route('autocomplete') }}";
  var search = $(this).val();
  if (search.length >= min_length) {
    $.ajax({
      url: path,
      type: 'get',
      data: {region:region,search:search},
      dataType: 'json',
      success:function(response){
                  //console.log(response);
                  var len = response.length;
                  $("#searchResult").empty();
                  for( var i=0; i<len; i++){
                    var id = response[i]['id'];
                    var name = response[i]['name'];
                    var slug = response[i]['slug'];
                    $("#searchResult").append("<li value='"+slug+"' class='"+response[i]['type']+"'>"+name+"</li>");
                  }
                  $("#searchResult li").bind("click",function(){
                    setText(this);
                  });
                },
                error:function(response){
                  console.log(response);
                }
              });
  }
  else{
    $("#searchResult").empty();
  }
});    

  function setText(element){
    console.log(element);
    var value = $(element).text();
    var id = $(element).attr('value');
    var type = $(element).attr('class');
    $("#sea").val(id);
    $("#searchResult").empty();
    if(type == "doctor"){
      var url = '{{ route("doctor", ":id") }}';
      url = url.replace(':id', id);
      $.blockUI({ message: null }); 
      window.location = url;
    }
    else if(type == "department"){
      var url = '{{ route("department-doctor", ":id") }}';
      url = url.replace(':id', id);
      $.blockUI({ message: null }); 
      window.location = url;
    }
  }
</script>
@endsection


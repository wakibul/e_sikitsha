@extends('admin.layout.master')
@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
#list li {
	margin: 0 0 3px;
	padding:8px;
	background-color:#333;
	color:#fff;
	list-style: none;
}
</style>
@endsection
@section('js')

<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
          function slideout(){
      setTimeout(function(){
      $("#response").slideUp("slow", function () {
          });

    }, 2000);}

        $("#response").hide();
        $(function() {
        $("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {

                var order = $(this).sortable("serialize") + '&update=update';
                $.get("{{route('admin.department.post_order')}}", order, function(theResponse){
                    $("#response").html(theResponse);
                    $("#response").slideDown('slow');
                    slideout();
                });
            }
            });
        });

    });
    </script>

@endsection
@section('content')
 <div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
              <h1 class="page-title">
                Department Ordering
              </h1>
            </div>
            <div class="card-body">
                    <div class="row">

                          <div class="col-md-6"  id="list">
                              <div id="response"></div>
                                <ul>
                                    @forelse($departments as $key=>$department)
                                    <li id="arrayorder_{{$department->id}}">{{$department->name}}</li>
                                    @empty
                                    <li>No departments found</li>
                                    @endforelse
                                </ul>
                        </div>

                    </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('js')


@endsection

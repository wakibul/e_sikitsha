<script src="{{asset('public/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('public/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script>
$( document ).ready(function() {
   @if (count($errors) > 0)
    $('#modalLRForm').modal('show');
    $("#danger-alert").fadeTo(2000, 500).slideUp(500, function(){
	    $("#danger-alert").slideUp(500);
	});
  @endif
});
</script>
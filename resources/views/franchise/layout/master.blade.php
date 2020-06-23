<!doctype html>
<html lang="en" dir="ltr">
  <head>
    @include('franchise.layout.head')
    @yield('css')
  </head>
  <body class="">
    <div class="page">
      <div class="page-main">
         @include('franchise.layout.header')
        <div class="my-3 my-md-5">
        	@yield('content')
        </div>
      </div>
       @include('franchise.layout.footer')
    </div>
    @include('franchise.layout.js')
    @yield('js')
    <script>
      function conf(){
        let x = confirm("Are you sure to delete?");
        if(x)
          return true;
        else
          return false;
      }
    </script>
   </body>
 </html>

  @extends('world.layout.master')
      <!-- slider -->

  @section('content')

  <section class="doctors-block">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center appointment-block" style="margin: 0 auto;">
            <h1> Payment error </h1>

  </div>

          </div>
        </div>
      </div>
    </section>

  <section id="recomended_doctors" class="pb-5">
  <div class="container">

  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        @if (session()->has('error'))
        <div class="alert alert-danger">
                {{session()->get('error')}}
        </div>
    @endif
    </div>
  </div>
  </div>
  </section>
  @endsection

  @section('js')
  @endsection


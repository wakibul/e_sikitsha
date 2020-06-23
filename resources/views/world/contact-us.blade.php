    @extends('world.layout.master')
        <!-- slider -->

    @section('content')

    <section class="doctors-block">
        <div class="container">
            <div class="row">
            <div class="col-lg-12 text-center appointment-block" style="margin: 0 auto;">
                <h1> Contact Us </h1>

                </div>
            </div>
            </div>
        </div>
        </section>

    <section id="recomended_doctors" class="pb-5">
    <div class="container">

    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <h3>Contact Us</h3>
             <b>Silchar</b>
             <p><b>District</b> - Cachar</p>
             <p><b>State </b> - Assam</p>
             <p><b>Email  </b> - info@bookurdoc.com, bookurdocofficial@gmail.com</p>
             <p><b>Contact </b> - 8812907328 | 8876657929</p>
             <p><b>URL</b> - www.bookurdoc.com</p>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8">
            <h3>Contact/Feedback Form</h3>
            @if(Session::has('message'))
            <div class="alert alert-success">{!! Session::get('message') !!}</div>
            @endif
            <form class="form-horizontal" name="feedback" action="{{route('send_feedback')}}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-3">Name</label>
                        <div class="col-md-9"><input type="text" class="form-control" name="name" required></div>
                    </div>   
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-md-3">Email</label>
                        <div class="col-md-9"><input type="email" class="form-control" name="email" required></div>
                    </div>   
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-md-3">Feedback/Query</label>
                        <div class="col-md-9"><textarea  class="form-control" name="complaint" rows="5" required></textarea></div>
                    </div>   
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-md-3"></label>
                        <div class="col-md-9"><button  type="submit" class="btn btn-success" name="feedback">Submit</button></div>
                    </div>   
                </div>
                
            </form>
        </div>
    </div>
    </div>
    </section>
    @endsection

    @section('js')
    @endsection


<div class="header py-4">
          <div class="container">
            <div class="d-flex">
              <a class="header-brand" href="#">
                <img src="{{asset('public/logo.png')}}" class="header-brand-img" alt="tabler logo">
              </a>
              <div class="d-flex order-lg-2 ml-auto">


                <div class="dropdown">
                  <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                    <span class="avatar" style="background-image: url({{asset('public/logo.png')}})"></span>
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default">{{Auth::user()->name}}</span>

                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

                    <a class="dropdown-item"  href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                      <i class="dropdown-icon fe fe-log-out"></i> Sign out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                  </div>
                </div>
              </div>
              <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
              </a>
            </div>
          </div>
        </div>
        <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <div class="row align-items-center">

              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                  <li class="nav-item">
                    <a href="{{url('/franchise')}}" class="nav-link active"><i class="fe fe-home"></i> Home</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('/')}}" class="nav-link active"><i class="fe fe-home"></i> Book a doctor</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

@extends('admin.layout.master')

@section('content')
 <div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
              <h1 class="page-title">
               Franchise List
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
                          <table class="table">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Current Amount</th>
                                <th>Created on</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse($users as $key=>$user)
                              <tr>
                                <td>

                                 {{ $key+ 1 + ($users->perPage() * ($users->currentPage() - 1)) }}

                              </td>
                                <td>{{$user->name}}</td>

                                <td>{{$user->phone}}</td>
                                <td>{{$user->email}}</td>
                                <td>Rs. {{$user->amount}}</td>
                                <td>{{ date('d-M-Y h:i a',strtotime($user->created_at))}}</td>
                                <td>
                                @if($user->status == 1)
                                <a href="{{route('admin.franchise.suspend',Crypt::encrypt($user->id))}}" onclick="return sus()" class="btn btn-warning btn-sm">Supend <i class="fa fa-exclamation-triangle"></i></a>
                                @else
                                <a href="{{route('admin.franchise.activate',Crypt::encrypt($user->id))}}" onclick="return act()" class="btn btn-success btn-sm">Activate <i class="fa fa-arrow-right"></i></a>
                                @endif
                                <a href="{{route('admin.franchise.booking',Crypt::encrypt($user->id))}}" class="btn btn-success btn-sm">Bookings <i class="fa fa-arrow-right"></i></a>
                                <a href="{{route('admin.franchise.view_transaction',Crypt::encrypt($user->id))}}" class="btn btn-primary btn-sm">Recharge <i class="fa fa-arrow-right"></i></a>
                                </td>

                              </tr>
                              @empty
                              <tr>
                              <td colspan="8" class="alert alert-danger">
                                No record available
                              </td>
                              </tr>
                              @endforelse
                            </tbody>
                          </table>
                          {{$users->links()}}
                        </div>
                    </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('js')
<script type="text/javascript">
  function sus(){
    var x = confirm('Are you sure to suspend the user?');
    if(x)
      return true;
    else
      return false;
  }

  function act(){
    var x = confirm('Are you sure to activate the user?');
    if(x)
      return true;
    else
      return false;
  }
</script>
@endsection

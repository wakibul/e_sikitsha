@extends('admin.layout.master')

@section('content')
 <div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
              <h1 class="page-title">
                Franchise Recharge
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
                        <form name="franchise" action="{{route('admin.franchise.recharge',request()->id)}}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-1">Amount</div>
                            <div class="col-md-2"><input type="number" name="recharge_amount" class="form-control"></div>
                            <div class="col-md-2">
                                <button type="submit" name="submit" class="btn btn-primary"> Recharge Now
                            </div>
                        </div>
                        </form>
                      </div>
                </div>
            </div>
            <div class="card-body">
                    <div class="row">
                          <div class="col-md-12 col-lg-12">
                              <h3>Recharge Transaction</h3>
                            <form name="franchise" action="{{route('admin.franchise.filter_transaction',request()->id)}}" method="GET">
                            @csrf
                            <div class="form-group">
                            <div class="row">
                                  <div class="col-md-1">From Date</div>
                                  <div class="col-md-2">
                                    <input type="text" name="from_date" class="form-control datepicker" readOnly="true" value="{{Request('from_date')}}" required>
                                  </div>

                                  <div class="col-md-1">To Date</div>
                                  <div class="col-md-2">
                                    <input type="text" name="to_date" class="form-control datepicker"  readOnly="true"  value="{{Request('to_date')}}" required>
                                  </div>

                                  <div class="col-md-2">
                                    <button type="submit" class="btn btn-success">Filter </button>
                                  </div>
                             </div>
                             </div>
                            </form>
                          </div>
                    </div>
            </div>

            @if(isset($rechargeTransaction))
            <div class="row">
                <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap">
        <thead>
          <tr>
            <th class="w-1">Sl.</th>
            <th>Transaction Date</th>
            <th>Type</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody>


          @forelse($rechargeTransaction as $key=>$trans)
          <tr>
            <td><span class="text-muted">{{$key+1}}</span></td>
            <td>{{date('d-M-Y h:i:a',strtotime($trans->created_at))}}</td>
            <td>
                @if($trans->type == "o")
                Opening Balance
                @elseif($trans->type == "d")
                Debited
                @elseif($trans->type == "r")
                Credited
                @endif
            </td>
            <td>
             {{$trans->amount}}
            </td>

          </tr>
          @empty
          <tr><td colspan="9">There is no record</td></tr>
          @endforelse

        </tbody>
      </table>
    </div>

        </div>
        @endif

        </div>
    </div>

</div>
@endsection

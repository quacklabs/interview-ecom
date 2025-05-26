@extends('admin.layout')
@section('title') {{ config('app.name') }} | {{ $title }} @endsection


@section('content')
<section class="section">
  <div class="section-header">
    <h1>Manage {{ $type }} Deposits</h1>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
            <h4>All Deposits</h4>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table id="myTable" class="display table table-sm">
              <thead>
                <tr>
                  <th>Payment ID</th>
                  <th scope="col">Amount</th>
                  <th scope="col">User</th>
                  <th scope="col">Status</th>
                  <th scope="col">Transaction Reference</th>
                  <th scope="col">Actions</th>

                </tr>
              </thead>
              <tbody>
                  @foreach($deposits as $deposit)
                <tr>
                  <td>{{ $deposit->payment_id }}</td>
                  <td scope="col">${{ number_format($deposit->price_amount, 2) }}</td>
                  <td>{{ $deposit->user->username }}</td>
                  <td>{{ $deposit->payment_status }}</td>
                  <td>{{ $deposit->payment_id }}</td>
                  <td>
                      @if($deposit->payment_status != 'finished')

                        @if($deposit->payment_status != 'failed' && $deposit->payment_status != 'expired')
                        <a class="btn btn-info" href="#">Refresh</a>
                        <a class="btn btn-success" href="{{ route('admin.toggle_deposit', ['id' => $deposit->id, 'status' => 'finished']) }}">Approve</a>
                        <a class="btn btn-danger" href="{{ route('admin.toggle_deposit', ['id' => $deposit->id, 'status' => 'failed']) }}">Reject</a>
                        @endif
                      @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div class="card-footer text-right">
            <div class="float-right">
                @empty($deposits)

                @else
                    {{ $deposits->links() }}
                @endempty
            </div>
        </div>
      </div>

    </div>

  </div>
</section>

@endsection

@section('js')
<script>
  $(function() {
    $("#myTable").DataTable({
      paging: false
    })
  })
</script>
  
@endsection
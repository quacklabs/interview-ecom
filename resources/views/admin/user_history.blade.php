@extends('admin.layout')
@section('title') {{ config('app.name') }} | {{ $title }} @endsection


@section('content')
<section class="section">
  <div class="section-header">
    <h1>User Transactions</h1>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
            <h4>All Transactions for {{ $client->username }} </h4>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>Payment ID</th>
                  <th scope="col">Amount</th>
                  <th scope="col">Type</th>
                  <th scope="col">Status</th>
                  <th scope="col">Actions</th>

                </tr>
              </thead>
              <tbody>
                  @foreach($transactions as $transaction)
                <tr>
                  <td>{{ $transaction->payment_id }}</td>
                  <td scope="col">${{ number_format($transaction->price_amount, 2) }}</td>
                  <td scope="col">{{ $transaction->name }}</td>
                  <td>{{ $transaction->payment_status }}</td>
                  <td>
                      @if ($transaction->open == true)
                        <a class="btn btn-success" href="{{ route('admin.approve_transaction', ['id' => $transaction->id, 'redirect' => 'admin.user_transactions']) }}">Approve</a>
                        <a class="btn btn-warning" href="{{ route('admin.cancel_transaction', ['id' => $transaction->id, 'redirect' => 'admin.user_transactions']) }}">Cancel</a>
                      @endif
                        
                        <a class="btn btn-danger" href="{{ route('admin.delete_transaction', ['id' => $transaction->id, 'redirect' => 'admin.user_transactions']) }}">Delete</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div class="card-footer text-right">
                <div class="float-right">
                    @empty($transactions)

                    @else
                        {{ $transactions->links() }}
                    @endempty
                </div>
                <!--  -->
            </div>
      </div>

    </div>

  </div>
</section>

@endsection


@section('js')
@if(session('success'))
<script>
    $(function() {
        swal({
        title: 'Successful',
        text: "{{ session('success') }}",
        icon: 'success'
        })
    })
</script>
@endif

@if(session('error'))
<script>
    $(function() {
        swal({
        title: 'Successful',
        text: "{{ session('error') }}",
        icon: 'warning'
        })
    })
</script>
@endif

@endsection
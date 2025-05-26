@extends('admin.layout')
@section('title') {{ config('app.name') }} | {{ $title }} @endsection


@section('content')
<section class="section">
  <div class="section-header">
    <h1>Manage {{ $type }} Investments</h1>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
            <h4>All Investments</h4>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th scope="col">Amount</th>
                  <th scope="col">User</th>
                  <th scope="col">Plan</th>
                  <th scope="col">Maturity Date</th>
                  <th scope="col">Total Profit</th>
                  <th scope="col">Status</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                  @foreach($investments as $investment)
                <tr>
                  <td scope="col">${{ number_format($investment->amount, 2) }}</td>
                  <td>{{ $investment->user->username }}</td>
                  <td>{{ $investment->plan->name }}</td>
                  <td>{{ $investment->maturity_date() }}</td>
                  <td>${{ number_format($investment->total_profit(), 2) }}</td>
                  <td><span class="badge {{ $investment->badge() }}">{{ $investment->current_status() }}</span></td>
                  <td>
                      @if($investment->current_status() != 'Approved')
                        @if ($investment->current_status() == 'Rejected')

                        @else
                        <a class="btn btn-sm btn-warning" href="{{ route('admin.toggle_investment', ['id' => $investment->id, 'status' => 'reject']) }}">Reject</a>
                        <a class="btn btn-sm btn-success" href="{{ route('admin.toggle_investment', ['id' => $investment->id, 'status' => 'approve']) }}">Approve</a>
                        @endif

                        <a class="btn btn-sm btn-danger" href="{{ route('admin.delete_investment', ['id' => $investment->id]) }}">Delete</a> 
                      @else
                        @if ($investment->status == 'running')
                        <a class="btn btn-sm btn-info" href="{{ route('admin.pay_profit', ['id' => $investment->id]) }}">Pay Profit</a>
                        <a class="btn btn-sm btn-warning" href="{{ route('admin.toggle_investment', ['id' => $investment->id, 'status' => 'terminate']) }}">Terminate</a>
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
                    @empty($investments)

                    @else
                        {{ $investments->links() }}
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
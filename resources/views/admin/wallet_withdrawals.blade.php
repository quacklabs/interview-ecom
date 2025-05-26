@extends('admin.layout')
@section('title') {{ config('app.name') }} | {{ $title }} @endsection


@section('content')
<section class="section">
    <div class="section-header">
     <h1>Manage Pending Withdrawal</h1>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>All Users</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                  <table id="myTable" class="table table-sm">
                    <thead>
                      <tr>
                        <th></th>
                        <th scope="col">Amount</th>
                        <th scope="col">User</th>
                        <th scope="col">Address</th>
                        <th>Fee Type</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>

                      </tr>
                    </thead>
                    <tbody>
                        @foreach($deposits as $deposit)
                      <tr>
                        <th></th>
                        <th scope="row">${{ number_format($deposit->amount, 2) }}</th>
                        <td>{{ $deposit->user->username }}</td>
                        <td>{{ $deposit->wallet_info->address }}</td>
                        <td> <!--($deposit->fee() !== null)  ? $deposit->fee()->name : 'Free'; } : ${ ($deposit->fee() !== null) ? number_format($deposit->fee()->value, 2) : 0.00 } --></td>
                        <td>{{ $deposit->status }}</td>
                        <td>
                        <!-- <a class="btn btn-dark" href="{ rou  nkte('admin.withdrawal', ['id' => $deposit->id, 'action' => 'view', 'flag' => $flag ?? 'wallet']) }">View Details</a> -->
                            @if($deposit->status != 'approved')
                              @if ($deposit->status != 'cancelled')
                              <a class="btn btn-primary" href="{{ route('admin.toggle_request', ['id' => $deposit->id, 'status' => 'approved']) }}">Approve</a>
                              <a class="btn btn-secondary" href="{{ route('admin.toggle_request', ['id' => $deposit->id, 'status' => 'cancelled']) }}">Reject</a>
                              <a class="btn btn-danger" href="{{ route('admin.delete_request', ['id' => $deposit->id, 'status' => 'delete']) }}">Delete</a>
                              @endif
                            
                            @endif
                            <!-- <a class="btn btn-danger" href="{{ route('admin.delete_request', ['id' => $deposit->id, 'action' => 'delete']) }}">Delete</a> -->
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>

          <div class="card-footer text-right">
                <div class="float-right">
                    @empty($deposits)

                    @else
                        {{ $deposits->links() }}
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
<script>
  $(function() {
    $("#myTable").DataTable({
      paging: false
    })
  })
</script>

@endsection
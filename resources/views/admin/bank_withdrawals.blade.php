@extends('admin.layout')
@section('title') {{ config('app.name') }} | {{ $title }} @endsection


@section('content')
<section class="section">
    <div class="section-header">
     <h1>Manage {{ $type }} Withdrawal</h1>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>All Requests</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table data-order='[[ 1, "asc" ]]' id="myTable" class="display table table-sm">
                        <thead>
                            <tr role="row">
                                <th class="sorting_asc"></th>
                                <th>Username</th>
                                <th>Amount</th>
                                <th>Bank Info</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($w_requests as  $w_request)
                            <tr>
                                <td></td>
                                <td> {{ $w_request->user->username }}</td>
                                <td>{{ $w_request->formattedAmount }}</td>
                                <td>
                                    <p>Bank Name: <strong>{{ $w_request->bank_info->bank_name }}</strong></p>
                                    <p>Account Number: <strong>{{ $w_request->bank_info->account_number }}</strong></p>
                                    <p></p>
                                </td>
                                <td>{{ $w_request->badge }} </td>
                                <td>
                                    @if($w_request->status == 'pending')
                                    <a class="btn btn-info bg-dark" href="{{route('admin.toggle_request', ['id' => $w_request->id, 'status' => 'approved']) }}">Approve</a>
                                    <a class="btn btn-warning" href="{{route('admin.toggle_request', ['id' => $w_request->id, 'status' => 'cancelled']) }}">Reject</a>
                                    @endif
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
                    @empty($w_requests)
                    
                    @else
                        {{ $w_requests->links() }}
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
        $('#myTable').DataTable({
            paging: false
        });
    })
</script>
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
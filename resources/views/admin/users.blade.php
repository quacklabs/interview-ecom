@extends('admin.layout')
@section('title') {{ config('app.name') }} | {{ $title }} @endsection


@section('content')
<section class="section">
    <div class="section-header">
     <h1>Welcome to your {{ $title }}, {{ $user->name }}</h1>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>All Users</h4>
                    <button class="btn btn-primary" id="delete">Delete Selected</button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-sm">
                        <thead>
                          <tr>
                            <th></th>
                            <th scope="col">Username</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Registered</th>
                            <th scope="col">Active Plans</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>

                          </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                          <tr>
                            <th><input type="checkbox" class="checkbox" data-id="{{ $user->id }}"/></th>
                            <th scope="row"> {{ $user->username }}</th>
                            <td>{{ $user->profile->fullname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->active_plans()->count() }}</td>
                            <td>{{ ($user->active == true) ? 'Active' : 'Suspended' }}</td>
                            <td>
                                @if($user->active == false)
                                <a class="btn btn-success" href="{{route('admin.activate', ['id' => $user->id]) }}">Activate</a>
                                @else
                                <a class="btn btn-warning" href="{{route('admin.suspend', ['id' => $user->id]) }}">Suspend</a>
                                @endif
                                <a class="btn btn-primary" href="{{ route('admin.user_transactions', ['id' => $user->id]) }}">View Transactions</a>
                                <a class="btn btn-danger" href="{{ route('admin.delete_user', ['id' => $user->id]) }}">Delete</a>
                                
                            </td>
                            
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
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
    $("#delete").click(function(e) {
      var selectedIds = [];
      $(".checkbox:checked").each(function() {
        var id = $(this).data("id");
        selectedIds.push(id);
      });
      var url = "{{ route('admin.deleteUsers') }}?" + $.param({ ids: selectedIds });
      window.location.href = url;
    })
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
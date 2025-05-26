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
                    <h4>All Messages</h4>
                    <button class="btn btn-primary" id="delete">Delete Selected</button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-sm">
                        <thead>
                          <tr>
                            <th></th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Message</th>
                            <th scope="col">Actions</th>

                          </tr>
                        </thead>
                        <tbody>
                            @foreach($plans as $plan)
                          <tr>
                            <th><input type="checkbox" class="checkbox" data-id="{{ $plan->id }}"/></th>
                            <th scope="row"> {{ $plan->name }}</th>
                            <td>{{ $plan->email }}</td>
                            <td>{{ $plan->message }}</td>
                            <td>
                                <a class="btn btn-danger" href="{{ route('admin.delete_message', ['id' => $plan->id]) }}">Delete</a>
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
      var url = "{{ route('admin.deleteMessages') }}?" + $.param({ ids: selectedIds });
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
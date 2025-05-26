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
                    <h4>All Plans</h4>
                    <!-- <button class="btn btn-primary" id="delete">Delete Selected</button> -->
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-sm">
                        <thead>
                          <tr>
                            <th>#</th>
                            <!-- <th></th> -->
                            <th scope="col">Plan Name</th>
                            <th scope="col">Investment Term</th>
                            <th scope="col">ROI (%)</th>
                            <th scope="col">Features</th>
                            <th scope="col">Active</th>
                            <th scope="col">Actions</th>

                          </tr>
                        </thead>
                        <tbody>
                            @foreach($plans as $plan)
                          <tr>
                            <th>{{ $loop->iteration }}</th>
                            <!-- <th><input type="checkbox" class="checkbox" data-id="{{ $plan->id }}"/></th> -->
                            <th scope="row"> {{ $plan->name }}</th>
                            <td>{{ $plan->investment_term }}</td>
                            <td>{{ number_format($plan->return_percent, 2) }}</td>
                            <td>
                                <ul>
                                    @foreach ($plan->details as $feature)
                                        <li>{{ $feature->feature }}</li>
                                    @endforeach

                                </ul>
                                
                            </td>
                            <td>{{ ($plan->active == true) ? 'Active' : 'Suspended' }}</td>
                            <td>
                                @if($plan->active == false)
                                <a class="btn btn-success" href="{{route('admin.activate_plan', ['id' => $plan->id]) }}">Activate</a>
                                @else
                                <a class="btn btn-warning" href="{{ route('admin.deactivate_plan', ['id' => $plan->id]) }}">Deactivate</a>
                                @endif
                                <!-- <a class="btn btn-danger" href="{{ route('admin.delete_user', ['id' => $plan->id]) }}">Delete</a> -->
                                
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
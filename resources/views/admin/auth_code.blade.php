@extends('admin.layout')
@section('title') {{ config('app.name') }} | {{ $title }} @endsection


@section('content')
<section class="section">
  <div class="section-header">
    <h1>Manage Authorization codes</h1>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
            <h4>Clients can use these codes to validate bank withdrawal requests</h4>

            <div class="section-header-button">
                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add New</button>
                <!-- <a href="#" class="btn btn-primary">Add New</a> -->
            </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-sm">
              
              <tbody>
                <tr>
                    <th>#</th>
                    <th scope="col">Code Name</th>
                    <th scope="col">Code</th>
                    <th>Assigned To</th>
                    <th scope="col">Actions</th>
                </tr>
                
                @foreach($codes as $code)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $code->type->name }}</td>
                    <td>{{ $code->code }}</td>
                    <td>{{ $code->user->username }}</td>
                    
                    <td>
                    <a class="btn btn-danger" href="{{ route('admin.delete_codes', ['id' => $code->id, 'param' => 'bank_codes']) }}">Delete</a>
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
</section>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content card">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <hr>
            

            <div class="modal-body">
                <form id="productForm" method="post" action="{{ route('admin.codes', ['param' => 'bank_codes']) }}">
                    @csrf
                    <div class="card-body">
                            
                        <div class="form-group row">
                            <label for="site-title" class="form-control-label text-md-right col-sm-3">Code</label>
                            <div class="col-sm-6 col-md-9">
                            <input name="code" type="text" name="site_title" class="form-control" id="site-title" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="site-title" class="form-control-label text-md-right col-sm-3">Code Type</label>
                            <div class="col-sm-6 col-md-9">
                                <select class="form-control" name="type_id" type="text">
                                    @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="site-title" class="form-control-label text-md-right col-sm-3">Assign User</label>
                            <div class="col-sm-6 col-md-9">
                                <select class="form-control" name="user_id" type="text">
                                    @foreach ($users as $client)
                                    <option value="{{ $client->id }}">{{ $client->profile->fullname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-lg">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection


@section('js')
@endsection
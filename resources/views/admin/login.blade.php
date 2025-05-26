@extends('admin.layout')
@section('title') {{ config('app.name') }} | {{ $title }} @endsection

@section('content')
<div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-4 col-lg-6 offset-lg-4 col-xl-4 offset-xl-6">
            <div class="login-brand">
              <img src="{{ asset('img/logo.jpg') }}" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Login</h4></div>

                @if(session('error'))
                <!-- Form Submit Message Starts -->
                <div class="col-xs-12 alert alert-success">
                    <p class="output_message ">{{ session('error') }}</p>
                </div>
                <!-- Form Submit Message Ends -->
                @endif
              <div class="card-body">
                <form method="POST" action="{{ route('admin.login') }}" class="needs-validation" novalidate="">
                    @csrf
                    <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" value="" required>
                    @error('email')
                    <div class="invalid-feedback">
                    {{ $message }}
                    </div>
                    @enderror
                    
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    @error('password')
                    <div class="invalid-feedback">
                    {{ $message }}
                    </div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
            
            <div class="simple-footer">
              Copyright &copy; {{ date('Y') }}. Created by Professor 3vil
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection
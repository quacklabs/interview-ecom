@extends('admin.layout')
@section('title') {{ config('app.name') }} | {{ $title }} @endsection

@section('css')
<link rel="stylesheet" href="{{ asset('default/css/selector.css') }}">
<link rel="stylesheet" href="{{ asset('default/css/datepicker.css') }}">
    
@endsection

@section('content')
<style>
    .list-group li {
        display: flex;
    }
    .list-group button {
        display: flex;
        margin-left: auto;
    }
</style>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title }}</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Edit Live Chat Widget</h2>
            <!-- <p class="section-lead">
                Each staff must be assigned to a transaction
            </p> -->

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <form id="orderForm" action="{{ route('admin.livechat') }}" method="POST">
                            <div class="card-header">
                                <h4> </h4>
                                <div class="card-header-form ">
                                    <div class="input-group float-right">
                                        <button type="submit" class="btn rounded btn-primary"><i class="fas fa-plus"></i> Save</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @csrf
                                <div class="px-2">
                                    
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail4">Widget Code</label>
                                            <textarea id="percentage" name="code" type="text" class="form-control" value="{{ $widget->html ?? '' }}" required></textarea>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection


@section('js')

@endsection
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
            <h2 class="section-title">Create Investment Plan</h2>
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
                        <form id="orderForm" action="{{ route('admin.add_plan') }}" method="POST">
                            <div class="card-header">
                                <h4> </h4>
                                <div class="card-header-form ">
                                    <div class="input-group float-right">
                                        <button type="button" id="submit_transaction" class="btn rounded btn-primary"><i class="fas fa-plus"></i> Save</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @csrf
                                <div class="px-2">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail4">Plan Name</label>
                                            <input id="featureList" name="features" type="hidden">
                                            <input id="plan_name" name="plan_name" type="text" class="form-control" value="" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail4">Minimum Investment</label>
                                            <input id="featureList" name="features" type="hidden">
                                            <input id="min_amount" name="min_amount" type="text" class="form-control" value="" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="inputPassword4">Investment Term</label>
                                            <input id="investment_term" name="investment_term" type="text" placeholder="eg: 3 months" class="form-control" value="" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail4">ROI Percentage</label>
                                            <input id="percentage" name="percentage" type="text" class="form-control" value="" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- <style>
                                            
                                        </style> -->

                                        <div class="form-group col-md-12">
                                            <label>Plan Features</label>
                                            <div class="input-group colorpickerinput" style="display: flex; align-items: stretch; position: relative;">
                                                <input id="feature" type="text" class="form-control">
                                                <div class="input-group-append" style="width: 100px; display:contents;">
                                                    <!-- <div class="input-group-text"> -->
                                                        <button class="btn btn-small" id="addFeature">
                                                            <i class="fas fa-plus"></i> Add
                                                        </button>
                                                        
                                                    <!-- </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="list-group" id="features">
                                                
                                            </ul>

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
<!-- <script src="{{ asset('default/js/selector.js') }}"></script> -->
<!-- <script src="{{ asset('default/js/datepicker.js') }}"></script> -->

<script>
    const features = [

    ]

    $(function() {
        $("#submit_transaction").click(function(e) {
            if(features.length < 1) {
                swal({
                    title: "Plan features required",
                    text: 'Please add the default features',
                    icon: 'error'
                })
                return
            } else {
                if($('#plan_name').val().trim() == '') {
                    swal({
                        title: "Plan name required",
                        text: 'Please add the plan name',
                        icon: 'error'
                    })
                    $('#plan_name').focus()
                    return
                } else if($('#investment_term').val().trim() == '') {
                    swal({
                        title: "Plan term required",
                        text: 'Please add the plan investment term',
                        icon: 'error'
                    })
                    $('#investment_term').focus()
                    return
                } else if($('#percentage').val() == '') {
                    swal({
                        title: "Plan ROI required",
                        text: 'Please add the default ROI',
                        icon: 'error'
                    })
                    $('#percentage').focus()
                    return
                } else if($('#min_amount').val() == '' || isNaN($('#min_amount').val())) {
                    swal({
                        title: "Minimum Error",
                        text: 'Please enter a valid amount',
                        icon: 'error'
                    })
                    $('#min_amount').focus()
                    return
                }

                const val = JSON.stringify(features)
                alert(val)
                $("#featureList").val(val)
                $("#orderForm").submit()
                // const list = $("#featureList").val()
            }
        })
    })

    // $(document).on('submit', '#orderForm', submitForm)

    $(document).on('click', '#addFeature', function(e) {
        e.preventDefault()
        const feature = $("#feature").val()
        if (feature.trim() !== '') {
            var listItem = $('<li>').addClass('list-group-item flex d-flex align-items-right');
            var index = $('#features > li').length;
            var text = $('<span>').addClass('list-item-text d-flex').text(feature);
            var button = $('<button>').addClass('btn btn-danger ml-auto').text('Delete');
            button.data('index', index)
            button.type = 'button'
            button.click(function() {
                // e.preventDefault()
                const idx = $(this).data('index')
                $('#features > li').eq(idx).remove();
                $('#features > li').each(function(i) {
                    $(this).find('button').data('index', i);
                });
                features.splice(idx, 1);
            });
            listItem.append(text, button);
            $('#features').append(listItem);
            $('#feature').val(''); // Clear input field
            features.push(feature)
            return
        }
        
        // const row_id = $(this).data('row')
        // const row = $("#row"+row_id)
        // const total = row.find('input').filter(function() {
        //     return $(this).data('name') === 'file';
        // }).first();
        // total.click(); // Trigger the file input click event
    });

    // $(document).on('input', '.file-input', function() {
    //     var file = this.files[0]; // Get the selected file
    //     const row_id = $(this).data('row')
    //     const row = $("#row"+row_id)
    //     const serials = row.find('input').filter(function() {
    //         return $(this).data('name') === 'serials';
    //     }).first();

    //     const quantity = row.find('input').filter(function() {
    //         return $(this).data('name') === 'quantity';
    //     }).first();

    //     // Create a FormData object
    //     var formData = new FormData();
    //     // formData
    //     formData.append('file', file);

    //     // Make an AJAX request to upload the file
    //     $.ajax({
    //     url: "{ route('api.uploadSerials') }",
    //     type: 'POST',
    //     data: formData,
    //     processData: false,
    //     contentType: false,
    //     success: function(response) {
    //         // Handle the success response
    //         console.log('File uploaded successfully.');
    //         const values = [];
    //         const data = response.data

    //         // Iterate over the outer object keys
    //         for (const key in data) {
    //             // Access the inner object
    //             const innerObject = data[key];
            
    //             // Iterate over the inner object values
    //             for (const innerValue in innerObject) {
    //                 // Push the inner value to the array
    //                 values.push(innerObject[innerValue]);
    //             }
    //         }
    //         serials.val(JSON.stringify(values))
    //         quantity.val(values.length)
    //         quantity.prop('readonly', true)
    //     },
    //     error: function(xhr, status, error) {
    //         // Handle the error response
    //         console.error('Error uploading file:', error);
    //     }
    //     });
    // });
</script>


@endsection
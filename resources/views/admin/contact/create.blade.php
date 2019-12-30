@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-6" style="margin-top: 100px;margin-left: 386px;">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Create Contact From</h3>
                </div>
{{--                    <form method="post" class="form-horizontal" action="{{ route('contact.store') }}" enctype="multipart/form-data">--}}

                <form id="contact_us" action="javascript:void(0)">
                        @csrf
                        @include('admin.layouts._messages')
                        <div class="box-body">
                            <div class="form-group" style="margin-left: 5px;">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="name" class="form-control"  id="name" name="name" placeholder="Name" style="width: 98%;">
                            </div>
                            <div class="form-group" style="margin-left: 5px;">
                                <label for="exampleInputEmail1">email</label>
                                <input type="email" class="form-control"  id="email"  name="email" placeholder="Email" style="width: 98%;">
                            </div>
                            <div class="form-group" style="margin-left: 5px;">
                                <label for="exampleInputEmail1">Mobile number</label>
                                <input type="text" class="form-control"  id="mobile_number"  name="mobile_number" placeholder="Mobile number" style="width: 98%;">
                            </div>
                        </div>
                            <!-- /.card-body -->
                            <button type="submit" id="send_form" class="btn btn-primary">Submit</button>
                    </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
            $('#send_form').on('click',function () {

                var name = $('#name').val();
                var email = $('#email').val();
                var mobile_number = $('#mobile_number').val();

                var data = {
                    name:name,
                    email:email,
                    mobile_number:mobile_number
                }
                console.log(data)
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': "{{csrf_token()}}"
                    }
                });

                $.ajax({

                    method: "POST",
                    url: "<?php echo e(url('contact/store')); ?>" ,
                    data: data,
                    success: function( response ) {
                        alert('Submit Successfully');

                        window.location.reload()
                    }

                });
            })

    </script>

@endsection

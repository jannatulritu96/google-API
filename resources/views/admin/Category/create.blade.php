@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-6" style="margin-top: 100px;margin-left: 386px;">
            <!-- general form elements -->
            <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create new Category</h3>
                    </div>
                    <form method="post" class="form-horizontal" action="{{ route('category.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('_messages')
                        <div class="box-body">
                            <div class="form-group" style="margin-left: 5px;">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="name" class="form-control"  name="name" placeholder="Name" style="width: 98%;">
                            </div>
                            <div class="form-group"  style="margin-left: 5px;">
                                <label for="exampleInputEmail1">Details</label>
                                <input type="text" class="form-control" name="details" placeholder="Details" style="width: 98%;">
                            </div>
                            <div class="form-group"  style="margin-left: 5px;">
                                <label for="exampleInputFile">Image</label>
                                <img id="image" style="width:40%;margin-bottom: 8px;margin-left: 10px;margin-top: 8px;" src="#"><br>
                                <input name="image" type="file" accept="image/*"  id="exampleInputFile" required onchange="readURL(this);">
                            </div>

                            <div class="checkbox"  style="margin-left: 5px;">
                                <div class="form-check">
                                    <label for="exampleInputPassword1" style="margin-left: -30px;"><b>Status</b></label>
                                    <div class="form-check">
                                        <input class="form-check-input" name="status" value="Active" type="radio">
                                        <label class="form-check-label">Active</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="status" value="Inactive" type="radio">
                                        <label class="form-check-label">Inactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image')
                        .attr('src', e.target.result)
                        .width(80)
                        .height(80);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

@endsection

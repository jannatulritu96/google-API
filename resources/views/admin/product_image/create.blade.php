@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-6" style="margin-top: 100px;margin-left: 386px;">
            <!-- general form elements -->
            <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create new product</h3>
                    </div>
                    <form method="post" class="form-horizontal" action="{{ route('product_images.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('admin.layouts._messages')
                        <div class="box-body">
                            <div class="form-group"  style="margin-left: 5px;">
                                <label for="exampleInputEmail1">Details</label>
                                <select class="form-control select2" style="width: 100%;" name="group_id">
                                    <option>Select Group</option>
                                    @foreach($products as $pro)
                                        <option value="{{$pro->id}}">{{ $pro->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group"  style="margin-left: 5px;">
                                <label for="exampleInputFile">Image</label>
                                <img id="image" style="width:40%;margin-bottom: 8px;margin-left: 10px;margin-top: 8px;" src="#"><br>
                                <input name="image" type="file" accept="image/*"  id="exampleInputFile" required onchange="readURL(this);">
                            </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
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

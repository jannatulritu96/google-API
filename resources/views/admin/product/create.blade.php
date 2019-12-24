@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-6" style="margin-top: 100px;margin-left: 386px;">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

        <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Create new product</h3>
                </div>
                <form method="post" class="form-horizontal" action="{{ route('product.store') }}" enctype="multipart/form-data">
                    @csrf
                    @include('admin.layouts._messages')
                    <div class="box-body">
                        <div class="form-group"  style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Category</label>
                            <select class="form-control select2" style="width: 98%;" name="category_id">
                                @foreach($categories as $cat)
                                    <option value="{{$cat->id}}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="name" class="form-control"  name="name" placeholder="Name" style="width: 98%;">
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">details</label>
                            <input type="text" class="form-control"  name="details" placeholder="details" style="width: 98%;">
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Original price</label>
                            <input type="number" class="form-control"  id="original_price" name="original_price" placeholder="Original price" style="width: 98%;">
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Discount percentage</label>
                            <input type="number" class="form-control"  id="discount_percentage"  name="discount_percentage" placeholder="Discount percentage" style="width: 98%;" onkeyup="getPrice()">
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Discount amount</label>
                            <input type="number" class="form-control"  name="discount_amount" id="discount_amount" placeholder="Discount amount" style="width: 98%;"  readonly >
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Price</label>
                            <input type="number" class="form-control"  name="price" id="price" placeholder="Discount percentage" style="width: 98%;" readonly>
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label>Color</label>
                            <select class="form-control selectTag" name="product_color[]" multiple="multiple">
                            </select>
                        </div>

                        <div class="form-group"  style="margin-left: 5px;">
                            <label for="exampleInputFile">Image</label>
                            <div class="box-body">
                                <div class="header">
                                    <h2>Product Images</h2>
                                    <ul class="header-dropdown">
                                        <li class="remove">
                                            <div class="checkbox">
                                                <input id="addImage" type="checkbox" {{ isset($data) && $data->image ? 'checked':'' }} value="1" name="image">
                                                <label for="addImage">
                                                    Add Image
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="body imageBody" style="{{ isset($data) && $data->image ? '':'display:inline' }}">
                                    <div class="mb-3">
                                        <label>Input Product Image <small class="text-danger">Image accepted: size (1200x1200)</small> <span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-10" style="width: 95%;margin-left: 23px;">
                                                    <input type="file"  name="product_image[]" value="" accept="image/*" class="form-control imageInput" multiple="true" style="width: 98%;">
                                                    <div class="imageOutput"></div>
                                                </div>
                                                <div class="col-1 text-right" style="    margin-right: 42px;">
                                                    <button onclick="imageFieldsAdded();"  type="button" class="btn m-0 btn-default btn-icon btn-simple btn-icon-mini btn-round"><i class="glyphicon glyphicon-plus"></i>Add</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="image_fields"></div>

                                    @if(!empty($data->image))
                                        <div style="margin: 40px 0 65px 0;">
                                            <div class=" row clearfix">
                                                @foreach($data->images as $proImg)
                                                    <div class="col-lg-3 col-md-4 col-sm-12">
                                                        <div class="card product_item">
                                                            <div class="body">
                                                                <div class="cp_img p-0">
                                                                    <img src="{{ asset('media/product/'. $proImg->image) }}" alt="Product" class="img-fluid">
                                                                    <div class="hover">
                                                                        <a href="{{ url('admin/product-image/delete/'.$proImg->id) }}" onclick="return confirm('Are you sure..?')" class="btn btn-primary btn-sm waves-effect"><i class="zmdi zmdi-delete"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                </div>
                                {{-- <div class="form-group">
                                    <label for="exampleInputFile">Product Image</label>
                                    <input type="file" id="exampleInputFile" name="image">
                                </div> --}}
                            </div>
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

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        // Add image
        var imageInc = 1;
        function imageFieldsAdded() {
            imageInc++;
            var objTo = document.getElementById('image_fields')
            var divtest = document.createElement("div");
            divtest.setAttribute("class", "form-group thisImage" + imageInc);
            var rdiv = 'thisImage' + imageInc;
            divtest.innerHTML =
                '<div class="mb-3 imgInput">'+
                '<div class="form-group">'+
                '<div class="row">'+
                '<div class="col-10">'+
                '<input type="file"  name="product_image[]" value="" class="form-control imageInput" accept="image/*"  required style="width: 91%;margin-left: 41px;">'+
                '</div>'+
                '<div class="col-1 text-right"  style="    margin-right: 42px;">'+
                '<button onclick="remove_image(' + imageInc + ');"  type="button" class="btn m-0 btn-default btn-icon btn-simple btn-icon-mini btn-round"><i class="zmdi zmdi-close">Close</i></button>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '</div>';
            objTo.appendChild(divtest)
        }
        function remove_image(rid) {
            $('.thisImage' + rid).remove();
        }
        $(document).ready(function() {
            $("#addImage").click(function(event) {
                if ($(this).is(":checked")){
                    $(".imageBody").show();
                } else{
                    $(".imageBody").hide();
                    $(".imageInput").val("");
                    $('.imgInput').remove();
                }
            });
        });

        //Price
        getPrice = function() {
            var orgPrice = Number(document.getElementById("original_price").value);
            var percent = Number(document.getElementById("discount_percentage").value);
            var disAmount = ((orgPrice*percent)/100);
            document.getElementById("discount_amount").value = disAmount.toFixed(2);
            var totalValue = (orgPrice - disAmount)
            document.getElementById("price").value = totalValue.toFixed(2);

        }

    </script>

@endsection

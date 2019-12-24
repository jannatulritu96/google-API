@extends('admin.layouts.master')
@section('content')
    <div class="box">
        <div class="box-header">
            <h6 class="box-title" style="color: blue">{{ $title }}</h6>
            <div class="col-sm-4 text-right m-b-30"  style="margin-left: 1045px;">
                <a href="{{ route('product.create') }}" class="btn btn-primary rounded"><i class="fa fa-plus"></i> Add New product</a>
            </div>
        </div>
        <form method="get" class="form-horizontal" action="{{route('product.index')}}" >
            <div class="col-sm-2" style="margin-left: 600px;margin-top: -55px;">
                <input type="name" class="form-control" name="name"  placeholder="Name" value="{{Request::get('name')}}" onchange="search_post()" style="margin-top: 16px;">
            </div>
            <div class="col-sm-2" style="margin-left: 873px;margin-top: -39px;">
                <select class="form-control select2" style="width: 100%;" name="status" onchange="search_post()">
                    <option value="">Select Status</option>
                    <option value="Active" @if($status == 'Active') selected @endif>Active</option>
                    <option value="Inactive" @if($status == 'Inactive') selected @endif>Inactive</option>
                </select>
            </div>
            <div class="col-sm-2" style="margin-left: 1144px; margin-top: -38px;display: none">
                <button id="search" type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>

    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Category</th>
                <th>Product name</th>
                <th>Original Price</th>
                <th>Discount Price</th>
                <th>Status</th>
                <th class="text-right">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->relCategory->name }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->original_price }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->status }}</td>
                    <td class="text-right">
                        <div class="dropdown">
                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="{{ route('product.show',$product->id) }}" title="Show" class="btn btn-primary" style="margin: 3px;height: 35px;width: 59%;margin-left: 16px;"> Show</a></li>
                                <li><a href="{{ route('product.edit',$product->id) }}" title="Edit" class="btn btn-primary" style="margin: 3px;height: 35px;width: 59%;margin-left: 16px;"> Edit</a></li>
                                <li>
                                    <button class="btn btn-danger" type="button"  onclick="deleteConfirmation({{$product->id }})" style="margin: 3px;height: 35px;width: 59%;margin-left: 16px;">Delete</button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
        </table>

        {!! $products->render() !!}
    </div>

@endsection
@section('script')
    <script>
        function deleteConfirmation(id) {
            swal({
                title: "Delete?",
                text: "Please ensure and then confirm!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo e(url('product/destroy')); ?>/" + id,
                        data: {_token: '{{  @csrf_token() }}' },
                        dataType: 'JSON',
                        success: function (results) {

                            if (results.success === true) {
                                swal("Done!", results.message, "success").then(function () {

                                    window.location.reload()
                                })
                            } else {
                                swal("Error!", results.message, "error");
                            }
                        }
                    });

                } else {
                    e.dismiss;
                }

            }, function (dismiss) {
                return false;
            })
        }

        function search_post() {
            $('#search').click()
        }
    </script>
@endsection


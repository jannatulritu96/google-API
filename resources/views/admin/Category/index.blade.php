@extends('admin.layouts.master')
@section('content')
    <div class="box">
        <div class="box-header">
            <h6 class="box-title" style="color: blue">{{ $title }}</h6>
            <div class="col-sm-4 text-right m-b-30"  style="margin-left: 1045px;">
                <a href="{{ route('category.create') }}" class="btn btn-primary rounded"><i class="fa fa-plus"></i> Add New category</a>
            </div>
        </div>

{{--        <form method="get" class="form-horizontal" action="{{route('category.index')}}" >--}}
{{--            <div class="col-sm-2" style="margin-left: 600px;margin-top: -55px;">--}}
{{--                <input type="name" class="form-control" name="name"  placeholder="Name" value="{{Request::get('name')}}" onchange="search_post()" >--}}
{{--            </div>--}}
{{--            <div class="col-sm-2" style="margin-left: 873px;margin-top: -39px;">--}}
{{--                <select class="form-control select2" style="width: 100%;" name="status" onchange="search_post()">--}}
{{--                    <option value="">Select Status</option>--}}
{{--                    <option value="Active" @if($status == 'Active') selected @endif>Active</option>--}}
{{--                    <option value="Inactive" @if($status == 'Inactive') selected @endif>Inactive</option>--}}
{{--                </select>--}}
{{--            </div>--}}
{{--            <div class="col-sm-2" style="margin-left: 1144px; margin-top: -38px;display: none">--}}
{{--                <button id="search" type="submit" class="btn btn-primary">Search</button>--}}
{{--            </div>--}}
{{--        </form>--}}
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Rendering engine</th>
                    <th>Browser</th>
                    <th>Platform(s)</th>
                    <th>Engine version</th>
                    <th>CSS grade</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Trident</td>
                    <td>Internet
                        Explorer 4.0
                    </td>
                    <td>Win 95+</td>
                    <td> 4</td>
                    <td>X</td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>

@endsection

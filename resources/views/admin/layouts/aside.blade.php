<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="#" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>Alexander Pierce</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- search form -->
{{--    <form action="#" method="get" class="sidebar-form">--}}
{{--        <div class="input-group">--}}
{{--            <input type="text" name="q" class="form-control" placeholder="Search...">--}}
{{--            <span class="input-group-btn">--}}
{{--                <button type="submit" name="search" id="search-btn" class="btn btn-flat">--}}
{{--                  <i class="fa fa-search"></i>--}}
{{--                </button>--}}
{{--              </span>--}}
{{--        </div>--}}
{{--    </form>--}}
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">

        <li class="header">MAIN NAVIGATION
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-book"></i> <span>Dashboard</span></a></li>
        <li><a href="{{ route('category.index') }}"><i class="fa fa-list-alt"></i> <span>Category</span></a></li>
        <li><a href="{{ route('product.index') }}"><i class="fa fa-shopping-cart"></i> <span>Product</span></a></li></li>
        <li><a href="{{ route('api.index') }}"><i class="fa fa-cutlery"></i> <span>Resturant Search</span></a></li></li>
        <li><a href="{{ route('contact.index') }}"><i class="fa fa-cutlery"></i> <span>Contact</span></a></li></li>
{{--        <li><a href="{{ route('product_images.index') }}"><i class="fa fa-shopping-cart"></i> <span>Product images</span></a></li></li>--}}
    </ul>
</section>
<!-- /.sidebar -->

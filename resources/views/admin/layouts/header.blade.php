<!-- Logo -->
<a href="index2.html" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>Shop</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Shop</b></span>
</a>

<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
{{--                    <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">--}}
                    <span class="hidden-xs">User name</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
{{--                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">--}}

                        <h4>User name</h4>
                    </li>
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="{{ route('password.change') }}" class="btn btn-default btn-flat">Change Password</a>
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                                Sign out
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
        </ul>
    </div>

</nav>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LARAVEL SHOP</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <style>
    .navbar-default {
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    border: none;
    position: fixed; /* Fixed position to prevent scrolling */
    top: 0; /* Sticks to the top */
    left: 0; /* Sticks to the left side */
    height: 100%; /* Makes the navbar full height of the viewport */
    width: 250px; /* Adjust the width to fit your design */
    z-index: 1000; /* Keeps navbar above other content */
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Optional shadow for better visibility */
    overflow-y: auto; /* Allows scrolling if the menu content is too long */
}

body {
    margin-left: 250px; /* Adjust the body margin to account for the navbar width */
}


    .nav-header {
        background: rgba(255, 255, 255, 0.05);
        padding: 33px 25px;
        position: relative;
    }

    .nav-header::before {
        content: '';
        position: absolute;
        right: -50px;
        bottom: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 35px;
        transform: rotate(45deg);
        pointer-events: none;
    }

    .nav-header::after {
        content: '';
        position: absolute;
        left: -30px;
        top: -30px;
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.02);
        border-radius: 20px;
        transform: rotate(30deg);
        pointer-events: none;
    }

    @keyframes wave {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

    .navbar-default .nav > li.active > a {
        background: rgba(255, 255, 255, 0.08);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .navbar-default .nav > li.active > a::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, 
            rgba(255,255,255,0) 0%,
            rgba(255,255,255,0.1) 50%,
            rgba(255,255,255,0) 100%);
        background-size: 200% 100%;
        animation: wave 3s ease-in-out infinite;
        pointer-events: none;
    }

    .navbar-default .nav > li > a {
        position: relative;
        color: rgba(255, 255, 255, 0.8);
        font-weight: 500;
        padding: 14px 20px 14px 25px;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .navbar-default .nav > li > a:hover {
        background: rgba(255, 255, 255, 0.08);
        color: white;
    }

    .navbar-default .nav > li > a:hover::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, 
            rgba(255,255,255,0) 0%,
            rgba(255,255,255,0.1) 50%,
            rgba(255,255,255,0) 100%);
        background-size: 200% 100%;
        animation: wave 3s ease-in-out infinite;
        pointer-events: none;
    }

    .navbar-default .nav > li > a::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 0;
        background: #1ab394;
        transition: height 0.3s ease;
    }

    .navbar-default .nav > li.active > a::before,
    .navbar-default .nav > li > a:hover::before {
        height: 80%;
    }

    .navbar-default .nav > li > a i {
        margin-right: 6px;
        font-size: 14px;
    }

    .profile-element img {
        border: 2px solid rgba(255, 255, 255, 0.2);
        padding: 2px;
    }

    .logo-element {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 4px;
    }

    </style>

</head>

<body class="fixed-navigation">
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block m-t-xs font-bold">Wattpad</span>
                            </a>
                        </div>
                    </li>
                    <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                        <a href="{{url('/dashboard')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
                    </li>
                    <li class="{{ Request::is('products*') ? 'active' : '' }}">
                        <a href="{{ route('products.index') }}"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Manage Products</span></a>
                    </li>
                    <li class="{{ Request::is('orders*') ? 'active' : '' }}">
                        <a href="{{ route('orders.index') }}"><i class="fa fa-list"></i> <span class="nav-label">Manage Orders</span></a>
                    </li>
                    <li class="{{ Request::is('customers*') ? 'active' : '' }}">
                        <a href="{{ route('customers.index') }}"><i class="fa fa-users"></i> <span class="nav-label">Manage Customers</span></a>
                    </li>
                    <li>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize " href="#"><i class=""></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                        <img alt="image" class="rounded-circle p-2" width="50px" height="50px" src="{{asset('img/wlogo.jpg')}}"/>
                     
                            
                        </li>
                    </ul>
                </nav>
            </div>

            @yield('content')

            <div class="footer">
                <div class="float-right">
                    10GB of <strong>250GB</strong> Free.
                </div>
                <div>
                    <strong>Copyright</strong> Kylha &copy; 2024-2025
                </div>
            </div>

        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Flot -->
    <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.symbol.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/curvedLines.js') }}"></script>

    <!-- Peity -->
    <script src="{{ asset('js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('js/demo/peity-demo.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Jvectormap -->
    <script src="{{ asset('js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{ asset('js/demo/sparkline-demo.js') }}"></script>

    <!-- ChartJS-->
    <script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>

</body>
</html>

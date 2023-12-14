<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title')</title>
    <link rel="icon" href="https://www.drumedcosmetics.com.au/wp-content/uploads/2023/08/favicon.jpg" sizes="32x32" />
    <!-- <link href="css/styles.css" rel="stylesheet" /> -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/font.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading">
                <div class="logo-part">
                    <img src="{{ asset('img/logo.svg') }}" alt="">
                </div>

            </div>
            <div class="list-group">
                <ul>
                    <li class="{{ (request()->is('dashboard')) ? 'active' : '' }}"><a href="{{ route('dashboard') }}"><i class="ico-dashboard"></i>Dashboard</a></li>
                    <li><a href="#"><i class="ico-calendar"></i>Calendar</a></li>
                    <li><a href="#"><i class="ico-client"></i>Clients</a></li>
                    <li><a href="#"><i class="ico-enquiries"></i>Enquiries </a></li>
                    <li><a href="#"><i class="ico-finance"></i>Finance </a></li>
                    <li><a href="#"><i class="ico-reports"></i>Reports </a></li>
                    <li><a href="#"><i class="ico-staff"></i>Staff </a></li>
                    <li><a href="#"><i class="ico-services"></i>Services </a></li>
                    <li><a href="#"><i class="ico-products"></i>Products </a></li>
                    <li><a href="#"><i class="ico-promotion"></i>Promotions </a></li>
                    <li><a href="#"><i class="ico-forms"></i>Forms </a></li>
                    <li><a href="#"><i class="ico-templates"></i>Templates </a></li>
                    <li class="{{ (request()->is('locations')) ? 'active' : '' }} || {{ (request()->is('locations/*')) ? 'active' : '' }}"><a href="{{ route('locations.index') }}"><i class="ico-locations"></i>Locations </a></li>
                    <li class="{{ (request()->is('settings')) ? 'active' : '' }}"><a href="{{ route('settings') }}"><i class="ico-settings"></i>Settings </a></li>

                </ul>
            </div>
        </div>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg bg-white app-nav">
                <div class="container-fluid">
                    <button class="sidetoggle" id="sidebarToggle"><img src="{{ asset('img/toggle-arrow-left.svg') }}" alt=""></button>
                    <div class="navbar-inner">
                        <div class="app-nav-left">
                            <select class="form-select">
                                <option>Doctors</option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                                <option value="4">Option 4</option>
                                <option value="5">Option 5</option>
                            </select>
                            <select class="form-select">
                                <option>Locations</option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                                <option value="4">Option 4</option>
                                <option value="5">Option 5</option>
                            </select>
                        </div>
                        <div class="app-navbar">
                            <ul>
                                <li><a href="#"><i class="ico-search"></i></a></li>
                                <li><a href="#"><i class="ico-equalizer"></i></a></li>
                                <li><a href="#"><i class="ico-notification"></i></a></li>
                                <li><a href="#"><i class="ico-settings"></i></a></li>
                                <li class="profile">Hi, <span>Umed</span> <img src="{{ asset('img/profile.png') }}" alt=""></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Page content-->
            

            <!-- All Modal  -->
                    
            <!-- Modal -->
            

             <!-- Modal -->
             

             @yield('content')
        </div>
    </div>
    
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js" type="text/javascript"></script>
    @yield('script')
</body>

</html>
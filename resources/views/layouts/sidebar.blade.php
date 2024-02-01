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
    <!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css'> -->
    <!-- Font Awesome CSS -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <!-- <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet"/> -->
    <!-- <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet"/> -->
    <link rel="stylesheet" href="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1569006288/BBBootstrap/choices.min.css?version=7.0.0">
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
                    <li class="{{ (request()->is('clients')) ? 'active' : '' }} || {{ (request()->is('clients/*')) ? 'active' : '' }}"><a href="{{ route('clients.index') }}"><i class="ico-client"></i>Clients</a></li>
                    <li class="{{ (request()->is('enquiries')) ? 'active' : '' }} || {{ (request()->is('enquiries/*')) ? 'active' : '' }}"><a href="{{ route('enquiries.index') }}"><i class="ico-enquiries"></i>Enquiries </a></li>
                    <li><a href="#"><i class="ico-finance"></i>Finance </a></li>
                    <li><a href="#"><i class="ico-reports"></i>Reports </a></li>
                    <!-- dropdown -->
                    <li class="{{ (request()->is('services')) ? 'active' : '' }} || {{ (request()->is('services/*')) ? 'active' : '' }}"><a href="{{ route('services.index') }}"><i class="ico-services"></i>Services </a>
                        <!-- <ul>
                            <li><a href="#">Categories</a></li>
                            <li><a href="#">Treatments</a></li>
                            <li><a href="#"> After Care</a></li>
                            <li><a href="#">Recurring</a></li>
                        </ul> -->
                    </li>
                    <li class="{{ (request()->is('suppliers')) ? 'active' : '' }} || {{ (request()->is('suppliers/*')) ? 'active' : '' }}"><a href="{{ route('suppliers.index') }}"><i class="ico-location1"></i>Suppliers </a></li>
                    <li class="{{ (request()->is('products')) ? 'active' : '' }} || {{ (request()->is('products/*')) ? 'active' : '' }}"><a href="{{ route('products.index') }}"><i class="ico-products"></i>Products </a></li>
                    <li class="dropdown"><a href="#"><i class="ico-promotion"></i>Promotions </a>
                        <ul>
                            <li><a href="#">Gift Cards</a></li>
                            <li><a href="#">Discount Coupons</a></li>
                        </ul>
                    </li>
                    <li class="{{ (request()->is('forms')) ? 'active' : '' }} || {{ (request()->is('forms/*')) ? 'active' : '' }}"><a href="{{ route('forms.index') }}"><i class="ico-forms"></i>Forms </a></li>
                    <li class="dropdown {{ (request()->is('email-templates')) ? 'show' : '' }} || {{ (request()->is('email-templates')) ? 'active' : '' }} || {{ (request()->is('sms-templates')) ? 'show' : '' }} || {{ (request()->is('sms-templates')) ? 'active' : '' }} || {{ (request()->is('email-templates/*')) ? 'show' : '' }} || {{ (request()->is('sms-templates/*')) ? 'show' : '' }}"><a href="#"><i class="ico-templates"></i>Templates </a>
                        <ul>
                            <li class="{{ (request()->is('email-templates')) ? 'active' : '' }} || {{ (request()->is('email-templates/*')) ? 'active' : '' }}"><a href="{{ route('email-templates.index') }}">Email Templates</a></li>
                            <li class="{{ (request()->is('sms-templates')) ? 'active' : '' }} || {{ (request()->is('sms-templates/*')) ? 'active' : '' }}"><a href="{{ route('sms-templates.index') }}">SMS Templates</a></li>
                        </ul>
                    </li>
                    <li class="{{ (request()->is('locations')) ? 'active' : '' }} || {{ (request()->is('locations/*')) ? 'active' : '' }}"><a href="{{ route('locations.index') }}"><i class="ico-locations"></i>Locations </a></li>
                    <li class="{{ (request()->is('users')) ? 'active' : '' }} || {{ (request()->is('users/*')) ? 'active' : '' }}"><a href="{{ route('users.index') }}"><i class="ico-staff"></i>Staffs</a>
                    </li>
                    <li class="dropdown {{ (request()->is('settings')) ? 'active' : '' }} || {{ (request()->is('settings')) ? 'show' : '' }} || {{ (request()->is('users-roles')) ? 'active' : '' }} || {{ (request()->is('users-roles/*')) ? 'active' : '' }} || {{ (request()->is('users-roles')) ? 'show' : '' }} || {{ (request()->is('access-level')) ? 'show' : '' }} || {{ (request()->is('access-level')) ? 'active' : '' }}"><a href="#"><i class="ico-templates"></i>Settings </a>
                        <ul>
                            <li class="{{ (request()->is('settings')) ? 'active' : '' }}"><a href="{{ route('settings') }}">User Settings</a></li>
                            <li class="{{ (request()->is('users-roles')) ? 'active' : '' }} || {{ (request()->is('users-roles/*')) ? 'active' : '' }}"><a href="{{ route('users-roles.index') }}">User Role</a></li>
                            <li class="{{ (request()->is('access-level')) ? 'active' : '' }}"><a href="{{ route('access-level') }}">Access Level</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="next-appointment mt-3">
                            <h5 class="mb-3">Next 5 Appointments</h5>
                            <a href="#" class="apnt-box">
                                <h6 class="blue-bold">Narelle Nixon</h6>
                                <span class="font-14 d-grey">VIP Skin Treatment</span><br>
                                <time><i class="ico-clock me-1"></i> 11.00 AM</time>
                            </a>
                            <a href="#" class="apnt-box">
                                <h6 class="blue-bold">Miya Mackenzie</h6>
                                <span class="font-14 d-grey">Vital 2 Beauty Booster</span><br>
                                <time><i class="ico-clock me-1"></i> 11.00 AM</time>
                            </a>
                            <a href="#" class="apnt-box">
                                <h6 class="blue-bold">Donna Smillie</h6>
                                <span class="font-14 d-grey">Lips & 3 Areas</span><br>
                                <time><i class="ico-clock me-1"></i> 11.00 AM</time>
                            </a>
                            <a href="#" class="apnt-box">
                                <h6 class="blue-bold">Katie Deeble</h6>
                                <span class="font-14 d-grey">Cheek Filler</span><br>
                                <time><i class="ico-clock me-1"></i> 11.00 AM</time>
                            </a>
                            <a href="#" class="apnt-box">
                                <h6 class="blue-bold">Narelle Nixon</h6>
                                <span class="font-14 d-grey">VIP Skin Treatment</span><br>
                                <time><i class="ico-clock me-1"></i> 11.00 AM</time>
                            </a>
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
                            <!-- <select class="form-select">
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
                            </select> -->
                        </div>
                        <div class="app-navbar">
                            <ul class="items"> 
                                <li><a href="#" class="tap"><i class="ico-search"></i></a></li>
                                <li><a href="#" class="tap"><i class="ico-equalizer"></i></a></li>
                                <li><a href="#" class="tap"><i class="ico-notification"></i><span class="badge badge-circle text-bg-blue notification">25</span></a></li>
                                <li><a href="#" class="tap"><i class="ico-settings"></i></a></li>
                                <li class="profile" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">Hi, <span>{{Auth::user()->first_name.' '.Auth::user()->last_name}}</span> 
                                @if(Auth::user()->image=='')
                                <figure><img src="{{URL::to('/images/banner_image/no-image.jpg')}}" alt=""></figure>
                                @else
                                <figure><img src="{{URL::to('/images/user_image/'.Auth::user()->image)}}" alt=""></figure>
                                @endif
                                
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a href="{{ route('settings') }}" onclick="event.preventDefault(); document.getElementById('settings-form').submit();"> Manage Account</a>
                                        <form id="settings-form" action="{{ route('settings') }}">
                                        </form>
                                    </li>
                                        <li> <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                      </ul>
                                </li>

                            </ul>
                            
                              
                        </div>
                    </div>
                </div>
            </nav>
            <main>
                
            <!-- Page content-->
            

            <!-- All Modal  -->
                    
            <!-- Modal -->
            

             <!-- Modal -->
             

             @yield('content')
             </main>
        </div>
    </div>
    
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js" type="text/javascript"></script>
    <!-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script> -->
    <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.19/pagination/select.js" type="text/javascript"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script src="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1569006273/BBBootstrap/choices.min.js?version=7.0.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    @yield('script')
    <script>
        $(document).ready(function(){
            
        $(".list-group ul li.dropdown").click(function(){
            if(!$(this).hasClass('show'))
            {
                $('.dropdown').removeClass('show');
            }
            $(this).toggleClass("show");
        });
    });
    </script>
</body>

</html>
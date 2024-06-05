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
    <link href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css" rel="stylesheet"/>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> --}}


    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css'> -->
    <!-- Font Awesome CSS -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <!-- <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet"/> -->
    <!-- <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet"/> -->
    <link rel="stylesheet" href="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1569006288/BBBootstrap/choices.min.css?version=7.0.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
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
                    <li class="{{ (request()->is('dashboard')) ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}"><i class="ico-dashboard"></i>Dashboard</a>
                    </li>
                    @if(\Auth::user()->checkPermission('calender') == "true" || \Auth::user()->checkPermission('calender') != "No permission")
                    <li class="{{ Route::is('calender.*') ? 'active' : '' }}">
                        <a href="{{ route('calender.index') }}"><i class="ico-calendar"></i>Calendar</a>
                    </li>
                    @endif
                    @if(\Auth::user()->checkPermission('clients') == "true" || \Auth::user()->checkPermission('clients') != "No permission")
                        <li class="{{ (request()->is('clients')) ? 'active' : '' }} || {{ (request()->is('clients/*')) ? 'active' : '' }}">
                            <a href="{{ route('clients.index') }}"><i class="ico-client"></i>Clients</a>
                        </li>
                    @endif
                    @if(\Auth::user()->checkPermission('enquiries') == "true" || \Auth::user()->checkPermission('enquiries') != "No permission")
                    <li class="{{ (request()->is('enquiries')) ? 'active' : '' }} || {{ (request()->is('enquiries/*')) ? 'active' : '' }}">
                        <a href="{{ route('enquiries.index') }}"><i class="ico-enquiries"></i>Enquiries</a>
                    </li>
                    @endif
                    @if(\Auth::user()->checkPermission('finance') == "true" || \Auth::user()->checkPermission('finance') != "No permission")
                    <li class="{{ (request()->is('finance')) ? 'active' : '' }} || {{ (request()->is('finance/*')) ? 'active' : '' }}">
                        <a href="{{ route('finance.index') }}"><i class="ico-finance"></i>Finance</a>
                    </li>
                    @endif
                    @if(\Auth::user()->checkPermission('reports') == "true" || \Auth::user()->checkPermission('reports') != "No permission")
                    <li>
                        <a href="#"><i class="ico-reports"></i>Reports</a>
                    </li>
                    @endif
                    @if(\Auth::user()->checkPermission('services') == "true" || \Auth::user()->checkPermission('services') != "No permission")
                    <!-- dropdown -->
                    <li class="{{ (request()->is('services')) ? 'active' : '' }} || {{ (request()->is('services/*')) ? 'active' : '' }}">
                        <a href="{{ route('services.index') }}"><i class="ico-services"></i>Services</a>
                        <!-- <ul>
                            <li><a href="#">Categories</a></li>
                            <li><a href="#">Treatments</a></li>
                            <li><a href="#"> After Care</a></li>
                            <li><a href="#">Recurring</a></li>
                        </ul> -->
                    </li>
                    @endif
                    @if(\Auth::user()->checkPermission('suppliers') == "true" || \Auth::user()->checkPermission('suppliers') != "No permission")
                    <li class="{{ (request()->is('suppliers')) ? 'active' : '' }} || {{ (request()->is('suppliers/*')) ? 'active' : '' }}">
                        <a href="{{ route('suppliers.index') }}"><i class="ico-location1"></i>Suppliers</a>
                    </li>
                    @endif
                    @if(\Auth::user()->checkPermission('products') == "true" || \Auth::user()->checkPermission('products') != "No permission")
                    <li class="{{ (request()->is('products')) ? 'active' : '' }} || {{ (request()->is('products/*')) ? 'active' : '' }}">
                        <a href="{{ route('products.index') }}"><i class="ico-products"></i>Products</a>
                    </li>
                    @endif

                    @php
                        $canViewGiftCards = \Auth::user()->checkPermission('gift-card') == "true" || \Auth::user()->checkPermission('gift-card') != "No permission";
                        $canViewDiscountCoupons = \Auth::user()->checkPermission('discount-coupons') == "true" || \Auth::user()->checkPermission('discount-coupons') != "No permission";
                        $isActiveParentMenu = request()->is('gift-card') || request()->is('discount-coupons') || request()->is('gift-card/*') || request()->is('discount-coupons/*') ? 'show active' : '';
                    @endphp

                    @if($canViewGiftCards || $canViewDiscountCoupons)
                    <li class="dropdown {{ $isActiveParentMenu }}">
                        <a href="#"><i class="ico-promotion"></i>Promotions </a>
                        <ul>
                            @if($canViewGiftCards)
                            <li class="{{ (request()->is('gift-card') || request()->is('gift-card/*')) ? 'active' : '' }}"><a href="{{ route('gift-card.index') }}">Gift Cards</a></li>
                            @endif
                            @if($canViewDiscountCoupons)
                            <li class="{{ (request()->is('discount-coupons') || request()->is('discount-coupons/*')) ? 'active' : '' }}"><a href="{{ route('discount-coupons.index') }}">Discount Coupons</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if(\Auth::user()->checkPermission('forms') == "true" || \Auth::user()->checkPermission('forms') != "No permission")
                    <li class="{{ (request()->is('forms')) ? 'active' : '' }} || {{ (request()->is('forms/*')) ? 'active' : '' }}">
                        <a href="{{ route('forms.index') }}"><i class="ico-forms"></i>Forms</a>
                    </li>
                    @endif
                    @php
                        $canViewEmailTemplates = \Auth::user()->checkPermission('email-templates') == "true" || \Auth::user()->checkPermission('email-templates') != "No permission";
                        $canViewSmsTemplates = \Auth::user()->checkPermission('sms-templates') == "true" || \Auth::user()->checkPermission('sms-templates') != "No permission";
                    @endphp

                    @if($canViewEmailTemplates || $canViewSmsTemplates)
                        <li class="dropdown 
                            {{ (request()->is('email-templates') || request()->is('sms-templates') || request()->is('email-templates/*') || request()->is('sms-templates/*')) ? 'show active' : '' }}">
                            <a href="#"><i class="ico-templates"></i>Templates</a>
                            <ul>
                                @if($canViewEmailTemplates)
                                    <li class="{{ (request()->is('email-templates') || request()->is('email-templates/*')) ? 'active' : '' }}">
                                        <a href="{{ route('email-templates.index') }}">Email Templates</a>
                                    </li>
                                @endif
                                @if($canViewSmsTemplates)
                                    <li class="{{ (request()->is('sms-templates') || request()->is('sms-templates/*')) ? 'active' : '' }}">
                                        <a href="{{ route('sms-templates.index') }}">SMS Templates</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(\Auth::user()->checkPermission('locations') == "true" || \Auth::user()->checkPermission('locations') != "No permission")
                    <li class="{{ (request()->is('locations')) ? 'active' : '' }} || {{ (request()->is('locations/*')) ? 'active' : '' }}">
                        <a href="{{ route('locations.index') }}"><i class="ico-locations"></i>Locations </a>
                    </li>
                    @endif
                    @if(\Auth::user()->checkPermission('users') == "true" || \Auth::user()->checkPermission('users') != "No permission")
                    <li class="{{ (request()->is('users')) ? 'active' : '' }} || {{ (request()->is('users/*')) ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}"><i class="ico-staff"></i>Staffs</a>
                    </li>
                    <li class="{{ (request()->is('timetable')) ? 'active' : '' }} || {{ (request()->is('timetable/*')) ? 'active' : '' }}">
                        <a href="{{ route('user.timetable') }}"><i class="ico-calendar"></i>Timetable</a>
                    </li>
                    @endif
                    @if(\Auth::user()->checkPermission('settings') == "true" || \Auth::user()->checkPermission('settings') != "No permission")
                    <li class="dropdown {{ (request()->is('settings')) ? 'active' : '' }} || {{ (request()->is('settings')) ? 'show' : '' }} || {{ (request()->is('users-roles')) ? 'active' : '' }} || {{ (request()->is('users-roles/*')) ? 'active' : '' }} || {{ (request()->is('users-roles')) ? 'show' : '' }} || {{ (request()->is('access-level')) ? 'show' : '' }} || {{ (request()->is('access-level')) ? 'active' : '' }}">
                        <a href="#"><i class="ico-templates"></i>Settings </a>
                        <ul>
                            <li class="{{ (request()->is('settings')) ? 'active' : '' }}">
                                <a href="{{ route('settings') }}">User Settings</a>
                            </li>
                            <li class="{{ (request()->is('users-roles')) ? 'active' : '' }} || {{ (request()->is('users-roles/*')) ? 'active' : '' }}"><a href="{{ route('users-roles.index') }}">User Role</a>
                            </li>
                            <li class="{{ (request()->is('access-level')) ? 'active' : '' }}">
                                <a href="{{ route('access-level') }}">Access Level</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
            @php
                $currentDateTime = now()->timezone('Asia/Kolkata')->format('Y-m-d H:i:s');
                $data = \App\Models\Clients::join('appointment', function($join) use ($currentDateTime) {
                    $join->on('clients.id', '=', 'appointment.client_id')
                        ->where('appointment.start_date', '>=', $currentDateTime);
                })
                ->join('services', 'services.id', '=', 'appointment.service_id') // Join the service table
                ->select('clients.firstname','clients.lastname','appointment.start_date', 'services.service_name') // Select the name column from the clients table and the service_name column from the service table
                ->orderBy('appointment.start_date', 'asc') // Order by start_date in ascending order
                ->take(5)
                ->get();
            @endphp
            <div class="next-appointment mt-3">
                <h5 class="mb-3">Next 5 Appointments</h5>
                @if(count($data)>0)
                    @foreach($data as $app_data)
                        <a href="#" class="apnt-box">
                            <h6 class="blue-bold">{{$app_data->firstname.' '.$app_data->lastname}}</h6>
                            <span class="font-14 d-grey">{{$app_data->service_name}}</span><br>
                            <time><i class="ico-clock me-1"></i> {{ date('Y-m-d h:i A', strtotime($app_data->start_date)) }}</time>
                        </a>
                    @endforeach
                @else
                    <div>No appointment found</div>
                @endif
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
                                <!-- <li class="profile" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">Hi, <span>{{Auth::user()->first_name.' '.Auth::user()->last_name}}</span> 
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
                                </li> -->
                                <li>
                                    <a href="#" class="profile" id="dropdownMenuClickableInside" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">Hi, <span>{{substr(Auth::user()->first_name.' '.Auth::user()->last_name, 0, 15)}}</span> 
                                    @if(Auth::user()->image=='')
                                    <figure><img src="{{ asset('/storage/images/banner_image/no-image.jpg') }}" alt=""></figure>
                                    @else
                                    <figure><img src="{{ asset('/storage/images/user_image/'.Auth::user()->image) }}" alt=""></figure>
                                    @endif
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <div class="client-name">
                                            <div class="drop-cap" style="background: #0747A6; color: #fff;">{{substr(Auth::user()->first_name, 0, 1)}}</div>
                                            <div class="client-info">
                                                <h6 class="mb-0">{{substr(Auth::user()->first_name.' '.Auth::user()->last_name, 0, 15)}} <small>{{Auth::user()->role_type}}</small> </h6>
                                                
                                            </div>
                                        </div>
                                        <ul>
                                            <li><a href="{{ route('settings') }}"> My Account</a></li>
                                            <!-- <li><a href="#"> Support</a></li> -->
                                            <!-- <li><a href="#"> Notifications </a></li> -->
                                            <li><a href="{{ route('logout') }}">Logout</a></li>
                                          </ul>
                                    </div>
                                    
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
    <!-- Core theme JS-->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/jquery/dist/jquery.min.js') }}"></script>

    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    {{-- <link rel="stylesheet" href="{{ asset('js/bootstrap/dist/css/bootstrap.min.css') }}"> --}}

    @if(Route::current()->getName() == 'forms.show')
        <link rel="stylesheet" href="{{ asset('js/bootstrap-icons/font/bootstrap-icons.css') }}">
        <script src="{{ asset('js/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    @elseif(Route::current()->getName() == 'calender.index')
        <script src="{{ asset('js/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    @else
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
        <script src="{{ asset('js/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    @endif

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
    <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script src="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1569006273/BBBootstrap/choices.min.js?version=7.0.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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
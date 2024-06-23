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

    <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/core@4.4.0/main.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/timeline@4.4.0/main.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/resource-timeline@4.4.0/main.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.9.0/fullcalendar.min.css" rel="stylesheet" type="text/css" />
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
                    <li class="{{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.index') }}"><i class="ico-dashboard"></i>Dashboard</a>
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
                ->select('clients.firstname','clients.lastname','appointment.start_date', 'services.service_name','appointment.id','appointment.location_id') // Select the name column from the clients table and the service_name column from the service table
                ->orderBy('appointment.start_date', 'asc') // Order by start_date in ascending order
                ->take(5)
                ->get();
            @endphp
            @if(Auth::check() && (Auth::user()->role_type == 'admin'))
            <div class="next-appointment mt-3">
                <h5 class="mb-3">Next 5 Appointments</h5>
                @if(count($data)>0)
                    @foreach($data as $app_data)
                    <a href="javascript:void(0);" class="apnt-box next_5_appt" data-id="{{ $app_data->id }}" loc-id="{{$app_data->location_id}}">
                            <h6 class="blue-bold">{{$app_data->firstname.' '.$app_data->lastname}}</h6>
                            <span class="font-14 d-grey">{{$app_data->service_name}}</span><br>
                            <time><i class="ico-clock me-1"></i> {{ date('d-m-Y h:i A', strtotime($app_data->start_date)) }}</time>
                        </a>
                    @endforeach
                @else
                    <div>No appointment found</div>
                @endif
            </div>
            @elseif(Auth::user()->checkPermission('calender') == 'View Only' || Auth::user()->checkPermission('calender') == 'View & Make Changes'|| Auth::user()->checkPermission('calender') == 'Both')
            <div class="next-appointment mt-3">
                <h5 class="mb-3">Next 5 Appointments</h5>
                @if(count($data)>0)
                    @foreach($data as $app_data)
                        <a href="javascript:void(0);" class="apnt-box next_5_appt" data-id="{{ $app_data->id }}" loc-id="{{$app_data->location_id}}">
                            <h6 class="blue-bold">{{$app_data->firstname.' '.$app_data->lastname}}</h6>
                            <span class="font-14 d-grey">{{$app_data->service_name}}</span><br>
                            <time><i class="ico-clock me-1"></i> {{ date('d-m-Y h:i A', strtotime($app_data->start_date)) }}</time>
                        </a>
                    @endforeach
                @else
                    <div>No appointment found</div>
                @endif
            </div>
            @endif
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
                                    <a href="#" class="profile" id="dropdownMenuClickableInside" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"><aside>Hi, <span>{{substr(Auth::user()->first_name.' '.Auth::user()->last_name, 0, 15)}}</span></aside>
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
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="{{ asset('js/fullcalendar-scheduler-6.1.10/dist/index.global.js') }}"></script>
    <script src="{{ asset('js/fullcalendar-scheduler-6.1.10/dist/index.global.min.js') }}"></script>
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

        $('.next_5_appt').on('click', function() {
            var appointmentId = $(this).data('id');
            var locationId = $(this).attr('loc-id');

            // Store the appointment ID in local storage
            localStorage.setItem('appointmentId', appointmentId);
            localStorage.setItem('locationId', locationId);
            // Redirect to the calendar page
            window.location.href = '/calender';
        });

        // Check if there is an appointment ID in local storage
        var appointmentId = localStorage.getItem('appointmentId');
        var locationId = localStorage.getItem('locationId');

        if (appointmentId) {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl);
            // Clear the appointment ID from local storage
            localStorage.removeItem('appointmentId');
            localStorage.removeItem('locationId');
            
            
            // Generate the correct route URL
            var url = '{{ route("calendar.get-event-by-id", ":appointmentId") }}';
            url = url.replace(':appointmentId', appointmentId);

            // Example AJAX request
            $.ajax({
                url: url,
                method: 'GET',
                success: function (response) {
                    const disabledAttr = localStorage.getItem('permissionValue') !== '1' ? 'disabled' : '';
                    var userArray      = response.data.client_id;
                    var userHtml       = '';

                    if (userArray != 0) {
                        userHtml = `<div class="client-name">
                                <div class="drop-cap" style="background: #D0D0D0; color:#fff;">${response.data.client_data.first_name.charAt(0).toUpperCase()}
                                </div>
                                <div class="client-info">
                                    <input type='hidden' name='client_name' value='${response.data.client_data.first_name} ${response.data.client_data.last_name}'>
                                    <input type='hidden' id="client_id" name='client_id' value='${response.data.client_data.id}'>
                                    <input type='hidden' id="category_id" name='category_id' value='${response.data.category_id}'>
                                    <input type='hidden' id="service_id" name='service_id' value='${response.data.services_id}'>
                                    <input type='hidden' id="staff_id" name='staff_id' value='${response.data.staff_id}'>
                                    <input type='hidden' id="start_date" name='start_date' value='${response.data.date}'>
                                    <input type='hidden' name='appointment_duration' value='${response.data.duration}'>
                                    <h4 class="blue-bold">${response.data.client_data.first_name} ${response.data.client_data.last_name}</h4>
                                </div>
                            </div>
                            <div class="mb-2">
                                <a href="#" class="river-bed"><b>${response.data.client_data.mobile_no}</b></a><br>
                                <a href="#" class="river-bed"><b>${response.data.client_data.email}</b></a>
                            </div>
                            <hr>
                            <div class="btns">
                                <button class="btn btn-secondary btn-sm open-client-card-btn" data-client-id="${response.data.client_data.id}" ${disabledAttr}>Client Card</button>
                                <button class="btn btn-secondary btn-sm history" data-client-id="${response.data.client_data.id}" ${disabledAttr}>History</button>
                                <button class="btn btn-secondary btn-sm upcoming" data-client-id="${response.data.client_data.id}" ${disabledAttr}>Upcoming</button>
                            </div>
                            <hr>`;
                        userFullname = response.data.client_data.first_name +' '+ response.data.client_data.last_name;
                    } else {
                        userHtml = '';
                        userFullname = '';
                    }
                    $('#clientDetails').html(
                        ` ${userHtml}
                            <div id="editEventData">
                            <div class="summry-header"><span class="ico-clock me-2 fs-4"></span> Appointment Summary</div>
                            <div class="river-bed mb-3">
                                Date:<br>
                                <b>${response.data.appointment_date}</b>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary btn-md blue-alter move_appointment" ${disabledAttr}>Move Appointment</button>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Status </label>
                                <input type="hidden" name="appointment_id" value=${response.data.id}>
                                <select class="form-select form-control change_status" id="appointment_status" ${disabledAttr}>
                                    <option value="1" ${response.data.status_no == 1 ? 'selected' : ''}>Booked</option>
                                    <option value="2" ${response.data.status_no == 2 ? 'selected' : ''}>Confirmed</option>
                                    <option value="3" ${response.data.status_no == 3 ? 'selected' : ''}>Started</option>
                                    <option value="4" ${response.data.status_no == 4 ? 'selected' : ''}>Completed</option>
                                    <option value="5" ${response.data.status_no == 5 ? 'selected' : ''}>No Answer</option>
                                    <option value="6" ${response.data.status_no == 6 ? 'selected' : ''}>Left Message</option>
                                    <option value="7" ${response.data.status_no == 7 ? 'selected' : ''}>Pencilied In</option>
                                    <option value="8" ${response.data.status_no == 8 ? 'selected' : ''}>Turned Up</option>
                                    <option value="9" ${response.data.status_no == 9 ? 'selected' : ''}>No Show</option>
                                    <option value="10" ${response.data.status_no == 10 ? 'selected' : ''}>Cancelled</option>
                                </select>
                            </div>
                            <div class="river-bed mb-3 reminder">
                                Reminder<br>
                                <div class="d-flex align-items-center mt-1"><span class="ico-clock me-1 fs-5"></span> SMS to be sent</div>
                            </div>
                            <div class="orange-box mb-3">
                                <p><b id='servicename'>${response.data.services_name}</b>
                                <label id='servicewithdoctor'>${response.data.appointment_time} with ${response.data.staff_name}</label></p>
                                <input type="hidden" id="check_edit_appt" value="">
                                <input type="hidden" id="service_name" value="${response.data.services_name}">
                                <input type="hidden" id="service_id" value="${response.data.service_id}">
                                <input type="hidden" id="category_id" value="${response.data.category_id}">
                                <input type="hidden" id="client_id" value="${response.data.client_data.id ? response.data.client_data.id : 0}">
                                <input type="hidden" id="client_name" value="${userFullname ? userFullname : ''}">
                                <input type="hidden" id="duration" value="${response.data.duration}">
                                <input type="hidden" id="appointment_time" value="${response.data.appointment_time}">
                                <input type="hidden" id="staff_name" value="${response.data.staff_name}">
                                <input type="hidden" id="staff_id" value="${response.data.staff_id}">
                                <input type="hidden" id="location_id" value="${response.data.location_id}">
                            </div>
                            <div class="btns mb-3">
                                <button class="btn btn-secondary btn-sm" id="edit_appointment" event_id="${response.data.id}" staff_id="${response.data.staff_id}" appointment_date="${response.data.appointment_date}" appointment_time="${response.data.appointment_time}" staff_name="${response.data.staff_name}" service_name="${response.data.services_name}" duration="${response.data.duration}" category_id="${response.data.category_id}" location_id="${response.data.location_id}" services_id="${response.data.service_id}" client-id="${response.data.id}" client-name="${response.data.client_data.first_name + ' ' + response.data.client_data.last_name}" edit-service-name="${response.data.service_id}" ${response.data.status_no == 4 ? 'disabled' : ''} ${disabledAttr}>Edit Appt</button>
                                <button class="btn btn-secondary btn-sm" id="edit_forms" data-appt_id="${response.data.id}" ${disabledAttr}>Edit Forms</button>
                                <button class="btn btn-secondary btn-sm rebook" ${disabledAttr}>Rebook</button>
                                <button class="btn btn-secondary btn-sm repeat_appt" ${disabledAttr}>Repeat Appt</button>
                                <button class="btn btn-secondary btn-sm" ${disabledAttr}>Messages</button>
                                <button class="btn btn-secondary btn-sm" id="send_apt_details" ${disabledAttr}>Send appt details</button>
                                ${response.data.status_no == 4 ? `<button class="btn btn-secondary btn-sm view_invoice" walk_in_ids="${response.data.walk_in_id}" ${disabledAttr}>View paid invoice</button>` : '<button class="btn btn-secondary btn-sm view_invoice" walk_in_ids="${response.data.walk_in_id}"  style="display:none;">View paid invoice</button>'}
                            </div>
                            ${response.data.status_no != 4 ? `<button id="make_sale" class="btn btn-primary btn-md mb-2 d-block make_sale w-100" product_id="${response.data.service_id}" product_name="${response.data.services_name}" product_price="${response.data.standard_price}" appt_id="${response.data.id}" staff_id="${response.data.staff_id}" ${disabledAttr}>Make Sale</button>` : ''}

                            ${response.data.status_no != 4 ? `<div class="text-end"><button class="btn btn-primary btn-md blue-alter" id="deleteAppointment" ${disabledAttr}>Delete</button></div>`:''}
                            <hr>
                            <div class="form-group">
                                <label class="form-label">Notes</label>
                                <textarea rows="4" class="form-control" placeholder="Click to edit" id="commonNotes" ${disabledAttr}>${response.data.common_notes ?? ''}</textarea>
                                <label class="form-label">Treatment Notes</label>
                                <textarea rows="4" class="form-control" placeholder="Click to edit" id="treatmentNotes" ${disabledAttr}>${response.data.treatment_notes ?? ''}</textarea>
                            </div>
                            </div>`
                    );
                    // alert('1');
                    $('#locations').val(locationId);
                    

                    //location dropdown selected and also staff filter
                    // jQuery('#locations').on('change', function(e) {
                        var context = this;
                        var location_id           = locationId;
                        sessionStorage.setItem("loc_ids", location_id);
                        var selected_loc_id = location_id;
                        var selected_loc_name = $('#locations option:selected').text();
                        $('.walkin_loc_name').text(selected_loc_name);
                        $('.walk_in_location_id').val(selected_loc_id);
                        $.ajax({
                            url: moduleConfig.getStaffList,
                            type: 'POST',
                            data: {
                                'location_id'    : location_id,
                            },
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (data) {
                                
                                // console.log('test',context.calendar);
                                // Update the FullCalendar resources with the retrieved data
                                calendar.setOption('resources', data);
                                calendar.refetchEvents(); // Refresh events if needed

                                $('#staff').empty();
                                $('#staff').append(`<option value="all">All staff</option>
                                        <option disabled>Individual staff</option>`);
                                if (data && data.length > 0) {
                                    data.forEach(function (name) {
                                        let fullName = name.title;
                                        let id = name.id;
                                        $('#staff').append($('<option>', { value: id, text: fullName }));
                                    });
                                }
                            },
                            error: function (error) {
                                console.error('Error fetching resources:', error);
                            }
                        });
                        $.ajax({
                            url: moduleConfig.getSelectedLocation,
                            type: 'POST',
                            data: { loc_id: selected_loc_id },
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                product_details = response.mergedProductService;
                                discount_types_details = response.loc_dis;
                                surcharge_types_details = response.loc_sur;
                                console.log('discount_types_details1',discount_types_details);
                                console.log('surcharge_types_details',surcharge_types_details);
                                
                                // Clear existing options
                                $('#discount_surcharge').empty();

                                // Add default options
                                $('#discount_surcharge').append($('<option>', { value: '', text: 'No Discount' }));
                                $('#discount_surcharge').append($('<optgroup label="Discount"><option>Manual Discount</option></optgroup>'));
                                $('#discount_surcharge').append($('<optgroup label="Surcharge"><option>Manual Surcharge</option></optgroup>'));

                                // Add options based on the received arrays
                                if (discount_types_details && discount_types_details.length > 0) {
                                    // Add discount options
                                    var discountOptgroup = $('#discount_surcharge optgroup[label="Discount"]');
                                    discount_types_details.forEach(function (discount) {
                                        discountOptgroup.append($('<option>', { value: discount.discount_percentage, text: discount.discount_type }));
                                    });
                                }

                                if (surcharge_types_details && surcharge_types_details.length > 0) {
                                    // Add surcharge options
                                    var surchargeOptgroup = $('#discount_surcharge optgroup[label="Surcharge"]');
                                    surcharge_types_details.forEach(function (surcharge) {
                                        surchargeOptgroup.append($('<option>', { value: surcharge.surcharge_percentage, text: surcharge.surcharge_type }));
                                    });
                                }

                                // Clear existing options
                                $('#edit_discount_surcharge').empty();

                                // Add default options
                                $('#edit_discount_surcharge').append($('<option>', { value: '', text: 'No Discount' }));
                                $('#edit_discount_surcharge').append($('<optgroup label="Discount"><option value="0">Manual Discount</option></optgroup>'));
                                $('#edit_discount_surcharge').append($('<optgroup label="Surcharge"><option value="0">Manual Surcharge</option></optgroup>'));

                                // Add options based on the received arrays
                                if (discount_types_details && discount_types_details.length > 0) {
                                    // Add discount options
                                    var discountOptgroup = $('#edit_discount_surcharge optgroup[label="Discount"]');
                                    discount_types_details.forEach(function (discount) {
                                        discountOptgroup.append($('<option>', { value: discount.discount_percentage, text: discount.discount_type }));
                                    });
                                }

                                if (surcharge_types_details && surcharge_types_details.length > 0) {
                                    // Add surcharge options
                                    var surchargeOptgroup = $('#edit_discount_surcharge optgroup[label="Surcharge"]');
                                    surcharge_types_details.forEach(function (surcharge) {
                                        surchargeOptgroup.append($('<option>', { value: surcharge.surcharge_percentage, text: surcharge.surcharge_type }));
                                    });
                                }
                            },
                            error: function (error) {
                                console.error('Error storing location ID:', error);
                            }
                        });
                    // });
                },
                error: function (error) {
                    console.error('Error fetching events:', error);
                }
            });
        }
    });
    </script>
</body>

</html>
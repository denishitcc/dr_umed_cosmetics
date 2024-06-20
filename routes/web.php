<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\AccessLevelController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\EmailTemplatesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\SMSTemplatesController;
use App\Http\Controllers\EnquiriesController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\ProductCategoriesController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\DiscountCouponsController;
use App\Http\Controllers\GiftCardsController;
use App\Http\Controllers\TimeTableController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
// Route::get('registration', [AuthController::class, 'registration'])->name('register');
// Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('forgot-password', [AuthController::class, 'forgotpassword'])->name('forgotpassword');
Route::post('forget-password', [AuthController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [AuthController::class, 'submitResetPasswordForm'])->name('reset.password.post');

//google login
Route::get('authorized/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('authorized/google/callback', [AuthController::class, 'handleGoogleCallback']);

//facebook login
Route::get('auth/facebook', [AuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback', [AuthController::class, 'handleFacebookCallback']);

Route::middleware(['auth'])->group(function () {
    // Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    //get all locations
    Route::post('/get-all-locations', [UsersController::class, 'get_all_locations'])->name('get-all-locations');
    Route::post('/get-forms', [UsersController::class, 'getForms'])->name('get-forms');
    //get selected locations
    Route::post('calendar/get-selected-location', [CalenderController::class, 'GetLocation'])->name('calendar.get-selected-location');
    //get category services
    Route::post('calender/get-category-services', [CalenderController::class,'getCategoryServices'])->name('calender.get-category-services');
    //get all clients
    Route::post('calender/get-all-clients',[CalenderController::class, 'getAllClients'])->name('calendar.get-all-clients');
    //add new waitlist client
    Route::post('calender/add-waitlist-client',[CalenderController::class, 'CreateWaitListClient'])->name('calendar.calender/add-waitlist-client');
    
    //settings
    Route::middleware('permission:settings')->group(function () {
        Route::get('/settings', [SettingsController::class, 'settings'])->name('settings');
        Route::post('/change-password', [SettingsController::class, 'changePasswordSave'])->name('change-password');
        Route::post('/my-account', [SettingsController::class, 'changeMyAccountSave'])->name('my-account');
        Route::post('/update-business-settings', [SettingsController::class, 'UpdateBusinessSettings'])->name('update-business-settings');
        Route::post('/get-business-details', [SettingsController::class, 'GetBusinessDetails'])->name('get-business-details');
        Route::post('/update-brand-image', [SettingsController::class, 'UpdateBrandImage'])->name('update-brand-image');

        //User Role
        Route::resource('users-roles', UserRoleController::class);
        Route::post('users-roles/table',[UserRoleController::class, 'index'])->name('users-roles.table');

        //Access Level
        Route::get('/access-level', [AccessLevelController::class, 'access_level'])->name('access-level');
        Route::post('/update-appointment-clients', [AccessLevelController::class, 'update_appointment_client'])->name('update-appointment-clients');
    });

    //users
    Route::middleware('permission:users')->group(function () {
        Route::resource('users', UsersController::class);
        Route::post('users/table',[UsersController::class, 'index'])->name('users.table');
        Route::post('users/checkEmail', [UsersController::class, 'checkEmail']);
        Route::post('users/update_info', [UsersController::class, 'update_info'])->name('update_info');
        Route::post('users/updateStatus', [UsersController::class, 'updateStatus']);
        Route::post('users/copy-capabilities', [UsersController::class, 'copyCapabilities'])->name('user.copyCapabilities');
        Route::get('timetable', [TimeTableController::class, 'index'])->name('user.timetable');
        Route::post('timetable/update-working-hours', [TimeTableController::class, 'updateWorkingHours'])->name('timetable.updateWorkingHours');
        Route::post('timetable/get-working-hours', [TimeTableController::class, 'getWorkingHours'])->name('timetable.getWorkingHours');
        // Route::post('/get-all-locations', [UsersController::class, 'get_all_locations'])->name('get-all-locations');
    });

    //Email Templates
    Route::middleware('permission:email-templates')->group(function () {
        Route::resource('/email-templates', EmailTemplatesController::class);
        Route::post('email-templates/table',[EmailTemplatesController::class, 'index'])->name('email-templates.table');
    });

    //Clients
    Route::middleware('permission:clients')->group(function () {
        Route::resource('/clients', ClientsController::class);
        Route::post('clients/table',[ClientsController::class, 'index'])->name('clients.table');
        Route::post('clients/checkClientEmail', [ClientsController::class, 'checkClientEmail']);
        Route::post('clients/updateStatus', [ClientsController::class, 'updateStatus']);
        Route::post('clients/updatePhotos', [ClientsController::class, 'updatePhotos'])->name('clients-photos');
        Route::post('clients/updateDocuments', [ClientsController::class, 'updateDocuments'])->name('clients-documents');
        Route::post('clients/removeDocuments', [ClientsController::class, 'removeDocuments'])->name('clients-documents-remove');
        Route::post('clients/removePhotos', [ClientsController::class, 'removePhotos'])->name('clients-photos-remove');
        // Route::post('/get-all-locations', [UsersController::class, 'get_all_locations'])->name('get-all-locations');
    });

    //SMS Templates
    Route::middleware('permission:sms-templates')->group(function () {
        Route::resource('/sms-templates', SMSTemplatesController::class);
    });

    //Enquiries
    Route::middleware('permission:enquiries')->group(function () {
        Route::resource('/enquiries', EnquiriesController::class);
        Route::post('enquiries/table',[EnquiriesController::class, 'index'])->name('enquiries.table');
    });

    //Location
    Route::middleware('permission:locations')->group(function () {
        //locations
        Route::resource('locations', LocationsController::class);
        Route::post('locations/table',[LocationsController::class, 'index'])->name('locations.table');
        // Route::post('/get-all-locations', [UsersController::class, 'get_all_locations'])->name('get-all-locations');
    });

    //Suppliers
    Route::middleware('permission:suppliers')->group(function () {
        Route::resource('/suppliers', SuppliersController::class);
        Route::post('suppliers/table',[SuppliersController::class, 'index'])->name('suppliers.table');
        Route::post('suppliers/checkSupplierEmail', [SuppliersController::class, 'checkSupplierEmail']);
    });

    //Services
    Route::middleware('permission:services')->group(function () {
        Route::resource('/services', ServicesController::class);
        Route::post('services/store-category',[ServicesController::class, 'store_category'])->name('services.store-category');
        Route::post('services/update-category',[ServicesController::class, 'update_category'])->name('services.update-category');
        Route::post('services/get-services',[ServicesController::class, 'get_services'])->name('services.get-services');
        Route::post('services/change-services-availability',[ServicesController::class, 'change_services_availability'])->name('services.change-services-availability');
        Route::post('services/checkCategoryName', [ServicesController::class, 'checkCategoryName']);
        Route::post('services/checkServiceName', [ServicesController::class, 'checkServiceName']);
        Route::post('services/import',[ServicesController::class, 'import'])->name('services.import');
        Route::delete('/delete-category/{id}', [ServicesController::class, 'destroyCategory'])->name('delete.category');
    });

    //Products
    Route::middleware('permission:products')->group(function () {
        Route::resource('/products', ProductsController::class);
        Route::post('products/table',[ProductsController::class, 'index'])->name('products.table');
        Route::post('products/update-product-category',[ProductsController::class, 'updateProductCategory'])->name('products.update-product-category');
        Route::post('products/change-product-availability',[ProductsController::class, 'changeProductAvailability'])->name('products.change-product-availability');
        Route::post('products/update-stocks-level-products',[ProductsController::class, 'changeStocksLevel'])->name('products.update-stocks-level-products');
        Route::post('products/import',[ProductsController::class, 'import'])->name('products.import');
        Route::post('products/product-performance',[ProductsController::class, 'productPerformance'])->name('products.product-performance');

        //Product Categories
        Route::resource('/products-categories', ProductCategoriesController::class);
        Route::post('products-categories/table',[ProductCategoriesController::class, 'index'])->name('products-categories.table');
    });

    //forms
    Route::middleware('permission:forms')->group(function () {
        Route::resource('/forms', FormsController::class);
        Route::post('forms/table',[FormsController::class, 'index'])->name('forms.table');
        Route::post('forms/update',[FormsController::class, 'formUpdate'])->name('serviceforms.formUpdate');
        Route::post('forms/updatehtml',[FormsController::class, 'formHTMLUpdate'])->name('serviceforms.formHTMLUpdate');
        Route::get('forms/preview/{id}',[FormsController::class, 'formPreview'])->name('serviceforms.formPreview');
        Route::post('forms/deleteform',[FormsController::class, 'formDelete'])->name('serviceforms.formDelete');
        Route::post('forms/updateform',[FormsController::class, 'serviceFormUpdate'])->name('serviceforms.serviceFormUpdate');
    });

    //Calender
    Route::middleware('permission:calender')->group(function () {
        Route::resource('/calender', CalenderController::class);
        // Route::post('calender/get-category-services', [CalenderController::class,'getCategoryServices'])->name('calender.get-category-services');
        // Route::post('calender/get-all-clients',[CalenderController::class, 'getAllClients'])->name('calendar.get-all-clients');
        Route::post('calender/create-appointments',[CalenderController::class, 'createAppointments'])->name('calendar.create-appointments');
        Route::post('calender/update-appointments',[CalenderController::class, 'updateAppointments'])->name('calendar.update-appointments');
        Route::post('calender/get-events',[CalenderController::class, 'getEvents'])->name('calendar.get-events');
        Route::get('calender/get-client-card-data/{id}',[CalenderController::class, 'getClientCardData'])->name('calendar.get-client-card-data');
        Route::post('calender/add-appointment-notes',[CalenderController::class, 'addAppointmentNotes'])->name('calendar.add-appointment-notes');
        Route::post('calender/add-appointment-treatment-notes',[CalenderController::class, 'addAppointmentTreatmentNotes'])->name('calendar.add-appointment-treatment-notes');
        Route::post('calender/view-appointment-notes',[CalenderController::class, 'viewAppointmentNotes'])->name('calendar.view-appointment-notes');
        Route::get('calender/get-event-by-id/{id}',[CalenderController::class, 'getEventById'])->name('calendar.get-event-by-id');
        Route::post('calender/upcoming-appointment',[CalenderController::class, 'UpcomingAppointment'])->name('calendar.upcoming-appointment');
        Route::post('calender/history-appointment',[CalenderController::class, 'HistoryAppointment'])->name('calendar.history-appointment');
        Route::post('calender/update-appointment-status',[CalenderController::class, 'updateAppointmentStatus'])->name('calendar.update-appointment-status');
        Route::delete('calender/delete-appointment/{id}',[CalenderController::class, 'deleteAppointment'])->name('calendar.delete-appointment');
        Route::post('calender/update-create-appointments',[CalenderController::class, 'updateCreateAppointments'])->name('calendar.update-create-appointments');
        Route::post('calender/repeat-appointment',[CalenderController::class, 'repeatAppointment'])->name('calendar.repeat-appointment');
        // Route::post('calender/add-waitlist-client',[CalenderController::class, 'CreateWaitListClient'])->name('calendar.calender/add-waitlist-client');
        Route::get('calendar/filter-calendar-date', [CalenderController::class, 'filterCalendarDate'])->name('calendar.filter-current-date');
        Route::get('calendar/filter-staff', [CalenderController::class, 'filterCalendarStaff'])->name('calendar.filter-staff');
        Route::post('calender/update-waitlist-client',[CalenderController::class, 'UpdateWaitListClient'])->name('calendar/update-waitlist-client');
        Route::delete('calender/delete-waitlist-client/{id}',[CalenderController::class, 'deleteWaitlistClient'])->name('calendar.delete-waitlist-client');
        Route::post('calender/get-all-products-services',[CalenderController::class, 'getAllProductsServices'])->name('calendar.get-all-products-services');
        // Route::post('calender/calender.store-walk-in',[CalenderController::class, 'StoreWalkIn'])->name('calendar.store-walk-in');
        Route::post('calendar/store-walk-in', [CalenderController::class, 'StoreWalkIn'])->name('calendar.store-walk-in');
        // Route::post('calendar/get-selected-location', [CalenderController::class, 'GetLocation'])->name('calendar.get-selected-location');
        Route::post('calendar/get-categories-and-services', [CalenderController::class, 'getCategoriesAndServices'])->name('calendar.get-categories-and-services');
        Route::post('calendar/paid-invoice', [CalenderController::class, 'paidInvoice'])->name('calendar.paid-invoice');
        Route::delete('calender/delete-walk-in/{id}',[CalenderController::class, 'deleteWalkIn'])->name('calendar.delete-walk-in');
        Route::post('calendar/edit-invoice', [CalenderController::class, 'editInvoice'])->name('calendar.edit-invoice');
        Route::post('calendar/send-payment-mail', [CalenderController::class, 'sendPaymentMail'])->name('calendar.send-payment-mail');
        Route::post('/get-staff-list', [CalenderController::class,'getStaffList'])->name('get-staff-list');
        Route::post('/calender.get-user-selected-location', [CalenderController::class,'getUserSelectedLocation'])->name('calender.get-user-selected-location');
        Route::get('calender/get-appointment-forms/{id}',[CalenderController::class, 'getAppointmentForms'])->name('calendar.get-appointment-forms');
        Route::post('calender/add-appointment-forms',[CalenderController::class, 'addAppointmentForms'])->name('calendar.add-appointment-forms');
        Route::delete('calender/delete-appointment-forms/{id}',[CalenderController::class, 'deleteAppointmentForms'])->name('calendar.delete-appointment-forms');
        Route::post('calendar/sent-forms',[CalenderController::class, 'sentForms'])->name('calendar.sent-forms');
        Route::post('calendar/appt-confirmation',[CalenderController::class, 'apptConfirmation'])->name('calendar.appt-confirmation');
        Route::get('calender/get-client-forms-data/{id}',[CalenderController::class, 'getClientFormsData'])->name('calendar.get-client-forms-data');
        Route::post('calender/update-client-status-form',[CalenderController::class, 'updateClientStatusForm'])->name('calendar.update-client-status-form');
    });

    //finance
    Route::middleware('permission:finance')->group(function () {
        Route::resource('finance', FinanceController::class);
        Route::post('finance/table',[FinanceController::class, 'index'])->name('finance.table');
        Route::get('/search-gift-card', [FinanceController::class, 'search_gift_card'])->name('search-gift-card');
        Route::get('/get-gift-card-history', [FinanceController::class, 'get_gift_card_history'])->name('get-gift-card-history');
    });

    //discount coupons
    Route::middleware('permission:discount-coupons')->group(function () {
        Route::resource('discount-coupons', DiscountCouponsController::class);
        Route::post('discount-coupons/table',[DiscountCouponsController::class, 'index'])->name('discount-coupons.table');
    });

    //gift cards
    Route::middleware('permission:gift-card')->group(function () {
        Route::resource('gift-card', GiftCardsController::class);
        Route::post('gift-card/table',[GiftCardsController::class, 'index'])->name('gift-card.table');
        Route::post('gift-card/transactions',[GiftCardsController::class, 'transactions'])->name('gift-card.transactions');
        Route::post('gift-card/cancel',[GiftCardsController::class, 'cancel_gift_card'])->name('gift-card.cancel');
        Route::post('gift-card/email_gift_card',[GiftCardsController::class, 'email_gift_card'])->name('gift-card.email-gift-card');
        Route::get('/gift-card/email-history/{voucher_num}', [GiftCardsController::class, 'get_email_history'])->name('gift-card.email-history');
    });

    //dashboard
    Route::resource('dashboard', DashboardController::class);
    Route::post('dashboard/filter',[DashboardController::class, 'filter'])->name('dashboard.filter');
    Route::post('dashboard/sales-performance-filter',[DashboardController::class, 'sales_performance_filter'])->name('dashboard.sales_performance_filter');
});
Route::post('/get-staff-list', [CalenderController::class,'getStaffList'])->name('get-staff-list');
Route::post('forms/deleteform',[FormsController::class, 'formDelete'])->name('serviceforms.formDelete');
Route::get('forms/userform/{apptid}/{id}',[FormsController::class, 'formUser'])->name('serviceforms.formUser');

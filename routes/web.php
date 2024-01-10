<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\AccessLevelController;
use App\Http\Controllers\EmailTemplatesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\SMSTemplatesController;
use App\Http\Controllers\EnquiriesController;
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
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

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
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/settings', [SettingsController::class, 'settings'])->name('settings');
    Route::post('/change-password', [SettingsController::class, 'changePasswordSave'])->name('change-password');
    Route::post('/my-account', [SettingsController::class, 'changeMyAccountSave'])->name('my-account');
    Route::post('/update-business-settings', [SettingsController::class, 'UpdateBusinessSettings'])->name('update-business-settings');
    Route::post('/get-business-details', [SettingsController::class, 'GetBusinessDetails'])->name('get-business-details');
    Route::post('/update-brand-image', [SettingsController::class, 'UpdateBrandImage'])->name('update-brand-image');
    //locations
    Route::resource('locations', LocationsController::class);
    Route::post('locations/table',[LocationsController::class, 'index'])->name('locations.table');

    //users
    Route::resource('users', UsersController::class);
    Route::post('users/table',[UsersController::class, 'index'])->name('users.table');
    Route::post('users/checkEmail', [UsersController::class, 'checkEmail']);
    Route::post('users/update_info', [UsersController::class, 'update_info'])->name('update_info');
    Route::post('users/updateStatus', [UsersController::class, 'updateStatus']);
    
    //User Role
    Route::resource('users-roles', UserRoleController::class);
    Route::post('users-roles/table',[UserRoleController::class, 'index'])->name('users-roles.table');

    //Access Level
    Route::get('/access-level', [AccessLevelController::class, 'access_level'])->name('access-level');
    Route::post('/update-appointment-clients', [AccessLevelController::class, 'update_appointment_client'])->name('update-appointment-clients');
    Route::post('/update-sales', [AccessLevelController::class, 'update_sales'])->name('update-sales');
    Route::post('/update-reporting', [AccessLevelController::class, 'update_reporting'])->name('update-reporting');
    Route::post('/update-staff', [AccessLevelController::class, 'update_staff'])->name('update-staff');
    Route::post('/update-marketing', [AccessLevelController::class, 'update_marketing'])->name('update-marketing');
    Route::post('/update-administration', [AccessLevelController::class, 'update_administration'])->name('update-administration');

    //Email Templates
    Route::resource('/email-templates', EmailTemplatesController::class); 
    Route::post('email-templates/table',[EmailTemplatesController::class, 'index'])->name('email-templates.table');

    //Clients
    Route::resource('/clients', ClientsController::class); 
    Route::post('clients/table',[ClientsController::class, 'index'])->name('clients.table');
    Route::post('clients/checkClientEmail', [ClientsController::class, 'checkClientEmail']);

    //SMS Templates
    Route::resource('/sms-templates', SMSTemplatesController::class);

    //Enquiries
    Route::resource('/enquiries', EnquiriesController::class); 
    Route::post('enquiries/table',[EnquiriesController::class, 'index'])->name('enquiries.table');

    //Get All Location
    Route::post('/get-all-locations', [UsersController::class, 'get_all_locations'])->name('get-all-locations');
});
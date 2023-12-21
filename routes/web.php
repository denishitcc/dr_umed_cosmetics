<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserRoleController;
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
    Route::resource('locations', LocationsController::class)->except([
        'index'
    ]);
    
    Route::match(['get', 'post'], 'locations',[LocationsController::class, 'index'])->name('locations.index');
    Route::post('locations/store', [LocationsController::class, 'store'])->name('locations.store');

    //users
    Route::resource('users', UsersController::class)->except([
        'index'
    ]);
    Route::match(['get', 'post'], 'users',[UsersController::class, 'index'])->name('users.index');
    Route::post('users/store', [UsersController::class, 'store'])->name('users.store');

    Route::post('users/checkEmail', [UsersController::class, 'checkEmail']);
    Route::post('users/update_info', [UsersController::class, 'update_info'])->name('update_info');
    Route::post('users/updateStatus', [UsersController::class, 'updateStatus']);
    
    //User Role
    Route::resource('users-roles', UserRoleController::class)->except([
        'index'
    ]);
    Route::match(['get', 'post'], 'users-roles',[UserRoleController::class, 'index'])->name('users-roles.index');
    Route::post('users-roles/store', [UserRoleController::class, 'store'])->name('users-roles.store');
});
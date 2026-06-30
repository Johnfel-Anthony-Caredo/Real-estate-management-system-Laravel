<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Props\PropertiesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', [PropertiesController::class, 'index'])->name('home');
Route::get('/about', function () {
    return view('props.about');
})->name('props.about');
Route::get('/prop-details/{id}', [PropertiesController::class, 'single'])->name('single.prop');
Route::get('/properties/hometype/{hometype}', [PropertiesController::class, 'displayByHomeType'])->name('display.prop.hometype');
Route::get('/search', [PropertiesController::class, 'searchProperties'])->name('search.properties');

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminsController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminsController::class, 'login'])->middleware('throttle:5,1');
    Route::post('logout', [AdminsController::class, 'logout'])->name('admin.logout');
    
    // Protected admin routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [AdminsController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('users', [UserController::class, 'showUsers'])->name('admin.users');
        Route::post('users', [UserController::class, 'storeUser'])->name('user.store');
        Route::get('users/{id}/edit', [UserController::class, 'editUser'])->name('user.edit');
        Route::post('users/{id}', [UserController::class, 'updateUser'])->name('user.update');
        Route::delete('users/{id}', [UserController::class, 'deleteUser'])->name('user.delete');
        Route::post('check_email', [UserController::class, 'checkEmail'])->name('user.check-email');

        Route::get('admins', [AdminsController::class, 'showAdmins'])->name('admin.admins');
        Route::post('admins', [AdminsController::class, 'storeAdmin'])->name('admin.store');
        Route::get('admins/{id}/edit', [AdminsController::class, 'editAdmin'])->name('admin.edit');
        Route::post('admins/{id}', [AdminsController::class, 'updateAdmin'])->name('admin.update');
        Route::delete('admins/{id}', [AdminsController::class, 'deleteAdmin'])->name('admin.delete');
        Route::post('check_admin_email', [AdminsController::class, 'checkEmail'])->name('admin.check-email');

        Route::get('properties', [AdminsController::class, 'showProperties'])->name('admin.properties');
        Route::get('properties/create', [AdminsController::class, 'showAddPropertyForm'])->name('property.add');
        Route::post('properties', [AdminsController::class, 'storeProperty'])->name('property.store');
        Route::get('properties/{id}/edit', [AdminsController::class, 'editProperty'])->name('property.edit');
        Route::post('properties/{id}', [AdminsController::class, 'updateProperty'])->name('property.update');
        Route::delete('properties/{id}', [AdminsController::class, 'deleteProperty'])->name('property.delete');
        Route::delete('gallery/{id}', [AdminsController::class, 'deleteGalleryImage'])->name('gallery.delete');

        Route::get('hometypes', [AdminsController::class, 'showHomeTypes'])->name('admin.hometypes');
        Route::get('hometypes/trashed', [AdminsController::class, 'showTrashedHomeTypes'])->name('admin.hometypes.trashed');
        Route::post('hometypes', [AdminsController::class, 'storeHomeType'])->name('hometype.store');
        Route::get('hometypes/{id}/edit', [AdminsController::class, 'editHomeType'])->name('hometype.edit');
        Route::post('hometypes/{id}', [AdminsController::class, 'updateHomeType'])->name('hometype.update');
        Route::delete('hometypes/{id}', [AdminsController::class, 'deleteHomeType'])->name('hometype.delete');
        Route::post('hometypes/{id}/restore', [AdminsController::class, 'restoreHomeType'])->name('hometype.restore');
        Route::delete('hometypes/{id}/force', [AdminsController::class, 'forceDeleteHomeType'])->name('hometype.force-delete');

        Route::get('admin_logs', [AdminsController::class, 'showAdminLogs'])->name('admin.logs');
        Route::get('prop_logs', [AdminsController::class, 'showPropLogs'])->name('prop.logs');
        Route::get('user_logs', [UserController::class, 'showUser'])->name('user.logs');
        Route::get('requests', [AdminsController::class, 'showRequests'])->name('admin.requests');
        Route::post('requests/{id}/status', [AdminsController::class, 'updateRequestStatus'])->name('admin.request.update-status');
    });
});

Route::middleware('auth')->group(function () {
    Route::post('/prop-details/{id}', [PropertiesController::class, 'insertRequests'])->name('insert.request');
    Route::post('save-props/{id}', [PropertiesController::class, 'saveProps'])->name('save.prop');
    Route::get('/my-requests', [PropertiesController::class, 'showRequests'])->name('user.requests');
    Route::delete('/my-requests/{id}', [PropertiesController::class, 'cancelRequest'])->name('cancel.request');
    Route::get('/my-saved-properties', [PropertiesController::class, 'showSavedProps'])->name('user.saved.properties');
    Route::delete('/my-saved-properties/{id}', [PropertiesController::class, 'removeSavedProp'])->name('remove.saved.prop');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\EmployeeController;
use App\Http\Controllers\admin\DepartmentController;
use App\Http\Controllers\admin\DesignationController;
use App\Http\Controllers\admin\HolidayController;

Route::get('/', [AdminAuthController::class, 'login'])->name('login');
Route::post('/login-confirm', [AdminAuthController::class, 'loginConfirm'])->name('login.confirm');

Route::middleware(['admin.auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('employees', EmployeeController::class);
    Route::post('/employee-ban-unban/{id}', [EmployeeController::class, 'banUnbanUSer'])->name('admin.user.ban.unban');
    Route::resource('departments', DepartmentController::class);
    Route::post('/department-status-update/{id}', [DepartmentController::class, 'StatusUpdate'])->name('admin.department.StatusUpdate');
    Route::resource('designations', DesignationController::class);
    Route::post('/designation-status-update/{id}', [DesignationController::class, 'StatusUpdate'])->name('admin.designation.StatusUpdate');
    Route::resource('holidays', HolidayController::class);
    Route::resource('holidays', HolidayController::class);
    Route::post('/holiday-status-update/{id}', [HolidayController::class, 'StatusUpdate'])->name('admin.holiday.StatusUpdate');

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

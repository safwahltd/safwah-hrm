<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\EmployeeController;
use App\Http\Controllers\admin\DepartmentController;
use App\Http\Controllers\admin\DesignationController;
use App\Http\Controllers\admin\HolidayController;
use App\Http\Controllers\admin\AssetController;
use App\Http\Controllers\employee\EmployeeDashboardController;
use App\Http\Controllers\employee\EmployeeAccountController;
use App\Http\Controllers\employee\AttendanceController;


Route::get('/', [AdminAuthController::class, 'login'])->name('login');
Route::post('/login-confirm', [AdminAuthController::class, 'loginConfirm'])->name('login.confirm');

Route::middleware(['employee.auth'])->prefix('employee/')->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'dashboard'])->name('employee.dashboard');
    Route::get('/employee-profile', [EmployeeAccountController::class,'profile'])->name('employee.profile.details');
    Route::post('/general-info-update', [EmployeeAccountController::class,'generalInfoUpdate'])->name('employee.general.info.update');
    Route::post('/bank-info-update', [EmployeeAccountController::class,'bankInfoUpdate'])->name('employee.bank.info.update');
    Route::post('/profile-picture-update', [EmployeeAccountController::class,'profilePictureUpdate'])->name('employee.profile.picture.update');
    Route::post('/personal-info-update', [EmployeeAccountController::class,'personalInfoUpdate'])->name('employee.personal.info.update');
    Route::get('/employee-clock-status', [AttendanceController::class,'getClockStatus'])->name('employee.clock.status');
    Route::post('/employee-clock-in', [AttendanceController::class,'clockIn'])->name('employee.clock.in');
    Route::post('/employee-clock-out', [AttendanceController::class,'clockOut'])->name('employee.clock.out');
    Route::get('/employee-attendance-list', [AttendanceController::class,'attendanceList'])->name('employee.attendance.list');
    Route::get('/employee-attendance-report', [AttendanceController::class,'attendanceReport'])->name('employee.attendance.report');
    Route::get('/employee-attendance-report-event', [AttendanceController::class,'getEvents'])->name('employee.attendance.report.event');
    Route::get('/employee-holiday', [HolidayController::class,'employeeIndex'])->name('employee.holiday.index');
});

Route::middleware(['admin.auth'])->prefix('admin/')->group(function () {
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
    Route::resource('assets', AssetController::class);
    Route::get('/assets-search-employee', [AssetController::class,'employeeFilter'])->name('employee.filter.asset');
    Route::get('/employee-profile/{id}', [EmployeeController::class,'employeeProfile'])->name('employee.profile');
    Route::get('/attendance-list', [AttendanceController::class,'adminAttendanceList'])->name('admin.attendance.list');
    Route::get('/attendance-report', [AttendanceController::class,'adminAttendanceReport'])->name('admin.attendance.report');
});
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

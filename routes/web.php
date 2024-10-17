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
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\admin\TerminationController;
use App\Http\Controllers\admin\RolePermissionController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\admin\NoticeController;
use App\Http\Controllers\admin\SalaryController;
use App\Http\Controllers\admin\SalaryPaymentController;


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
    Route::controller(LeaveController::class)->group(function (){
        Route::get('/leave', 'employeeLeaveIndex')->name('employee.leave');
        Route::post('/leave-request', 'employeeLeaveRequest')->name('employee.leave.request');
        Route::put('/leave-request-update/{id}', 'employeeLeaveRequestUpdate')->name('employee.leave.request.update');
        Route::post('/leave-request-cancel/{id}', 'employeeLeaveRequestCancel')->name('employee.leave.request.cancel');
        Route::get('/leave-request-print/{id}', 'employeeLeaveRequestPrint')->name('employee.leave.request.print');
    });
    Route::controller(NoticeController::class)->group(function (){
        Route::get('/notices-show','employeeShowList')->name('employee.notice.list');
    });
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
    Route::resource('asset', AssetController::class);
    Route::get('/assets-search-employee', [AssetController::class,'employeeFilter'])->name('employee.filter.asset');
    Route::get('/employee-profile/{id}', [EmployeeController::class,'employeeProfile'])->name('employee.profile');
    Route::get('/attendance-list', [AttendanceController::class,'adminAttendanceList'])->name('admin.attendance.list');
    Route::get('/attendance-report', [AttendanceController::class,'adminAttendanceReport'])->name('admin.attendance.report');
    Route::get('/export-attendance', [AttendanceController::class, 'exportAttendance'])->name('admin.attendance.report.export');
    Route::controller(LeaveController::class)->group(function (){
        Route::get('/leave-requests', 'adminIndex')->name('admin.leave.requests');
        Route::post('/leave-request-status-update/{id}', 'AdminRequestUpdate')->name('admin.leave.update');
        Route::get('/leave-report', 'AdminReport')->name('admin.leave.report');
        Route::get('/leave-request-print/{id}', 'employeeLeaveRequestPrint')->name('admin.leave.request.print');
        Route::get('/leave-type', 'leaveTypeIndex')->name('admin.leave.type');
    });
    Route::controller(TerminationController::class)->group(function (){
        Route::get('/termination', 'index')->name('admin.termination.index');
        Route::post('/termination-store', 'store')->name('admin.termination.store');
        Route::put('/termination-update/{id}', 'update')->name('admin.termination.update');
        Route::delete('/termination-destroy/{id}', 'destroy')->name('admin.termination.destroy');
        Route::post('/termination-download/{id}', 'download')->name('admin.termination.download');
    });
    Route::controller(RolePermissionController::class)->group(function (){
        /* role */
        Route::get('/role','roleIndex')->name('admin.role.index');
        Route::post('/role-store','roleStore')->name('admin.role.store');
        Route::put('/role-update/{id}','roleUpdate')->name('admin.role.update');
        Route::delete('/role-destroy/{id}','roleDestroy')->name('admin.role.destroy');
        /* Permission */
        Route::get('/permission','permissionIndex')->name('admin.permission.index');
        Route::post('/permission-store','permissionStore')->name('admin.permission.store');
        Route::put('/permission-update/{id}','permissionUpdate')->name('admin.permission.update');
        Route::delete('/permission-destroy/{id}','permissionDestroy')->name('admin.permission.destroy');
        Route::get('/user-role','userRoleIndex')->name('admin.user.role');
        Route::put('/user-role-update/{id}','userRoleUpdate')->name('admin.user.role.update');
    });
    Route::controller(ChatController::class)->group(function (){
        Route::get('/chat','index')->name('admin.chat.index');
    });
    Route::controller(SettingController::class)->group(function (){
        Route::get('/settings','index')->name('admin.settings.index');
        Route::put('/company-setting-update/{id}','companySettingUpdate')->name('admin.company.setting.update');
        /*Route::get('/email-setting','emailSetting')->name('admin.email.setting.index');
        Route::put('/email-setting-update/{id}','emailSettingUpdate')->name('admin.email.setting.update');*/
    });
    Route::controller(NoticeController::class)->group(function (){
        Route::get('/notices','index')->name('admin.notice.index');
        Route::post('/notices-store','store')->name('admin.notice.store');
        Route::put('/notices-update/{id}','update')->name('admin.notice.update');
        Route::delete('/notices-destroy/{id}','destroy')->name('admin.notice.destroy');
        Route::post('/notices-download/{id}', 'download')->name('admin.notice.download');
    });
    Route::controller(SalaryController::class)->group(function (){
        Route::get('/salaries','index')->name('admin.salary.index');
        Route::post('/salaries-store','store')->name('admin.salary.store');
        Route::put('/salaries-update/{id}','update')->name('admin.salary.update');
        Route::delete('/salaries-destroy/{id}','destroy')->name('admin.salary.destroy');
        Route::get('/salaries-download/{id}', 'download')->name('admin.salary.download');
        Route::get('/get-salary-details/{id}', [SalaryController::class, 'getSalaryDetails'])->name('salary.getDetails');
//        Route::get('/salaries-payment-download/{id}', 'download')->name('admin.salary.payment.download');
        Route::get('/salaries/get-employees', [SalaryController::class, 'getEmployees'])->name('salaries.getEmployees');
    });
    Route::controller(SalaryPaymentController::class)->group(function (){
        Route::get('/salaries-payment','index')->name('admin.salary.payment.index');
        Route::post('/salaries-payment-store','store')->name('admin.salary.payment.store');
        Route::put('/salaries-payment-update/{id}','update')->name('admin.salary.payment.update');
        Route::delete('/salaries-payment-destroy/{id}','destroy')->name('admin.salary.payment.destroy');
    });


});
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

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
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\SalarySettingController;
use App\Http\Controllers\admin\PolicyController;
use App\Http\Controllers\admin\FormController;
use App\Http\Controllers\admin\ExpenseController;


Route::get('/', [AdminAuthController::class, 'login'])->name('login');
Route::post('/login-confirm', [AdminAuthController::class, 'loginConfirm'])->name('login.confirm');

Route::middleware(['employee.auth'])->prefix('employee/')->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'dashboard'])->name('employee.dashboard');

});
//if (auth()->check()){
    Route::middleware(['admin.auth'])->group(function () {
        ################################/*   Admin Panel Start  */########################################
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/attendance-filter', [DashboardController::class, 'AttendanceFilter'])->name('admin.dashboard.attendance.filter');

        Route::prefix('admin')->group(function (){
            Route::resource('employees', EmployeeController::class);
            Route::post('/employee-ban-unban/{id}', [EmployeeController::class, 'banUnbanUSer'])->name('admin.user.ban.unban');
            Route::resource('departments', DepartmentController::class);
            Route::put('/department-soft-delete/{id}', [DepartmentController::class, 'destroy'])->name('admin.department.soft.delete');
            Route::post('/department-status-update/{id}', [DepartmentController::class, 'StatusUpdate'])->name('admin.department.StatusUpdate');
            Route::resource('designations', DesignationController::class);
            Route::put('/designation-soft-delete/{id}', [DesignationController::class,'destroy'])->name('designations.soft.destroy');
            Route::post('/designation-status-update/{id}', [DesignationController::class, 'StatusUpdate'])->name('admin.designation.StatusUpdate');
            Route::resource('holidays', HolidayController::class);
            Route::post('/holiday-status-update/{id}', [HolidayController::class, 'StatusUpdate'])->name('admin.holiday.StatusUpdate');
            Route::resource('asset', AssetController::class);
            Route::get('/assets-search-employee', [AssetController::class,'employeeFilter'])->name('employee.filter.asset');
            Route::get('/employee-profile/{id}', [EmployeeController::class,'employeeProfile'])->name('employee.profile');
            Route::get('/attendance-list', [AttendanceController::class,'adminAttendanceList'])->name('admin.attendance.list');
//            Route::get('/attendance-report', [AttendanceController::class,'adminAttendanceReport'])->name('admin.attendance.report');
//            Route::get('/export-attendance', [AttendanceController::class, 'exportAttendance'])->name('admin.attendance.report.export');
            Route::get('/employee-attendance-details', [AttendanceController::class,'details'])->name('admin.attendance.details');
            Route::get('/employee-attendance', [AttendanceController::class,'attendanceMonthly'])->name('admin.attendance.month.details');
            Route::get('/employee-attendance-details-download', [AttendanceController::class,'attendanceMonthlyDownload'])->name('admin.attendance.details.download');
            Route::controller(LeaveController::class)->group(function (){
                Route::get('/leave-requests', 'adminIndex')->name('admin.leave.requests');
                Route::post('/leave-request-status-update/{id}', 'AdminRequestUpdate')->name('admin.leave.update');
                Route::get('/leave-request-print/{id}', 'employeeLeaveRequestPrint')->name('admin.leave.request.print');
                Route::get('/leave-type', 'leaveTypeIndex')->name('admin.leave.type');
                Route::get('/leave-management', 'management')->name('admin.leave.management');
                Route::post('/leave-full-day-store', 'fullDay')->name('admin.full.leave.store');
                Route::put('/leave-full-day-update/{id}', 'fullDayUpdate')->name('admin.full.leave.update');
                Route::put('/leave-full-day-delete/{id}', 'fullDaySoftDelete')->name('admin.full.leave.delete');
                Route::post('/leave-half-day-store', 'halfDay')->name('admin.half.leave.store');
                Route::put('/leave-half-day-update/{id}', 'halfDayUpdate')->name('admin.half.leave.update');
                Route::put('/leave-half-day-delete/{id}', 'halfDaySoftDelete')->name('admin.half.leave.delete');
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
            Route::controller(AttendanceController::class)->group(function (){
                Route::get('/attendances','index')->name('admin.attendance.index');
                Route::post('/attendances-store','store')->name('admin.attendance.store');
                Route::put('/attendances-update/{id}','update')->name('admin.attendance.update');
                Route::delete('/attendances-destroy/{id}','destroy')->name('admin.attendance.destroy');
                Route::post('/attendances-download/{id}', 'download')->name('admin.attendance.download');
                Route::get('attendance/{attendance}/file', 'showFile')->name('admin.attendance.showFile');
            });
            Route::controller(NoticeController::class)->prefix('hr')->group(function (){
                Route::get('/notices','index')->name('admin.notice.index');
                Route::post('/notices-store','store')->name('admin.notice.store');
                Route::put('/notices-update/{id}','update')->name('admin.notice.update');
                Route::delete('/notices-destroy/{id}','destroy')->name('admin.notice.destroy');
                Route::post('/notices-download/{id}', 'download')->name('admin.notice.download');
            });
            Route::controller(SalarySettingController::class)->group(function (){
                Route::get('/salary-setting','index')->name('admin.salary.setting.index');
                Route::post('/salary-setting-store','store')->name('admin.salary.setting.store');
                Route::put('/salary-setting-update/{id}','update')->name('admin.salary.setting.update');
                Route::put('/salary-setting-destroy/{id}','destroy')->name('admin.salary.setting.destroy');
            });
            Route::controller(SalaryController::class)->prefix('account')->group(function (){
                Route::get('/salaries','index')->name('admin.salary.index');
                Route::post('/salaries-store','store')->name('admin.salary.store');
                Route::put('/salaries-update/{id}','update')->name('admin.salary.update');
                Route::put('/salaries-destroy/{id}','destroy')->name('admin.salary.destroy');
                Route::get('/salaries-download/{id}', 'download')->name('admin.salary.download');
                Route::get('/get-salary-details/{id}', [SalaryController::class, 'getSalaryDetails'])->name('salary.getDetails');
                Route::get('/salaries-payment-download/{id}', 'download')->name('admin.salary.payment.download');
                Route::get('/salaries/get-employees', [SalaryController::class, 'getEmployees'])->name('salaries.getEmployees');
            });
            Route::controller(SalaryPaymentController::class)->prefix('account')->group(function (){
                Route::get('/salaries-payment','index')->name('admin.salary.payment.index');
                Route::post('/salaries-payment-store','store')->name('admin.salary.payment.store');
                Route::put('/salaries-payment-update/{id}','update')->name('admin.salary.payment.update');
                Route::put('/salaries-payment-destroy/{id}','destroy')->name('admin.salary.payment.destroy');
            });
            /*Route::controller(BillingController::class)->group(function (){
                Route::get('/billings','index')->name('admin.billings.index');
                Route::post('/billings-store','store')->name('admin.billings.store');
                Route::put('/billings-update/{id}','update')->name('admin.billings.update');
                Route::delete('/billings-destroy/{id}','destroy')->name('admin.billings.destroy');
            });*/
            Route::controller(ReportController::class)->prefix('report')->group(function (){
                Route::get('/daily-report','daily')->name('admin.daily.report');
                Route::get('/daily-report-show','dailyReport')->name('admin.daily.report.show');
                Route::get('/daily-report-download','dailyReportDownload')->name('admin.download.daily.report');
                Route::get('/leave', 'leave')->name('admin.leave.report');
                Route::get('/leave-report-show', 'leaveReportShow')->name('admin.leave.report.show');
                Route::get('/download-leave-report', 'leaveReportDownload')->name('admin.download.leave.report');
                Route::get('/salary-report', 'salary')->name('admin.salary.report');
                Route::get('/salary-report-show', 'salaryReportShow')->name('admin.salary.report.show');
                Route::get('/download-salary-report', 'salaryReportDownload')->name('admin.download.salary.report');
                Route::get('/asset-report', 'asset')->name('admin.asset.report');
                Route::get('/asset-report-show', 'assetReportShow')->name('admin.asset.report.show');
                Route::get('/download-asset-report', 'assetReportDownload')->name('admin.download.asset.report');
                Route::get('/attendance-report', 'attendance')->name('admin.attendance.report');
                Route::get('/attendance-report-show', 'attendanceReportShow')->name('admin.attendance.report.show');
                Route::get('/download-attendance-report', 'attendanceReportDownload')->name('admin.download.attendance.report');
                Route::get('/expense-report', 'expense')->name('admin.expense.report');
                Route::get('/expense-report-show', 'expenseReportShow')->name('admin.expense.report.show');
                Route::get('/download-expense-report', 'expenseReportDownload')->name('admin.download.expense.report');
            });
            Route::get('/update-email-password', [AdminAuthController::class, 'password'])->name('admin.password.index');
            Route::post('/update-password-confirm', [AdminAuthController::class, 'updatePassword'])->name('admin.password.update');
            Route::post('/update-email-confirm', [AdminAuthController::class, 'updateEmail'])->name('admin.email.update');
            Route::get('/update-user-email-password', [AdminAuthController::class, 'userPassword'])->name('admin.user.password.index');
            Route::post('/update-user-password-confirm', [AdminAuthController::class, 'updateUserPassword'])->name('admin.user.password.update');
            Route::post('/update-user-email-confirm', [AdminAuthController::class, 'updateUserEmail'])->name('admin.user.email.update');
            Route::controller(PolicyController::class)->group(function (){
                Route::get('/policies','index')->name('admin.policy.index');
                Route::post('/policy-store','store')->name('admin.policy.store');
                Route::put('/policy-update/{id}','update')->name('admin.policy.update');
                Route::delete('/policy-destroy/{id}','destroy')->name('admin.policy.destroy');
                Route::get('policies/{policy}/file', 'showFile')->name('admin.policy.showFile');
            });
            Route::controller(FormController::class)->group(function (){
                Route::get('/form','index')->name('admin.form.index');
                Route::post('/form-store','store')->name('admin.form.store');
                Route::put('/form-update/{id}','update')->name('admin.form.update');
                Route::delete('/form-destroy/{id}','destroy')->name('admin.form.destroy');
                Route::get('forms/{form}/file', 'showFile')->name('admin.form.showFile');
            });

        });
        Route::controller(ExpenseController::class)->group(function (){
            Route::get('/expense','index')->name('admin.expense.index');
            Route::get('/expense-create','create')->name('admin.expense.create');
            Route::post('/expense-store','store')->name('admin.expense.store');
            Route::get('/expense-edit/{id}','edit')->name('admin.expense.edit');
            Route::put('/expense-update/{id}','update')->name('admin.expense.update');
            Route::put('/expense-destroy/{id}','destroy')->name('admin.expense.destroy');
            Route::get('expense-download/{id}', 'printExpense')->name('admin.expense.download');
        });

        ####################################### /* Admin Panel End Here  */###################################################################
        ####################################### /* Employee Panel Start Here  */###################################################################
//        Route::prefix('employee')->group(function (){
            Route::get('/profile', [EmployeeAccountController::class,'profile'])->name('employee.profile.details');
            Route::post('/general-info-update', [EmployeeAccountController::class,'generalInfoUpdate'])->name('employee.general.info.update');
            Route::post('/bank-info-update', [EmployeeAccountController::class,'bankInfoUpdate'])->name('employee.bank.info.update');
            Route::post('/profile-picture-update', [EmployeeAccountController::class,'profilePictureUpdate'])->name('employee.profile.picture.update');
            Route::post('/personal-info-update', [EmployeeAccountController::class,'personalInfoUpdate'])->name('employee.personal.info.update');
            /*Route::get('/employee-clock-status', [AttendanceController::class,'getClockStatus'])->name('employee.clock.status');
            Route::post('/employee-clock-in', [AttendanceController::class,'clockIn'])->name('employee.clock.in');
            Route::post('/employee-clock-out', [AttendanceController::class,'clockOut'])->name('employee.clock.out');*/
            Route::get('/attendance-list', [AttendanceController::class,'attendanceList'])->name('employee.attendance.list');
//            Route::get('/attendance-calendar', [AttendanceController::class,'attendanceReport'])->name('employee.attendance.report');
//            Route::get('/attendance-report-event', [AttendanceController::class,'getEvents'])->name('employee.attendance.report.event');
            Route::get('/holiday', [HolidayController::class,'employeeIndex'])->name('employee.holiday.index');
            Route::controller(LeaveController::class)->group(function (){
                Route::get('/leave', 'employeeLeaveIndex')->name('employee.leave');
                Route::post('/leave-request', 'employeeLeaveRequest')->name('employee.leave.request');
                Route::put('/leave-request-update/{id}', 'employeeLeaveRequestUpdate')->name('employee.leave.request.update');
                Route::post('/leave-request-cancel/{id}', 'employeeLeaveRequestCancel')->name('employee.leave.request.cancel');
                Route::get('/leave-request-print/{id}', 'employeeLeaveRequestPrint')->name('employee.leave.request.print');
            });
            Route::controller(NoticeController::class)->group(function (){
                Route::get('/notifications-show','employeeShowList')->name('employee.notice.list');
            });
            Route::get('/salary', [SalaryController::class, 'employeeIndex'])->name('employee.salary.index');
            Route::controller(ExpenseController::class)->group(function (){
                Route::get('/advance-money','indexAdvance')->name('employee.advance.money.index');
                Route::post('/advance-money-store','storeAdvance')->name('employee.advance.money.store');
                Route::put('/advance-money-update/{id}','updateAdvance')->name('employee.advance.money.update');
                Route::put('/advance-money-destroy/{id}','destroyAdvance')->name('employee.advance.money.destroy');
            });
//        });
        ####################################### /* Employee Panel End Here  */###################################################################
    });
    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.read');

    Route::post('/notifications/mark-as-read/{id}', function ($id) {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return redirect()->route('employee.notice.list');
    })->name('notifications.markAsRead');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

//}

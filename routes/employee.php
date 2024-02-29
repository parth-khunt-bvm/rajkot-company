<?php

use App\Http\Controllers\backend\employee\EmpAttendanceController;
use App\Http\Controllers\backend\employee\EmpAttendanceReportController;
use App\Http\Controllers\backend\employee\EmpOvertimeController;
use App\Http\Controllers\backend\employee\LeaveRequestController;
use App\Http\Controllers\backend\EmployeeDashboardController;
use App\Http\Controllers\backend\EmployeeLoginController;
use Illuminate\Support\Facades\Route;

Route::get('employee-logout', [EmployeeLoginController::class, 'employeeLogout'])->name('employee-logout');

Route::group(['prefix' => 'employee'], function () {
    Route::resource('my-dashboard', EmployeeDashboardController::class);
    Route::get('edit-profile', [EmployeeDashboardController::class, 'editProfile'])->name('employee.edit-profile');
    Route::post('save-profile', [EmployeeDashboardController::class, 'saveProfile'])->name('employee.save-profile');
    Route::get('change-password', [EmployeeDashboardController::class, 'change_password'])->name('employee.change-password');
    Route::post('save-password', [EmployeeDashboardController::class, 'save_password'])->name('employee.save-password');

    Route::resource('leave-request', LeaveRequestController::class);
    Route::post('admin/leave-request/ajaxcall', [LeaveRequestController::class, 'ajaxcall'])->name('admin.leave-request.ajaxcall');

    Route::get('emp-overtime/list', [EmpOvertimeController::class, 'list'])->name('emp-overtime.list');
    Route::post('emp-overtime/ajaxcall', [EmpOvertimeController::class, 'ajaxcall'])->name('emp-overtime.ajaxcall');

    Route::resource('emp-attendances', EmpAttendanceController::class);
    Route::post('emp-attendances/ajaxcall', [EmpAttendanceController::class, 'ajaxcall'])->name('emp-attendances.ajaxcall');

    Route::resource('emp-attendance-reports', EmpAttendanceReportController::class);
    Route::post('emp-attendance-reports/ajaxcall', [EmpAttendanceReportController::class, 'ajaxcall'])->name('emp-attendances.ajaxcall');

});

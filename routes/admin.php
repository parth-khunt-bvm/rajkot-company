<?php

use App\Http\Controllers\backend\AttendanceController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\LoginController;
use App\Http\Controllers\backend\AuditTrailsController;
use App\Http\Controllers\backend\BranchController;
use App\Http\Controllers\backend\EmployeeController;
use App\Http\Controllers\backend\ManagerController;
use App\Http\Controllers\backend\TechnologyController;
use App\Http\Controllers\backend\SalaryController;
use App\Http\Controllers\backend\TypeController;
use App\Http\Controllers\backend\ExpenseController;
use App\Http\Controllers\backend\RevenueController;
use App\Http\Controllers\backend\CounterController;
use App\Http\Controllers\backend\DesignationController;
use App\Http\Controllers\backend\HrExpenseController;
use App\Http\Controllers\backend\HrIncomeController;

Route::get('admin-logout', [LoginController::class, 'adminLogout'])->name('admin-logout');

$adminPrefix = "";
Route::group(['prefix' => $adminPrefix, 'middleware' => ['admin']], function() {
    Route::get('my-dashboard', [DashboardController::class, 'myDashboard'])->name('my-dashboard');
    Route::get('edit-profile', [DashboardController::class, 'editProfile'])->name('edit-profile');
    Route::post('save-profile', [DashboardController::class, 'saveProfile'])->name('save-profile');
    Route::get('change-password', [DashboardController::class, 'change_password'])->name('change-password');
    Route::post('save-password', [DashboardController::class, 'save_password'])->name('save-password');
    Route::post('admin/dashboard/ajaxcall', [DashboardController::class, 'ajaxcall'])->name('admin.dashboard.ajaxcall');

    $adminPrefix = "audittrails";
    Route::group(['prefix' => $adminPrefix, 'middleware' => ['admin']], function() {
        Route::get('audit-trails', [AuditTrailsController::class, 'list'])->name('audit-trails');
        Route::post('audit-trails-ajaxcall', [AuditTrailsController::class, 'ajaxcall'])->name('audit-trails-ajaxcall');
    });
    //  branch

    Route::get('admin/branch/list', [BranchController::class, 'list'])->name('admin.branch.list');

    Route::get('admin/branch/add', [BranchController::class, 'add'])->name('admin.branch.add');
    Route::post('admin/branch/save-add-branch', [BranchController::class, 'saveAdd'])->name('admin.branch.save-add-branch');

    Route::get('admin/branch/edit/{id}', [BranchController::class, 'edit'])->name('admin.branch.edit');
    Route::post('admin/branch/save-edit-branch', [BranchController::class, 'saveEdit'])->name('admin.branch.save-edit-branch');

    Route::post('admin/branch/ajaxcall', [BranchController::class, 'ajaxcall'])->name('admin.branch.ajaxcall');

    Route::post('admin/branch/save-import-branch', [BranchController::class, 'save_import'])->name('admin.branch.save-import-branch');
    //  manager

    Route::get('admin/manager/list', [ManagerController::class, 'list'])->name('admin.manager.list');

    Route::get('admin/manager/add', [ManagerController::class, 'add'])->name('admin.manager.add');
    Route::post('admin/manager/save-add-manager', [ManagerController::class, 'saveAdd'])->name('admin.manager.save-add-manager');

    Route::get('admin/manager/edit/{id}', [ManagerController::class, 'edit'])->name('admin.manager.edit');
    Route::post('admin/manager/save-edit-manager', [ManagerController::class, 'saveEdit'])->name('admin.manager.save-edit-manager');

    Route::post('admin/manager/ajaxcall', [ManagerController::class, 'ajaxcall'])->name('admin.manager.ajaxcall');

    Route::post('admin/manager/save-import-manager', [ManagerController::class, 'save_import'])->name('admin.manager.save-import-manager');

   //  technology

    Route::get('admin/technology/list', [TechnologyController::class, 'list'])->name('admin.technology.list');
    Route::get('admin/technology/add', [TechnologyController::class, 'add'])->name('admin.technology.add');
    Route::post('admin/technology/save-add-technology', [TechnologyController::class, 'saveAdd'])->name('admin.technology.save-add-technology');
    Route::get('admin/technology/edit/{id}', [TechnologyController::class, 'edit'])->name('admin.technology.edit');
    Route::post('admin/technology/save-edit-technology', [TechnologyController::class, 'saveEdit'])->name('admin.technology.save-edit-technology');
    Route::post('admin/technology/ajaxcall', [TechnologyController::class, 'ajaxcall'])->name('admin.technology.ajaxcall');
    Route::post('admin/technology/save-import-technology', [TechnologyController::class, 'save_import'])->name('admin.technology.save-import-technology');

    // salary

    Route::get('admin/salary/list', [SalaryController::class, 'list'])->name('admin.salary.list');
    Route::get('admin/salary/add', [SalaryController::class, 'add'])->name('admin.salary.add');
    Route::post('admin/salary/save-add-salary', [SalaryController::class, 'saveAdd'])->name('admin.salary.save-add-salary');
    Route::get('admin/salary/edit/{id}', [SalaryController::class, 'edit'])->name('admin.salary.edit');
    Route::post('admin/salary/save-edit-salary', [SalaryController::class, 'saveEdit'])->name('admin.salary.save-edit-salary');
    Route::post('admin/salary/ajaxcall', [SalaryController::class, 'ajaxcall'])->name('admin.salary.ajaxcall');
    Route::get('admin/salary/view/{id}', [SalaryController::class, 'view'])->name('admin.salary.view');
    Route::post('admin/salary/save-import-salary', [SalaryController::class, 'save_import'])->name('admin.salary.save-import-salary');


     //  Type
     Route::get('admin/type/list', [TypeController::class, 'list'])->name('admin.type.list');
     Route::get('admin/type/add', [TypeController::class, 'add'])->name('admin.type.add');
     Route::post('admin/type/save-add-type', [TypeController::class, 'saveAdd'])->name('admin.type.save-add-type');
     Route::get('admin/type/edit/{id}', [TypeController::class, 'edit'])->name('admin.type.edit');
     Route::post('admin/type/save-edit-type', [TypeController::class, 'saveEdit'])->name('admin.type.save-edit-type');
     Route::post('admin/type/ajaxcall', [TypeController::class, 'ajaxcall'])->name('admin.type.ajaxcall');
     Route::post('admin/type/save-import-type', [TypeController::class, 'save_import'])->name('admin.type.save-import-type');

    // expense

    Route::get('admin/expense/list', [ExpenseController::class, 'list'])->name('admin.expense.list');
    Route::get('admin/expense/add', [ExpenseController::class, 'add'])->name('admin.expense.add');
    Route::post('admin/expense/save-add-expense', [ExpenseController::class, 'saveAdd'])->name('admin.expense.save-add-expense');
    Route::get('admin/expense/edit/{id}', [ExpenseController::class, 'edit'])->name('admin.expense.edit');
    Route::post('admin/expense/save-edit-expense', [ExpenseController::class, 'saveEdit'])->name('admin.expense.save-edit-expense');
    Route::post('admin/expense/ajaxcall', [ExpenseController::class, 'ajaxcall'])->name('admin.expense.ajaxcall');
    Route::get('admin/expense/view/{id}', [ExpenseController::class, 'view'])->name('admin.expense.view');
    Route::post('admin/expense/save-import-expense', [ExpenseController::class, 'save_import'])->name('admin.expense.save-import-expense');

    // Revenue
    Route::get('admin/revenue/list', [RevenueController::class, 'list'])->name('admin.revenue.list');
    Route::get('admin/revenue/add', [RevenueController::class, 'add'])->name('admin.revenue.add');
    Route::post('admin/revenue/save-add-revenue', [RevenueController::class, 'saveAdd'])->name('admin.revenue.save-add-revenue');
    Route::get('admin/revenue/edit/{id}', [RevenueController::class, 'edit'])->name('admin.revenue.edit');
    Route::post('admin/revenue/save-edit-revenue', [RevenueController::class, 'saveEdit'])->name('admin.revenue.save-edit-revenue');
    Route::post('admin/revenue/ajaxcall', [RevenueController::class, 'ajaxcall'])->name('admin.revenue.ajaxcall');
    Route::get('admin/revenue/view/{id}', [RevenueController::class, 'view'])->name('admin.revenue.view');
    Route::post('admin/revenue/save-import-revenue', [RevenueController::class, 'save_import'])->name('admin.revenue.save-import-revenue');

    //  Hr income
    Route::get('admin/hr/income/list', [HrIncomeController::class, 'list'])->name('admin.hr.income.list');
    Route::get('admin/hr/income/add', [HrIncomeController::class, 'add'])->name('admin.hr.income.add');
    Route::post('admin/hr/income/save-add-income', [HrIncomeController::class, 'saveAdd'])->name('admin.hr.income.save-add-income');
    Route::get('admin/hr/income/edit/{id}', [HrIncomeController::class, 'edit'])->name('admin.hr.income.edit');
    Route::post('admin/hr/income/save-edit-income', [HrIncomeController::class, 'saveEdit'])->name('admin.hr.income.save-edit-income');
    Route::post('admin/hr/income/ajaxcall', [HrIncomeController::class, 'ajaxcall'])->name('admin.hr.income.ajaxcall');
    Route::get('admin/hr/income/view/{id}', [HrIncomeController::class, 'view'])->name('admin.hr.income.view');
    Route::post('admin/hr/income/save-import-income', [HrIncomeController::class, 'save_import'])->name('admin.hr.income.save-import-income');


    //  Hr expense
    Route::get('admin/hr/expense/list', [HrExpenseController::class, 'list'])->name('admin.hr.expense.list');
    Route::get('admin/hr/expense/add', [HrExpenseController::class, 'add'])->name('admin.hr.expense.add');
    Route::post('admin/hr/expense/save-add-expense', [HrExpenseController::class, 'saveAdd'])->name('admin.hr.expense.save-add-expense');
    Route::get('admin/hr/expense/edit/{id}', [HrExpenseController::class, 'edit'])->name('admin.hr.expense.edit');
    Route::post('admin/hr/expense/save-edit-expense', [HrExpenseController::class, 'saveEdit'])->name('admin.hr.expense.save-edit-expense');
    Route::post('admin/hr/expense/ajaxcall', [HrExpenseController::class, 'ajaxcall'])->name('admin.hr.expense.ajaxcall');
    Route::get('admin/hr/expense/view/{id}', [HrExpenseController::class, 'view'])->name('admin.hr.expense.view');
    Route::post('admin/hr/expense/save-import-expense', [HrExpenseController::class, 'save_import'])->name('admin.hr.expense.save-import-expense');

    // Employee
    Route::get('admin/employee/list', [EmployeeController::class, 'list'])->name('admin.employee.list');
    Route::get('admin/employee/birthday/list', [EmployeeController::class, 'birthDayList'])->name('admin.employee.birthday.list');
    Route::get('admin/employee/bond/last/date/list', [EmployeeController::class, 'bondLastDateList'])->name('admin.employee.bond-last-daye.list');
    Route::get('admin/employee/add', [EmployeeController::class, 'add'])->name('admin.employee.add');
    Route::post('admin/employee/save-add-employee', [EmployeeController::class, 'saveAdd'])->name('admin.employee.save-add-employee');
    Route::get('admin/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('admin.employee.edit');
    Route::post('admin/employee/save-edit-employee', [EmployeeController::class, 'saveEdit'])->name('admin.employee.save-edit-employee');
    Route::post('admin/employee/ajaxcall', [EmployeeController::class, 'ajaxcall'])->name('admin.employee.ajaxcall');
    Route::get('admin/employee/view/{id}', [EmployeeController::class, 'view'])->name('admin.employee.view');
    Route::post('admin/employee/save-import-employee', [EmployeeController::class, 'save_import'])->name('admin.employee.save-import-employee');
    Route::get('admin/employee/attendance/list', [EmployeeController::class, 'attendancelist'])->name('admin.employee.attendance.list');


    // Counter
    Route::get('admin/counter/list', [CounterController::class, 'list'])->name('admin.counter.list');
    Route::get('admin/counter/add', [CounterController::class, 'add'])->name('admin.counter.add');
    Route::post('admin/counter/save-add-counter', [CounterController::class, 'saveAdd'])->name('admin.counter.save-add-counter');
    Route::get('admin/counter/edit/{id}', [CounterController::class, 'edit'])->name('admin.counter.edit');
    Route::post('admin/counter/save-edit-counter', [CounterController::class, 'saveEdit'])->name('admin.counter.save-edit-counter');
    Route::post('admin/counter/ajaxcall', [CounterController::class, 'ajaxcall'])->name('admin.counter.ajaxcall');
    Route::get('admin/counter/view/{id}', [CounterController::class, 'view'])->name('admin.counter.view');
    Route::post('admin/counter/save-import-counter', [CounterController::class, 'save_import'])->name('admin.counter.save-import-counter');

    // report
    Route::get('admin/report/expense', [ReportController::class, 'expense'])->name('admin.report.expense');
    Route::get('admin/report/revenue', [ReportController::class, 'revenue'])->name('admin.report.revenue');
    Route::get('admin/report/salary', [ReportController::class, 'salary'])->name('admin.report.salary');
    Route::get('admin/report/profit-loss', [ReportController::class, 'profitLoss'])->name('admin.report.profit-loss');
    Route::get('admin/report/profit-loss-by-time', [ReportController::class, 'profitLossByTime'])->name('admin.report.profit-loss-by-time');
    Route::post('admin/report/ajaxcall', [ReportController::class, 'ajaxcall'])->name('admin.report.ajaxcall');

    // designation
    Route::get('admin/designation/list', [DesignationController::class, 'list'])->name('admin.designation.list');
    Route::get('admin/designation/add', [DesignationController::class, 'add'])->name('admin.designation.add');
    Route::post('admin/designation/save-add-designation', [DesignationController::class, 'saveAdd'])->name('admin.designation.save-add-designation');
    Route::get('admin/designation/edit/{id}', [DesignationController::class, 'edit'])->name('admin.designation.edit');
    Route::post('admin/designation/save-edit-designation', [DesignationController::class, 'saveEdit'])->name('admin.designation.save-edit-designation');
    Route::post('admin/designation/ajaxcall', [DesignationController::class, 'ajaxcall'])->name('admin.designation.ajaxcall');
    Route::post('admin/designation/save-import-designation', [DesignationController::class, 'save_import'])->name('admin.designation.save-import-designation');

    // Attendance
    Route::get('admin/attendance/list', [AttendanceController::class, 'list'])->name('admin.attendance.list');
    Route::get('admin/attendance/report/list', [AttendanceController::class, 'reportList'])->name('admin.attendance.report.list');
    Route::get('admin/attendance/day/list', [AttendanceController::class, 'dayList'])->name('admin.attendance.day-list');
    Route::get('admin/attendance/day/edit/{id}', [AttendanceController::class, 'dayEdit'])->name('admin.attendance.day-edit');
    Route::post('admin/attendance/day/save-edit-attendance', [AttendanceController::class, 'daysaveEdit'])->name('admin.attendance.day-save-edit-attendance');
    Route::get('admin/attendance/add', [AttendanceController::class, 'add'])->name('admin.attendance.add');
    Route::post('admin/attendance/save-add-attendance', [AttendanceController::class, 'saveAdd'])->name('admin.attendance.save-add-attendance');
    Route::post('admin/attendance/ajaxcall', [AttendanceController::class, 'ajaxcall'])->name('admin.attendance.ajaxcall');
    Route::get('admin/attendance/view/{id}', [AttendanceController::class, 'view'])->name('admin.attendance.view');

});

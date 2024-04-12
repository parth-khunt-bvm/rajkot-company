<?php

use App\Http\Controllers\backend\AssetAllocationController;
use App\Http\Controllers\backend\AttendanceController;
use App\Http\Controllers\backend\ReportController;
use App\Http\Controllers\backend\SalarySlipController;
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
use App\Http\Controllers\backend\CountersheetController;
use App\Http\Controllers\backend\SystemsettingController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\AssetController;
use App\Http\Controllers\backend\SupplierController;
use App\Http\Controllers\backend\UserroleController;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\AssetMasterController;
use App\Http\Controllers\backend\AttendanceSettingController;
use App\Http\Controllers\backend\ChangeRequestController;
use App\Http\Controllers\backend\EmployeeAssetAllocationController;
use App\Http\Controllers\backend\EmployeeBirthdayController;
use App\Http\Controllers\backend\EmployeeBondLastDateController;
use App\Http\Controllers\backend\EmployeeSalarySlipController;
use App\Http\Controllers\backend\EmpOverTimeController;
use App\Http\Controllers\backend\LatterAbbreviationController;
use App\Http\Controllers\backend\LatterTemplateController;
use App\Http\Controllers\backend\LeaveRequestController;
use App\Http\Controllers\backend\PublicHolidayController;
use App\Http\Controllers\backend\SalaryIncrementController;

Route::get('admin-logout', [LoginController::class, 'adminLogout'])->name('admin-logout');

$adminPrefix = "";
Route::group(['prefix' => $adminPrefix, 'middleware' => ['admin']], function() {
    Route::get('my-dashboard', [DashboardController::class, 'myDashboard'])->name('my-dashboard');
    Route::get('edit-profile', [DashboardController::class, 'editProfile'])->name('edit-profile');
    Route::post('save-profile', [DashboardController::class, 'saveProfile'])->name('save-profile');
    Route::get('change-password', [DashboardController::class, 'change_password'])->name('change-password');
    Route::post('save-password', [DashboardController::class, 'save_password'])->name('save-password');
    Route::post('admin/dashboard/ajaxcall', [DashboardController::class, 'ajaxcall'])->name('admin.dashboard.ajaxcall');

    Route::get('admin-system-setting', [SystemsettingController::class, 'systemColorSetting'])->name('system-color-setting');
    Route::post('admin-system-setting/save-add', [SystemsettingController::class, 'saveAdd'])->name('system-color-setting.save-add');

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

    // salary Increment

    Route::get('admin/salary-increment/list', [SalaryIncrementController::class, 'list'])->name('admin.salary-increment.list');
    Route::get('admin/salary-increment/add', [SalaryIncrementController::class, 'add'])->name('admin.salary-increment.add');
    Route::post('admin/salary-increment/save-add-salary-increment', [SalaryIncrementController::class, 'saveAdd'])->name('admin.salary-increment.save-add-salary-increment');
    Route::post('admin/salary-increment/ajaxcall', [SalaryIncrementController::class, 'ajaxcall'])->name('admin.salary-increment.ajaxcall');
    Route::get('admin/salary-increment/edit/{id}', [SalaryIncrementController::class, 'edit'])->name('admin.salary-increment.edit');
    Route::post('admin/salary-increment/save-edit-salary-increment', [SalaryIncrementController::class, 'saveEdit'])->name('admin.salary-increment.save-edit-salary-increment');


    // salary slip
    Route::get('admin/employee-salaryslip/list', [SalarySlipController::class, 'list'])->name('admin.employee-salaryslip.list');
    Route::get('admin/employee-salaryslip/add', [SalarySlipController::class, 'add'])->name('admin.employee-salaryslip.add');
    Route::post('admin/employee-salaryslip/ajaxcall', [SalarySlipController::class, 'ajaxcall'])->name('admin.employee-salaryslip.ajaxcall');
    Route::post('admin/employee-salaryslip/save-add-employee-salaryslip', [SalarySlipController::class, 'saveAdd'])->name('admin.employee-salaryslip.save-add-employee-salaryslip');
    Route::get('admin/employee-salaryslip/edit/{id}', [SalarySlipController::class, 'edit'])->name('admin.employee-salaryslip.edit');
    Route::post('admin/employee-salaryslip/save-edit-employee-salaryslip', [SalarySlipController::class, 'saveEdit'])->name('admin.employee-salaryslip.save-edit-employee-salaryslip');
    Route::get('admin/employee-salaryslip/view/{id}', [SalarySlipController::class, 'view'])->name('admin.employee-salaryslip.view');
    Route::get('admin/employee-salaryslip/pdf/{id}', [SalarySlipController::class, 'salarySlipPdf'])->name('admin.employee-salaryslip.pdf');

    Route::post('admin/employee-salaryslip/create-employee-salaryslip', [SalarySlipController::class, 'salarySlipCreate'])->name('admin.employee-salaryslip.create-employee-salaryslip');


    Route::get('admin/all-employee-salaryslip/add', [SalarySlipController::class, 'salarySlipAdd'])->name('admin.all-employee-salaryslip.add');
    Route::post('admin/all-employee-salaryslip/save-add-all-employee-salaryslip', [SalarySlipController::class, 'salarySlipSaveAdd'])->name('admin.all-employee-salaryslip.save-add-all-employee-salaryslip');


    //  Type
    Route::get('admin/type/list', [TypeController::class, 'list'])->name('admin.type.list');
    Route::get('admin/type/add', [TypeController::class, 'add'])->name('admin.type.add');
    Route::post('admin/type/save-add-type', [TypeController::class, 'saveAdd'])->name('admin.type.save-add-type');
    Route::get('admin/type/edit/{id}', [TypeController::class, 'edit'])->name('admin.type.edit');
    Route::post('admin/type/save-edit-type', [TypeController::class, 'saveEdit'])->name('admin.type.save-edit-type');
    Route::post('admin/type/ajaxcall', [TypeController::class, 'ajaxcall'])->name('admin.type.ajaxcall');
    Route::post('admin/type/save-import-type', [TypeController::class, 'save_import'])->name('admin.type.save-import-type');

     // asset
    Route::get('admin/asset/list', [AssetController::class, 'list'])->name('admin.assets.list');
    Route::post('admin/assets/ajaxcall', [AssetController::class, 'ajaxcall'])->name('admin.assets.ajaxcall');
    Route::get('admin/assets/add', [AssetController::class, 'add'])->name('admin.assets.add');
    Route::post('admin/assets/save-add-technology', [AssetController::class, 'saveAdd'])->name('admin.assets.save-add-assets');

    //brand
    Route::get('admin/brand/list', [BrandController::class, 'list'])->name('admin.brand.list');
    Route::post('admin/brand/ajaxcall', [BrandController::class, 'ajaxcall'])->name('admin.brand.ajaxcall');
    Route::get('admin/brand/add', [BrandController::class, 'add'])->name('admin.brand.add');
    Route::post('admin/brand/save-add-brand', [BrandController::class, 'saveAdd'])->name('admin.brand.save-add-brand');
    Route::get('admin/brand/edit/{id}', [BrandController::class, 'edit'])->name('admin.brand.edit');
    Route::post('admin/brand/save-edit-expense', [BrandController::class,   'saveEdit'])->name('admin.brand.save-edit-brand');

    //asset master
    Route::get('admin/asset-master/list', [AssetMasterController::class, 'list'])->name('admin.assets-master.list');
    Route::post('admin/asset-master/ajaxcall', [AssetMasterController::class, 'ajaxcall'])->name('admin.asset-master.ajaxcall');
    Route::get('admin/asset-master/add', [AssetMasterController::class, 'add'])->name('admin.asset-master.add');
    Route::post('admin/asset-master/save-add-asset-master', [AssetMasterController::class, 'saveAdd'])->name('admin.asset-master.save-add-asset-master');
    Route::get('admin/asset-master/edit/{id}', [AssetMasterController::class, 'edit'])->name('admin.asset-master.edit');
    Route::post('admin/asset-master/save-edit-asset-master', [AssetMasterController::class, 'saveEdit'])->name('admin.asset-master.save-edit-asset-master');
    Route::get('admin/asset-master/view/{id}', [AssetMasterController::class, 'view'])->name('admin.asset-master.view');

    //asset allocation
    Route::get('admin/asset-allocation/list', [AssetAllocationController::class, 'list'])->name('admin.asset-allocation.list');
    Route::get('admin/asset-allocation/add', [AssetAllocationController::class, 'add'])->name('admin.asset-allocation.add');
    Route::post('admin/asset-allocation/ajaxcall', [AssetAllocationController::class, 'ajaxcall'])->name('admin.asset-allocation.ajaxcall');
    Route::post('admin/asset-allocation/save-add-asset-allocation', [AssetAllocationController::class, 'saveAdd'])->name('admin.asset-allocation.save-add-asset-allocation');
    Route::get('admin/asset-allocation/edit/{id}', [AssetAllocationController::class, 'edit'])->name('admin.asset-allocation.edit');
    Route::post('admin/asset-allocation/save-edit-asset-allocation', [AssetAllocationController::class, 'saveEdit'])->name('admin.asset-allocation.save-edit-asset-allocation');

    // expense
    Route::get('admin/expense/list', [ExpenseController::class, 'list'])->name('admin.expense.list');
    Route::get('admin/expense/add', [ExpenseController::class, 'add'])->name('admin.expense.add');
    Route::post('admin/expense/save-add-expense', [ExpenseController::class, 'saveAdd'])->name('admin.expense.save-add-expense');
    Route::get('admin/expense/edit/{id}', [ExpenseController::class, 'edit'])->name('admin.expense.edit');
    Route::post('admin/expense/save-edit-expense', [ExpenseController::class,   'saveEdit'])->name('admin.expense.save-edit-expense');
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

    Route::get('admin/employee/birthday/list', [EmployeeBirthdayController::class, 'birthDayList'])->name('admin.employee.birthday.list');
    Route::post('admin/employee/birthday/ajaxcall', [EmployeeBirthdayController::class, 'ajaxcall'])->name('admin.employee.birthday.ajaxcall');

    Route::get('admin/employee/bond/last/date/list', [EmployeeBondLastDateController::class, 'bondLastDateList'])->name('admin.employee.bond-last-date.list');
    Route::post('admin/employee/bond/last/date/ajaxcall', [EmployeeBondLastDateController::class, 'ajaxcall'])->name('admin.employee.bond-last-date.ajaxcall');

    Route::get('admin/employee/asset-allocation/list', [EmployeeAssetAllocationController::class, 'assetAllocationList'])->name('admin.employee.asset-allocation.list');
    Route::post('admin/employee/asset-allocation/ajaxcall', [EmployeeAssetAllocationController::class, 'ajaxcall'])->name('admin.employee.asset-allocation.ajaxcall');

    // Route::get('admin/employee/salary-slip/list', [EmployeeSalarySlipController::class, 'salarySlipList'])->name('admin.employee.salary-slip.list');
    Route::post('admin/employee/salary-slip/ajaxcall', [EmployeeSalarySlipController::class, 'ajaxcall'])->name('admin.employee.salary-slip.ajaxcall');

    Route::get('admin/employee/add', [EmployeeController::class, 'add'])->name('admin.employee.add');
    Route::post('admin/employee/save-add-employee', [EmployeeController::class, 'saveAdd'])->name('admin.employee.save-add-employee');
    Route::get('admin/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('admin.employee.edit');
    Route::post('admin/employee/save-edit-employee', [EmployeeController::class, 'saveEdit'])->name('admin.employee.save-edit-employee');
    Route::post('admin/employee/ajaxcall', [EmployeeController::class, 'ajaxcall'])->name('admin.employee.ajaxcall');
    Route::get('admin/employee/view/{id}', [EmployeeController::class, 'view'])->name('admin.employee.view');
    Route::post('admin/employee/save-import-employee', [EmployeeController::class, 'save_import'])->name('admin.employee.save-import-employee');
    Route::get('admin/employee/attendance/list', [EmployeeController::class, 'attendancelist'])->name('admin.employee.attendance.list');
    Route::get('admin/employee/offer/letter/pdf/{id}', [EmployeeController::class, 'offerLetterPdf'])->name('admin.employee.offer-letter');
    Route::get('admin/employee/cover/letter/pdf/{id}', [EmployeeController::class, 'coverLetterPdf'])->name('admin.employee.cover-letter');


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

    //Public Holiday
    Route::get('admin/public-holiday/list', [PublicHolidayController::class, 'list'])->name('admin.public-holiday.list');
    Route::get('admin/public-holiday/add', [PublicHolidayController::class, 'add'])->name('admin.public-holiday.add');
    Route::post('admin/public-holiday/save-add-public-holiday', [PublicHolidayController::class, 'saveAdd'])->name('admin.public-holiday.save-add-public-holiday');
    Route::get('admin/public-holiday/edit/{id}', [PublicHolidayController::class, 'edit'])->name('admin.public-holiday.edit');
    Route::post('admin/public-holiday/save-edit-public-holiday', [PublicHolidayController::class, 'saveEdit'])->name('admin.public-holiday.save-edit-public-holiday');
    Route::post('admin/public-holiday/ajaxcall', [PublicHolidayController::class, 'ajaxcall'])->name('admin.public-holiday.ajaxcall');
    Route::post('admin/public-holiday/save-import-public-holiday', [PublicHolidayController::class, 'save_import'])->name('admin.public-holiday.save-import-public-holiday');

    // Attendance
    Route::get('admin/attendance/list', [AttendanceController::class, 'list'])->name('admin.attendance.list');
    Route::get('admin/attendance/day/list', [AttendanceController::class, 'dayList'])->name('admin.attendance.day-list');
    Route::get('admin/attendance/day/edit/{id}', [AttendanceController::class, 'dayEdit'])->name('admin.attendance.day-edit');
    Route::post('admin/attendance/day/save-edit-attendance', [AttendanceController::class, 'daySaveEdit'])->name('admin.attendance.day-save-edit-attendance');
    Route::get('admin/attendance/add', [AttendanceController::class, 'add'])->name('admin.attendance.add');
    Route::post('admin/attendance/save-add-attendance', [AttendanceController::class, 'saveAdd'])->name('admin.attendance.save-add-attendance');
    Route::post('admin/attendance/ajaxcall', [AttendanceController::class, 'ajaxcall'])->name('admin.attendance.ajaxcall');
    Route::get('admin/attendance/view/{id}', [AttendanceController::class, 'view'])->name('admin.attendance.view');

    Route::post('admin/emp/attendance/save-add-attendance', [AttendanceController::class, 'empSaveAdd'])->name('admin.emp-attendance.save-add-attendance');

    // Leave Request
    Route::get('admin/leave-request/list', [LeaveRequestController::class, 'list'])->name('admin.leave-request.list');
    Route::post('admin/leave-request/ajaxcall', [LeaveRequestController::class, 'ajaxcall'])->name('admin.leave-request.ajaxcall');
    Route::post('admin/reject-leave-request', [LeaveRequestController::class, 'rejectLeaveReq'])->name('admin.reject-leave-request');

    // Countersheet
    Route::get('admin/countersheet/list', [CountersheetController::class, 'list'])->name('admin.countersheet.list');
    Route::post('admin/countersheet/ajaxcall', [CountersheetController::class, 'ajaxcall'])->name('admin.countersheet.ajaxcall');
    Route::get('admin/countersheet/pdf', [CountersheetController::class, 'counterSheetPdf'])->name('admin-counter-sheet.pdf');

    //  User Role
    Route::get('admin/user-role/list', [UserroleController::class, 'list'])->name('admin.user-role.list');
    Route::get('admin/user-role/add', [UserroleController::class, 'add'])->name('admin.user-role.add');
    Route::post('admin/user-role/save-add-user-role', [UserroleController::class, 'saveAdd'])->name('admin.user-role.save-add-user-role');
    Route::get('admin/user-role/edit/{id}', [UserroleController::class, 'edit'])->name('admin.user-role.edit');
    Route::post('admin/user-role/save-edit-user-role', [UserroleController::class, 'saveEdit'])->name('admin.user-role.save-edit-user-role');
    Route::post('admin/user-role/ajaxcall', [UserroleController::class, 'ajaxcall'])->name('admin.user-role.ajaxcall');
    Route::post('admin/user-role/save-import-user-role', [UserroleController::class, 'save_import'])->name('admin.user-role.save-import-type');
    Route::get('admin/user-role/view/{id}', [UserroleController::class, 'view'])->name('admin.user-role.view');
    Route::post('admin/user-role/permission/{id}', [UserroleController::class, 'permission'])->name('admin.user-role.permission');

    //user
    Route::get('admin/user/add', [UserController::class, 'add'])->name('admin.user.add');
    Route::post('admin/user/save-add-user', [UserController::class, 'saveAdd'])->name('admin.user.save-add-user');
    Route::get('admin/user/list', [UserController::class, 'list'])->name('admin.user.list');
    Route::post('admin/user/ajaxcall', [UserController::class, 'ajaxcall'])->name('admin.user.ajaxcall');
    Route::get('admin/user/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::post('admin/user/save-edit-user', [UserController::class, 'saveEdit'])->name('admin.user.save-edit-user');

    Route::get('admin/supplier/list', [SupplierController::class, 'list'])->name('admin.supplier.list');
    Route::get('admin/supplier/add', [SupplierController::class, 'add'])->name('admin.supplier.add');
    Route::post('admin/supplier/save-add-supplier', [SupplierController::class, 'saveAdd'])->name('admin.supplier.save-add-supplier');
    Route::post('admin/supplier/ajaxcall', [SupplierController::class, 'ajaxcall'])->name('admin.supplier.ajaxcall');
    Route::get('admin/supplier/edit/{id}', [SupplierController::class, 'edit'])->name('admin.supplier.edit');
    Route::post('admin/supplier/save-edit-supplier', [SupplierController::class, 'saveEdit'])->name('admin.supplier.save-edit-supplier');
    Route::get('admin/supplier/view/{id}', [SupplierController::class, 'view'])->name('admin.supplier.view');


    //Employee Overtime
    Route::get('admin/emp-overtime/list', [EmpOverTimeController::class, 'list'])->name('admin.emp-overtime.list');
    Route::get('admin/emp-overtime/add', [EmpOverTimeController::class, 'add'])->name('admin.emp-overtime.add');
    Route::post('admin/emp-overtime/save-add-emp-overtime', [EmpOverTimeController::class, 'saveAdd'])->name('admin.emp-overtime.save-add-emp-overtime');
    Route::get('admin/emp-overtime/edit/{id}', [EmpOverTimeController::class, 'edit'])->name('admin.emp-overtime.edit');
    Route::post('admin/emp-overtime/save-edit-emp-overtime', [EmpOverTimeController::class, 'saveEdit'])->name('admin.emp-overtime.save-edit-emp-overtime');
    Route::post('admin/emp-overtime/ajaxcall', [EmpOverTimeController::class, 'ajaxcall'])->name('admin.emp-overtime.ajaxcall');


    // latter template
    Route::resource('admin/latter-templates', LatterTemplateController::class);
    Route::post('admin/latter-templates/ajaxcall', [LatterTemplateController::class, 'ajaxcall'])->name('latter-templates.ajaxcall');

    // latter Abbreviation
    Route::resource('admin/latter-abbreviations', LatterAbbreviationController::class);
    Route::post('admin/latter-abbreviations/ajaxcall', [LatterAbbreviationController::class, 'ajaxcall'])->name('latter-abbreviations.ajaxcall');

    // latter Abbreviation
    Route::resource('admin/attendance-settings', AttendanceSettingController::class);

    // change Request
    Route::get('admin/change-request/list', [ChangeRequestController::class, 'list'])->name('admin.change-request.list');
    Route::post('admin/change-request/ajaxcall', [ChangeRequestController::class, 'ajaxcall'])->name('admin.change-request.ajaxcall');
    Route::post('admin/change-request/update', [ChangeRequestController::class, 'changeReqUpdate'])->name('admin.change-request.update');

});

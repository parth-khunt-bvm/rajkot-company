<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\LoginController;
use App\Http\Controllers\backend\AuditTrailsController;
use App\Http\Controllers\backend\BranchController;
use App\Http\Controllers\backend\ManagerController;
use App\Http\Controllers\backend\TechnologyController;
use App\Http\Controllers\backend\SalaryController;

Route::get('admin-logout', [LoginController::class, 'adminLogout'])->name('admin-logout');

$adminPrefix = "";
Route::group(['prefix' => $adminPrefix, 'middleware' => ['admin']], function() {
    Route::get('my-dashboard', [DashboardController::class, 'myDashboard'])->name('my-dashboard');

    Route::get('edit-profile', [DashboardController::class, 'editProfile'])->name('edit-profile');
    Route::post('save-profile', [DashboardController::class, 'saveProfile'])->name('save-profile');

    Route::get('change-password', [DashboardController::class, 'change_password'])->name('change-password');
    Route::post('save-password', [DashboardController::class, 'save_password'])->name('save-password');

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

    //  manager

    Route::get('admin/manager/list', [ManagerController::class, 'list'])->name('admin.manager.list');

    Route::get('admin/manager/add', [ManagerController::class, 'add'])->name('admin.manager.add');
    Route::post('admin/manager/save-add-manager', [ManagerController::class, 'saveAdd'])->name('admin.manager.save-add-manager');

    Route::get('admin/manager/edit/{id}', [ManagerController::class, 'edit'])->name('admin.manager.edit');
    Route::post('admin/manager/save-edit-manager', [ManagerController::class, 'saveEdit'])->name('admin.manager.save-edit-manager');

    Route::post('admin/manager/ajaxcall', [ManagerController::class, 'ajaxcall'])->name('admin.manager.ajaxcall');

   //  technology

    Route::get('admin/technology/list', [TechnologyController::class, 'list'])->name('admin.technology.list');

    Route::get('admin/technology/add', [TechnologyController::class, 'add'])->name('admin.technology.add');
    Route::post('admin/technology/save-add-technology', [TechnologyController::class, 'saveAdd'])->name('admin.technology.save-add-technology');

    Route::get('admin/technology/edit/{id}', [TechnologyController::class, 'edit'])->name('admin.technology.edit');
    Route::post('admin/technology/save-edit-technology', [TechnologyController::class, 'saveEdit'])->name('admin.technology.save-edit-technology');

    Route::post('admin/technology/ajaxcall', [TechnologyController::class, 'ajaxcall'])->name('admin.technology.ajaxcall');

    // salary

    Route::get('admin/salary/list', [SalaryController::class, 'list'])->name('admin.salary.list');

    Route::get('admin/salary/add', [SalaryController::class, 'add'])->name('admin.salary.add');
    Route::post('admin/salary/save-add-salary', [SalaryController::class, 'saveAdd'])->name('admin.salary.save-add-salary');

    Route::get('admin/salary/edit/{id}', [SalaryController::class, 'edit'])->name('admin.salary.edit');
    Route::post('admin/salary/save-edit-salary', [SalaryController::class, 'saveEdit'])->name('admin.salary.save-edit-salary');

    Route::post('admin/salary/ajaxcall', [SalaryController::class, 'ajaxcall'])->name('admin.salary.ajaxcall');

});

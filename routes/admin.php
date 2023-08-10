<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\LoginController;
use App\Http\Controllers\backend\AuditTrailsController;
use App\Http\Controllers\backend\BranchController;
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

    Route::get('admin/branch/list', [BranchController::class, 'list'])->name('admin.branch.list');

    Route::get('admin/branch/add', [BranchController::class, 'add'])->name('admin.branch.add');
    Route::post('admin/branch/save-add-branch', [BranchController::class, 'saveAdd'])->name('admin.branch.save-add-branch');

    Route::get('admin/branch/edit/{id}', [BranchController::class, 'edit'])->name('admin.branch.edit');
    Route::post('admin/branch/save-edit-branch', [BranchController::class, 'saveEdit'])->name('admin.branch.save-edit-branch');

    Route::post('admin/branch/ajaxcall', [BranchController::class, 'ajaxcall'])->name('admin.branch.ajaxcall');

});

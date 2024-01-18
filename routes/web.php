<?php

use App\Http\Controllers\backend\EmployeeLoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\backend\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    echo "Cache is cleared<br>";
    Artisan::call('route:clear');
    echo "route cache is cleared<br>";
    Artisan::call('config:clear');
    echo "config is cleared<br>";
    Artisan::call('view:clear');
    echo "view is cleared<br>";
});

Route::get('/', [LoginController::class, 'login'])->name('admin-login');
Route::post('auth-admin-login', [LoginController::class, 'auth_admin_login'])->name('auth-admin-login');

Route::get('my-login', [EmployeeLoginController::class, 'login'])->name('my-login');
Route::post('auth-employee-login', [EmployeeLoginController::class, 'auth_employee_login'])->name('auth-employee-login');

Route::get('test-mail-view', [LoginController::class, 'testmail'])->name('test-mail-view');




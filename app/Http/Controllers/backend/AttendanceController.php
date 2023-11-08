<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Config;

class AttendanceController extends Controller
{
    public function add (){

        $objEmployee = new Employee();
        $data['employee'] = $objEmployee->get_admin_employee_details();

        $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Attendance";
        $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Attendance";
        $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Attendance";
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'pages/crud/forms/widgets/select2.js',
            'validate/jquery.validate.min.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'attendance.js',
        );
        $data['funinit'] = array(
            'Attendance.add()'
        );
        $data['header'] = array(
            'title' => 'Add Attendance',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Attendance List' => route('admin.attendance.list'),
                'Add Attendance' => 'Add Attendance',
            )
        );
        return view('backend.pages.attendance.add', $data);
    }
}

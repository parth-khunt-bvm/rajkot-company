<?php

namespace App\Http\Controllers\backend\employee;

use App\Http\Controllers\Controller;
use App\Models\EmployeeOvertime;
use Illuminate\Http\Request;
use Config;

class EmpOvertimeController extends Controller
{
    public function list(Request $request){

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Employee Overtime List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Employee Overtime List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Employee Overtime List';
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
            'plugins/custom/datatables/datatables.bundle.css'
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'plugins/custom/datatables/datatables.bundle.js',
            'pages/crud/datatables/data-sources/html.js',
            'validate/jquery.validate.min.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'employee_overtime.js',
        );
        $data['funinit'] = array(
            'EmployeeOverTime.init()',
        );
        $data['header'] = array(
            'title' => 'Employee Overtime List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Employee Overtime List' => 'Employee Overtime List',
            )
        );
        return view('backend.employee.pages.emp_overtime.list', $data);
    }

    public function ajaxcall(Request $request){
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objEmployeeOvertime = new EmployeeOvertime();
                $list = $objEmployeeOvertime->getdatatable();
                echo json_encode($list);
                break;

            case 'emp-overtime-view';
            $objEmployeeOvertime = new EmployeeOvertime();
            $list = $objEmployeeOvertime->get_emp_overtime_details($request->input('data'));
            echo json_encode($list);
            break;

        }
    }
}

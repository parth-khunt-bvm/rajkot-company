<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\EmployeeSalarySlip;
use Illuminate\Http\Request;

class EmployeeSalarySlipController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    // public function salarySlipList(Request $request)
    // {
    //         $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Employee Salary Slip list';
    //         $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Employee Salary Slip list';
    //         $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Employee Salary Slip list';
    //         $data['css'] = array(
    //             'toastr/toastr.min.css'
    //         );
    //         $data['plugincss'] = array(
    //             'plugins/custom/datatables/datatables.bundle.css'
    //         );
    //         $data['pluginjs'] = array(
    //             'toastr/toastr.min.js',
    //             'plugins/custom/datatables/datatables.bundle.js',
    //             'pages/crud/datatables/data-sources/html.js',
    //             'validate/jquery.validate.min.js',
    //         );
    //         $data['js'] = array(
    //             'comman_function.js',
    //             'ajaxfileupload.js',
    //             'jquery.form.min.js',
    //             // 'employee_asset_allocation.js',
    //         );
    //         $data['funinit'] = array(
    //             // 'EmployeeAssetAllocation.init()',
    //         );
    //         $data['header'] = array(
    //             'title' => 'Employee Salary Slip list',
    //             'breadcrumb' => array(
    //                 'Dashboard' => route('my-dashboard'),
    //                 'Employee Salary Slip list' => 'Employee Salary Slip list',
    //             )
    //         );
    //         return view('backend.pages.employee.view', $data);

    // }

    public function ajaxcall(Request $request)
    {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objEmployeeEmployeeSalarySlip = new EmployeeSalarySlip();
                $list = $objEmployeeEmployeeSalarySlip->getdatatable($request->input('data'));
                echo json_encode($list);
                break;
        }
    }
}

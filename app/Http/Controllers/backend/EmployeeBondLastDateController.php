<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\EmployeeBondLastDate;
use Illuminate\Http\Request;
use Config;

class EmployeeBondLastDateController extends Controller
{
    public function bondLastDateList(Request $request)
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(96, explode(',', $permission_array[0]['permission']))){

            $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Employee Bond Last Date list';
            $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Employee Bond Last Date  list';
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Employee Bond Last Date  list';
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
                'employee_bond_last_date.js',
            );
            $data['funinit'] = array(
                'EmployeeBondLastDate.init()',
            );
            $data['header'] = array(
                'title' => 'Employee Bond Last Date list',
                'breadcrumb' => array(
                    'Dashboard' => route('my-dashboard'),
                    'Employee Bond Last Date list' => 'Employee Bond Last Date list',
                )
            );
            return view('backend.pages.employee.bond_last_date_list', $data);
        }else{
            return redirect()->route('my-dashboard');
        }

    }

    public function ajaxcall(Request $request)
    {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $obEmployeeBondLastDate = new EmployeeBondLastDate();
                $list = $obEmployeeBondLastDate->getdatatable($request->input('data'));
                echo json_encode($list);
                break;

            case 'get-bond-last-date-employee':
                // dd("hii");
                $obEmployeeBondLastDate = new EmployeeBondLastDate();
                $list = $obEmployeeBondLastDate->getEmployee($request->input('data'));
                echo json_encode($list);
                break;
        }
    }

}

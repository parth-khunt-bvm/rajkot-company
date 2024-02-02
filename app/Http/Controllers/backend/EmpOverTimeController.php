<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmpOvertime;
use Illuminate\Http\Request;
use Config;

class EmpOverTimeController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function list(Request $request){

        $objEmployee = new Employee();
        $data['employee'] = $objEmployee->get_admin_employee_details();

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
            'emp_overtime.js',
        );
        $data['funinit'] = array(
            'EmployeeOverTime.init()',
            'EmployeeOverTime.add()'
        );
        $data['header'] = array(
            'title' => 'Employee Overtime List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Employee Overtime List' => 'Employee Overtime List',
            )
        );
        return view('backend.pages.emp_overtime.list', $data);
    }

    public function add (){
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(137, explode(',', $permission_array[0]['permission']))){

            $objEmployee = new Employee();
            $data['employee'] = $objEmployee->get_admin_employee_details();

            $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Employee Overtime";
            $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Employee Overtime";
            $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Employee Overtime";
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
                'emp_overtime.js',
            );
            $data['funinit'] = array(
                'EmployeeOverTime.add()'
            );
            $data['header'] = array(
                'title' => 'Add Employee Overtime',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Employee Overtime List' => route('admin.emp-overtime.list'),
                    'Add Employee Overtime' => 'Add Employee Overtime',
                )
            );
            return view('backend.pages.emp_overtime.add', $data);
        }else{
            return redirect()->route('admin.emp-overtime.list');
        }
    }

    public function saveAdd(Request $request){
        $objEmpOvertime = new EmpOvertime();
        $result = $objEmpOvertime->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Employee Overtime details successfully added.';
            $return['redirect'] = route('admin.emp-overtime.list');
        } elseif ($result == "emp_over_time_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Employee Overtime has already exists.';
        }  else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function edit ($empOverTimeId){
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(139, explode(',', $permission_array[0]['permission']))){

            $objEmployee = new Employee();
            $data['employee'] = $objEmployee->get_admin_employee_details();

            $objEmpOvertime = new EmpOvertime();
            $data['emp_overtime_details'] = $objEmpOvertime->get_emp_overtime_details($empOverTimeId);
            $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Employee Overtime";
            $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Employee Overtime";
            $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Employee Overtime";
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
                'emp_overtime.js',
            );
            $data['funinit'] = array(
                'EmployeeOverTime.edit()'
            );
            $data['header'] = array(
                'title' => 'Edit Employee Overtime',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Employee Overtime List' => route('admin.emp-overtime.list'),
                    'Edit Employee Overtime' => 'Edit Employee Overtime',
                )
            );
            return view('backend.pages.emp_overtime.edit', $data);
        }else{
            return redirect()->route('admin.branch.list');
        }
    }

    public function saveEdit(Request $request){
        $objEmpOvertime = new EmpOvertime();
        $result = $objEmpOvertime->saveEdit($request);
        if ($result == "updated") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Employee Overtime details successfully updated.';
            $return['redirect'] = route('admin.emp-overtime.list');
        } elseif ($result == "emp_over_time_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Employee Overtime has already exists.';
        }  else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function ajaxcall(Request $request){
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objEmpOvertime = new EmpOvertime();
                $list = $objEmpOvertime->getdatatable();
                echo json_encode($list);
                break;

            case 'emp-overtime-view';
            $objEmpOvertime = new EmpOvertime();
            $list = $objEmpOvertime->get_emp_overtime_details($request->input('data'));
            echo json_encode($list);
            break;

            case 'common-activity':
                $objEmpOvertime = new EmpOvertime();
                $data = $request->input('data');
                $result = $objEmpOvertime->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if($data['activity'] == 'delete-records'){
                        $return['message'] = "Employee Overtime details successfully deleted.";
                    }
                    $return['redirect'] = route('admin.emp-overtime.list');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'It seems like something is wrong';;
                }

                echo json_encode($return);
                exit;
        }
    }

}

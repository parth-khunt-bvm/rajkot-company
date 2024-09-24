<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\SalaryIncrement;
use Illuminate\Http\Request;
use Config;

class SalaryIncrementController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function list(Request $request)
    {
        $objEmployee = new Employee();
        $data['employee'] = $objEmployee->get_admin_employee_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Salary Increment list';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Salary Increment list';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Salary Increment list';
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
            'pages/crud/forms/widgets/select2.js',
            'validate/jquery.validate.min.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'salary_increment.js',
        );
        $data['funinit'] = array(
            'SalaryIncrement.init()',
        );
        $data['header'] = array(
            'title' => 'Salary Increment List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Salary Increment List' => 'Salary Increment List',
            )
        );
        return view('backend.pages.salary_increment.list', $data);

    }

    public function add()
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(152, explode(',', $permission_array[0]['permission']))){

            $objEmployee = new Employee();
            $data['employee'] = $objEmployee->get_admin_employee_details();

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add Salary Increment";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add Salary Increment";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add Salary Increment";
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array();
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'pages/crud/forms/widgets/select2.js',
                'validate/jquery.validate.min.js',
            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'salary_increment.js',
            );
            $data['funinit'] = array(
                'SalaryIncrement.add()'
            );
            $data['header'] = array(
                'title' => 'Add Salary Increment',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Salary Salary Increment List' => route('admin.salary-increment.list'),
                    'Add Salary Increment' => 'Add Salary Increment',
                )
            );
            return view('backend.pages.salary_increment.add', $data);

        }else{
            return redirect()->route('admin.salary-increment.list');
        }
    }

    public function saveAdd(Request $request)
    {
        $objSalaryIncrement = new SalaryIncrement();
        $result = $objSalaryIncrement->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Salary increment details successfully added.';
            $return['redirect'] = route('admin.salary-increment.list');
        } elseif ($result == "salary_increment_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Salary increment has already exists.';
        } else {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function edit($editId)
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(153, explode(',', $permission_array[0]['permission']))){

            $objEmployee = new Employee();
            $data['employee'] = $objEmployee->get_admin_employee_details();

            $objSalaryIncrement = new SalaryIncrement();
            $data['salary_increment_details'] = $objSalaryIncrement->get_salary_increment_details($editId);

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Edit Salary Increment";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Edit Salary Increment";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Edit Salary Increment";
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array();
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'pages/crud/forms/widgets/select2.js',
                'validate/jquery.validate.min.js',
            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'salary_increment.js',
            );
            $data['funinit'] = array(
                'SalaryIncrement.edit()'
            );
            $data['header'] = array(
                'title' => 'Edit Salary Increment',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Salary Increment List' => route('admin.salary-increment.list'),
                    'Edit Salary Increment' => 'Edit Salary Increment',
                )
            );
            return view('backend.pages.salary_increment.edit', $data);

        }else{
            return redirect()->route('admin.salary-increment.list');
        }

    }

    public function saveEdit(Request $request)
    {
        $objSalaryIncrement = new SalaryIncrement();
        $result = $objSalaryIncrement->saveEdit($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Salary increment details successfully updated.';
            $return['redirect'] = route('admin.salary-increment.list');
        } elseif ($result == "salary_increment_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Salary increment has already exists.';
        } else {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }


    public function ajaxcall(Request $request)
    {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objSalaryIncrement = new SalaryIncrement();
                $list = $objSalaryIncrement->getdatatable($request->input('data'));
                echo json_encode($list);
                break;

            case 'get-employee-for-salary-increment':
                $data = $request->input('data');
                $objEmployee = new Employee();
                $list = $objEmployee->get_employee_for_salary_increment($data['employee'] );
                echo json_encode($list);
                break;

            case 'common-activity':
                $data = $request->input('data');
                $objSalaryIncrement = new SalaryIncrement();
                $result = $objSalaryIncrement->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if ($data['activity'] == 'delete-records') {
                        $return['message'] = "Salary increment details successfully deleted.";
                    }
                    $return['redirect'] = route('admin.salary-increment.list');
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

<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Imports\EmployeeImport;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\Technology;
use Illuminate\Http\Request;
use Config;
use DB;

class EmployeeController extends Controller
{

    function __construct()
    {
        $this->middleware('admin');
    }

    public function list(Request $request)
    {

        $objTechnology = new Technology();
        $data['technology'] = $objTechnology->get_admin_technology_details();

        $objDesignation = new Designation();
        $data['designation'] = $objDesignation->get_admin_designation_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Employee list';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Employee list';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Employee list';
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
            'employee.js',
        );
        $data['funinit'] = array(
            'Employee.init()'
        );
        $data['header'] = array(
            'title' => 'Employee list',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Employee list' => 'Employee list',
            )
        );
        return view('backend.pages.employee.list', $data);
    }
    public function add()
    {
        $objTechnology = new Technology();
        $data['technology'] = $objTechnology->get_admin_technology_details();

        $objDesignation = new Designation();
        $data['designation'] = $objDesignation->get_admin_designation_details();

        $objManager = new Manager();
        $data['manager'] = $objManager->get_admin_manager_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add Employee";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add Employee";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add Employee";
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'pages/crud/forms/widgets/select2.js',
            'validate/jquery.validate.min.js',
            'pages/crud/file-upload/image-input.js'
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'employee.js',
        );
        $data['funinit'] = array(
            'Employee.add()'
        );
        $data['header'] = array(
            'title' => 'Add Employee',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Employee List' => route('admin.employee.list'),
                'Add Employee' => 'Add Employee',
            )
        );
        return view('backend.pages.employee.add', $data);
    }

    public function saveAdd(Request $request)
    {
        $objEmployee = new Employee();

        $result = $objEmployee->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Employee details successfully added.';
            $return['redirect'] = route('admin.employee.list');
        } elseif ($result == "personal_gmail_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'employee personal gmail has already exists.';
        } elseif ($result == "personal_number_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'employee personal numbar has already exists.';
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
        $objTechnology = new Technology();
        $data['technology'] = $objTechnology->get_admin_technology_details();

        $objDesignation = new Designation();
        $data['designation'] = $objDesignation->get_admin_designation_details();

        $objEmployee = new Employee();
        $data['employee_details'] = $objEmployee->get_employee_details($editId);

        $data['title'] = Config::get('constants.PROJECT_NAME') . " || Edit Employee";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || Edit Employee";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Edit Employee";
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
            // 'css/pages/wizard/wizard-3.css',
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'pages/crud/forms/widgets/select2.js',
            'validate/jquery.validate.min.js',
            // 'pages/custom/wizard/wizard-3.js',
            'pages/crud/file-upload/image-input.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'employee.js',
        );
        $data['funinit'] = array(
            'Employee.edit()'
        );
        $data['header'] = array(
            'title' => 'Edit Employee',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Employee List' => route('admin.employee.list'),
                'Edit employee' => 'Edit employee',
            )
        );
        return view('backend.pages.employee.edit', $data);
    }

    public function saveEdit(Request $request)
    {
        $objemployee = new Employee();
        $result = $objemployee->saveEdit($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'employee details successfully updated.';
            $return['redirect'] = route('admin.employee.list');
        } elseif ($result == "employee_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'employee has already exists.';
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
                $objEmployee = new Employee();
                $list = $objEmployee->getdatatable($request->input('data'));

                echo json_encode($list);
                break;

            case 'common-activity':
                $data = $request->input('data');
                $objEmployee = new Employee();
                $result = $objEmployee->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if ($data['activity'] == 'delete-records') {
                        $return['message'] = "Employee details successfully deleted.";
                    } elseif ($data['activity'] == 'active-records') {
                        $return['message'] = "Employee details successfully actived.";
                    } else {
                        $return['message'] = "Employee details successfully deactived.";
                    }
                    $return['redirect'] = route('admin.employee.list');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'It seems like something is wrong';;
                }

                echo json_encode($return);
                exit;
        }
    }

    public function view($viewId){

        $objEmployee = new Employee();
        $data['employee_details'] = $objEmployee->get_employee_details($viewId);

        $data['title'] = Config::get('constants.PROJECT_NAME') . " || View Employee";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || View Employee";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || View Employee";
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
            'employee.js',
        );
        $data['funinit'] = array(
        );
        $data['header'] = array(
            'title' => 'Basic Detail',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Employee List' => route('admin.employee.list'),
                'View employee detail' => 'View employee detail',
            )
        );
        return view('backend.pages.employee.view', $data);

    }

    public function save_import(Request $request){


        $path = $request->file('file')->store('temp');
        $data = \Excel::import(new EmployeeImport($request->file('file')),$path);
        $return['status'] = 'success';
        $return['message'] = 'Employee added successfully.';
        $return['redirect'] = route('admin.employee.list');

        echo json_encode($return);
        exit;
    }
}

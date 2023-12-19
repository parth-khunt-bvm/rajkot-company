<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Imports\SalaryImport;
use Illuminate\Http\Request;
use Config;
use App\Models\Salary;
use App\Models\Manager;
use App\Models\Branch;
use App\Models\Technology;
use Excel;

class SalaryController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function list(Request $request)
    {
        $objManager = new Manager();
        $data['manager'] = $objManager->get_admin_manager_details();

        $objBranch = new Branch();
        $data['branch'] = $objBranch->get_admin_branch_details();

        $objTechnology = new Technology();
        $data['technology'] = $objTechnology->get_admin_technology_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Salary list';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Salary list';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Salary list';
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
            'salary.js',
        );
        $data['funinit'] = array(
            'Salary.init()',
            'Salary.add()'
        );
        $data['header'] = array(
            'title' => 'Salary list',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Salary list' => 'Salary list',
            )
        );
        return view('backend.pages.salary.list', $data);

    }

    public function add()
    {
        $objManager = new Manager();
        $data['manager'] = $objManager->get_admin_manager_details();

        $objBranch = new Branch();
        $data['branch'] = $objBranch->get_admin_branch_details();

        $objTechnology = new Technology();
        $data['technology'] = $objTechnology->get_admin_technology_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add Salary";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add Salary";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add Salary";
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
            'salary.js',
        );
        $data['funinit'] = array(
            'Salary.add()'
        );
        $data['header'] = array(
            'title' => 'Add Salary',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Salary List' => route('admin.salary.list'),
                'Add Salary' => 'Add Salary',
            )
        );
        return view('backend.pages.salary.add', $data);
    }

    public function saveAdd(Request $request)
    {
        $objSalary = new Salary();
        $result = $objSalary->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Salary details successfully added.';
            $return['redirect'] = route('admin.salary.list');
        } elseif ($result == "salary_name_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Salary has already exists.';
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

        $objManager = new Manager();
        $data['manager'] = $objManager->get_admin_manager_details();

        $objBranch = new Branch();
        $data['branch'] = $objBranch->get_admin_branch_details();

        $objTechnology = new Technology();
        $data['technology'] = $objTechnology->get_admin_technology_details();

        $objSalary = new Salary();
        $data['salary_details'] = $objSalary->get_salary_details($editId);

        $data['title'] = Config::get('constants.PROJECT_NAME') . " || Edit Salary";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || Edit Salary";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Edit Salary";
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
            'salary.js',
        );
        $data['funinit'] = array(
            'Salary.edit()'
        );
        $data['header'] = array(
            'title' => 'Edit salary',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Salary List' => route('admin.salary.list'),
                'Edit salary' => 'Edit salary',
            )
        );
        return view('backend.pages.salary.edit', $data);
    }

    public function saveEdit(Request $request)
    {
        $objSalary = new Salary();
        $result = $objSalary->saveEdit($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Salary details successfully updated.';
            $return['redirect'] = route('admin.salary.list');
        } elseif ($result == "salary_name_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Salary has already exists.';
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
                $objSalary = new Salary();
                $list = $objSalary->getdatatable($request->input('data'));
                echo json_encode($list);
                break;

            case 'common-activity':
                $data = $request->input('data');
                $objSalary = new Salary();
                $result = $objSalary->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if ($data['activity'] == 'delete-records') {
                        $return['message'] = "Salary details successfully deleted.";
                    } elseif ($data['activity'] == 'active-records') {
                        $return['message'] = "Salary details successfully actived.";
                    } else {
                        $return['message'] = "Salary details successfully deactived.";
                    }
                    $return['redirect'] = route('admin.salary.list');
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

        $objSalary = new Salary();
        $data['salary_details'] = $objSalary->get_salary_details($viewId);

        $data['title'] = Config::get('constants.PROJECT_NAME') . " || View Salary";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || View Salary";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || View Salary";
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
            'salary.js',
        );
        $data['funinit'] = array(
        );
        $data['header'] = array(
            'title' => 'Basic Detail',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Salary List' => route('admin.salary.list'),
                'View salary detail' => 'View salary detail',
            )
        );
        return view('backend.pages.salary.view', $data);

    }

    public function save_import(Request $request){


        $path = $request->file('file')->store('temp');
        $data = \Excel::import(new SalaryImport($request->file('file')),$path);
        $return['status'] = 'success';
        $return['message'] = 'Salary added successfully.';
        $return['redirect'] = route('admin.salary.list');

        echo json_encode($return);
        exit;
    }
}

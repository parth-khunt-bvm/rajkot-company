<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Imports\CounterImport;
use App\Models\Counter;
use App\Models\Employee;
use App\Models\Technology;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Config;
use DB;

class CounterController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function list(Request $request)
    {
        $objTechnology = new Technology();
        $data['technology'] = $objTechnology->get_admin_technology_details();

        $objEmployee = new Employee();
        $data['employee'] = $objEmployee->get_admin_employee_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Counter list';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Counter list';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Counter list';
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
            'counter.js',
        );
        $data['funinit'] = array(
            'Counter.init()',
        );
        $data['header'] = array(
            'title' => 'Counter list',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Counter list' => 'Counter list',
            )
        );
        return view('backend.pages.counter.list', $data);

    }

    public function add()
    {
        $objTechnology = new Technology();
        $data['technology'] = $objTechnology->get_admin_technology_details();

        $objEmployee = new Employee();
        $data['employee'] = $objEmployee->get_admin_employee_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add Counter";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add Counter";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add Counter";
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
            'counter.js',
        );
        $data['funinit'] = array(
            'Counter.add()'
        );
        $data['header'] = array(
            'title' => 'Add Counter',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Counter List' => route('admin.counter.list'),
                'Add Counter' => 'Add Counter',
            )
        );
        return view('backend.pages.counter.add', $data);
    }

    public function saveAdd(Request $request)
    {
        $objCounter = new Counter();
        $result = $objCounter->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Counter details successfully added.';
            $return['redirect'] = route('admin.counter.list');
        } elseif ($result == "counter_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Counter has already exists.';
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

        $objEmployee = new Employee();
        $data['employee'] = $objEmployee->get_admin_employee_details();

        $objCounter = new Counter();
        $data['counter_detail'] = $objCounter->get_counter_detail($editId);

        $data['title'] = Config::get('constants.PROJECT_NAME') . " || Edit Counter";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || Edit Counter";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Edit Counter";
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
            'counter.js',
        );
        $data['funinit'] = array(
            'Counter.edit()'
        );
        $data['header'] = array(
            'title' => 'Edit Counter',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Counter List' => route('admin.counter.list'),
                'Edit Counter' => 'Edit Counter',
            )
        );
        return view('backend.pages.counter.edit', $data);
    }

    public function saveEdit(Request $request)
    {
        $objCounter = new Counter();
        $result = $objCounter->saveEdit($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Counter details successfully updated.';
            $return['redirect'] = route('admin.counter.list');
        } elseif ($result == "counter_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Counter has already exists.';
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
                $objCounter = new Counter();
                $list = $objCounter->getdatatable($request->input('data'));

                echo json_encode($list);
                break;

            case 'common-activity':
                $data = $request->input('data');
                $objCounter = new Counter();
                $result = $objCounter->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if ($data['activity'] == 'delete-records') {
                        $return['message'] = "Counter detail successfully deleted.";
                    } elseif ($data['activity'] == 'salary-counted') {
                        $return['message'] = "Salary detail successfully counted.";
                    } else {
                        $return['message'] = "Salary detail successfully not counted.";
                    }
                    $return['redirect'] = route('admin.counter.list');
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

        $objCounter = new Counter();
        $data['counter_detail'] = $objCounter->get_counter_detail($viewId);

        $data['title'] = Config::get('constants.PROJECT_NAME') . " || View Counter";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || View Counter";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || View Counter";
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
            'counter.js',
        );
        $data['funinit'] = array(
        );
        $data['header'] = array(
            'title' => 'Basic Detail',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Counter List' => route('admin.counter.list'),
                'View counter detail' => 'View counter detail',
            )
        );
        return view('backend.pages.counter.view', $data);

    }

    public function save_import(Request $request){

        $path = $request->file('file')->store('temp');
        $data = \Excel::import(new CounterImport($request->month,$request->year,$request->file('file')),$path);
        $return['status'] = 'success';
        $return['message'] = 'Counter added successfully.';
        $return['redirect'] = route('admin.counter.list');

        echo json_encode($return);
        exit;
    }
}

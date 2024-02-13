<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Imports\HrIncomeImport;
use Illuminate\Http\Request;
use Config;
use App\Models\Manager;
use App\Models\Branch;
use App\Models\HrIncome;
use App\Models\Revenue;
use App\Models\Technology;
use Excel;
use DB;

class HrIncomeController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function list(Request $request)
    {

        $objManager = new Manager();
        $data['manager'] = $objManager->get_admin_manager_details();

        $objHrIncome = new HrIncome();
        $data['amount'] = $objHrIncome->get_total_amount();

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Hr Income list';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Hr Income list';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Hr Income list';
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
            'hr_income.js',
        );
        $data['funinit'] = array(
            'HrIncome.init()',
            'HrIncome.add()'
        );
        $data['header'] = array(
            'title' => 'Hr Income list',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Hr Income list' => 'Hr Income list',
            )
        );
        return view('backend.pages.hr.income.list', $data);

    }

    public function add()
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(62, explode(',', $permission_array[0]['permission']))){
            $objManager = new Manager();
            $data['manager'] = $objManager->get_admin_manager_details();

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add c";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add hr_income";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add hr_income";
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
                'hr_income.js',
            );
            $data['funinit'] = array(
                'HrIncome.add()'
            );
            $data['header'] = array(
                'title' => 'Add Hr Income',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Hr Income List' => route('admin.hr.income.list'),
                    'Add Hr Income' => 'Add Hr Income',
                )
            );
            return view('backend.pages.hr.income.add', $data);
        }else{
            return redirect()->route('admin.hr.income.list');
        }
    }

    public function saveAdd(Request $request)
    {
        $objHrIncome = new HrIncome();
        $result = $objHrIncome->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Hr Income details successfully added.';
            $return['redirect'] = route('admin.hr.income.list');
        } elseif ($result == "hr_income_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Hr Income has already exists.';
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

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(64, explode(',', $permission_array[0]['permission']))){
            $objManager = new Manager();
            $data['manager'] = $objManager->get_admin_manager_details();

            $objHrIncome = new HrIncome();
            $data['hr_income_details'] = $objHrIncome->get_hr_income_details($editId);

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Edit Hr Income";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Edit Hr Income";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Edit Hr Income";
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
                'hr_income.js',
            );
            $data['funinit'] = array(
                'HrIncome.edit()'
            );
            $data['header'] = array(
                'title' => 'Edit Hr Income',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Hr Income List' => route('admin.hr.income.list'),
                    'Edit Hr Income' => 'Edit Hr Income',
                )
            );
            return view('backend.pages.hr.income.edit', $data);
        }else{
            return redirect()->route('admin.hr.income.list');
        }
    }

    public function saveEdit(Request $request)
    {
        $objHrIncome = new HrIncome();
        $result = $objHrIncome->saveEdit($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Hr Income details successfully updated.';
            $return['redirect'] = route('admin.hr.income.list');
        } elseif ($result == "hr_income_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Hr Income has already exists.';
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
                $objHrIncome = new HrIncome();
                $list = $objHrIncome->getdatatable($request->input('data'));

                echo json_encode($list);
                break;

            case 'total-amount':
                $data = $request->input('data');
                $objHrIncome = new HrIncome();
                $list = $objHrIncome->get_total_amount($data['manager'],$data['monthOf'],$data['year']);
                echo json_encode($list);
                break;

            case 'common-activity':
                $data = $request->input('data');
                $objHrIncome = new HrIncome();
                $result = $objHrIncome->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if ($data['activity'] == 'delete-records') {
                        $return['message'] = "Hr Income details successfully deleted.";
                    }
                    $return['redirect'] = route('admin.hr.income.list');
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

        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(63, explode(',', $permission_array[0]['permission']))){
            $objHrIncome = new HrIncome();
            $data['hr_income_details'] = $objHrIncome->get_hr_income_details($viewId);

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || View Hr Income";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || View Hr Income";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || View Hr Income";
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
                'hr_income.js',
            );
            $data['funinit'] = array(
            );
            $data['header'] = array(
                'title' => 'Basic Detail',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Hr Income List' => route('admin.hr.income.list'),
                    'View hr income detail' => 'View hr income detail',
                )
            );
            return view('backend.pages.hr.income.view', $data);

        }else{
            return redirect()->route('admin.hr.income.list');
        }
    }

    public function save_import(Request $request){

        $path = $request->file('file')->store('temp');
        $data = \Excel::import(new HrIncomeImport($request->file('file')),$path);
        $return['status'] = 'success';
        $return['message'] = 'Hr Income added successfully.';
        $return['redirect'] = route('admin.hr.income.list');

        echo json_encode($return);
        exit;
    }

}

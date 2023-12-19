<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Imports\HrExpenseImport;
use App\Models\HrExpense;
use Illuminate\Http\Request;
use Config;
use DB;
use Excel;

class HrExpenseController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function list(Request $request)
    {
        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Hr Expense list';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Hr Expense list';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Hr Expense list';
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
            'hr_expense.js',
        );
        $data['funinit'] = array(
            'HrExpense.init()',
            'HrExpense.add()'
        );
        $data['header'] = array(
            'title' => 'Hr Expense list',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Hr Expense list' => 'Hr Expense list',
            )
        );
        return view('backend.pages.hr.expense.list', $data);

    }

    public function add()
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(in_array(68, explode(',', $permission_array[0]['permission']))){
            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add hr_expense";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add hr_expense";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add hr_expense";
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
                'hr_expense.js',
            );
            $data['funinit'] = array(
                'HrExpense.add()'
            );
            $data['header'] = array(
                'title' => 'Add Hr Expense',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Hr Expense List' => route('admin.hr.expense.list'),
                    'Add Hr Expense' => 'Add Hr Expense',
                )
            );
            return view('backend.pages.hr.expense.add', $data);
        }else{
            return redirect()->route('admin.hr.expense.list');
        }
    }

    public function saveAdd(Request $request)
    {
        $objHrExpense = new HrExpense();
        $result = $objHrExpense->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Hr Expense details successfully added.';
            $return['redirect'] = route('admin.hr.expense.list');
        } elseif ($result == "hr_expense_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Hr Expense has already exists.';
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

        if(in_array(70, explode(',', $permission_array[0]['permission']))){
            $objHrExpense = new HrExpense();
            $data['hr_expense_details'] = $objHrExpense->get_hr_expense_details($editId);

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Edit Hr Expense";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Edit Hr Expense";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Edit Hr Expense";
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
                'hr_expense.js',
            );
            $data['funinit'] = array(
                'HrExpense.edit()'
            );
            $data['header'] = array(
                'title' => 'Edit Hr Expense',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Hr Expense List' => route('admin.hr.expense.list'),
                    'Edit Hr Expense' => 'Edit Hr Expense',
                )
            );
            return view('backend.pages.hr.expense.edit', $data);
        }else{
            return redirect()->route('admin.hr.expense.list');
        }
    }

    public function saveEdit(Request $request)
    {
        $objHrExpense = new HrExpense();
        $result = $objHrExpense->saveEdit($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Hr Expense details successfully updated.';
            $return['redirect'] = route('admin.hr.expense.list');
        } elseif ($result == "hr_expense_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Hr Expense has already exists.';
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
                $objHrExpense = new HrExpense();
                $list = $objHrExpense->getdatatable($request->input('data'));

                echo json_encode($list);
                break;

            case 'common-activity':
                $data = $request->input('data');
                $objHrExpense = new HrExpense();
                $result = $objHrExpense->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if ($data['activity'] == 'delete-records') {
                        $return['message'] = "Hr Expense details successfully deleted.";
                    }
                    $return['redirect'] = route('admin.hr.expense.list');
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

        if(in_array(69, explode(',', $permission_array[0]['permission']))){

            $objHrExpense = new HrExpense();
            $data['hr_expense_details'] = $objHrExpense->get_hr_expense_details($viewId);

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
                'hr_expense.js',
            );
            $data['funinit'] = array(
            );
            $data['header'] = array(
                'title' => 'Basic Detail',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Hr Expense List' => route('admin.hr.expense.list'),
                    'View hr expense detail' => 'View hr expense detail',
                )
            );
            return view('backend.pages.hr.expense.view', $data);
        }else{
            return redirect()->route('admin.hr.expense.list');
        }
    }

    public function save_import(Request $request){

        $path = $request->file('file')->store('temp');
        $data = \Excel::import(new HrExpenseImport($request->file('file')),$path);
        $return['status'] = 'success';
        $return['message'] = 'Hr Expense added successfully.';
        $return['redirect'] = route('admin.hr.expense.list');

        echo json_encode($return);
        exit;
    }
}

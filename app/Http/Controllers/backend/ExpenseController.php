<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Imports\ExpenseImport;
use Illuminate\Http\Request;
use Config;
use App\Models\Manager;
use App\Models\Branch;
use App\Models\Expense;
use App\Models\Type;

class ExpenseController extends Controller
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

        $objType = new Type();
        $data['type'] = $objType->get_admin_type_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Expense list';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Expense list';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Expense list';
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
            'expense.js',
        );
        $data['funinit'] = array(
            'Expense.init()',
            'Expense.add()'
        );
        $data['header'] = array(
            'title' => 'Expense list',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Expense list' => 'Expense list',
            )
        );
        return view('backend.pages.expense.list', $data);

    }
    public function add()
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);
        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(50, explode(',', $permission_array[0]['permission']))){
            $objManager = new Manager();
            $data['manager'] = $objManager->get_admin_manager_details();

            $objBranch = new Branch();
            $data['branch'] = $objBranch->get_admin_branch_details();

            $objType = new Type();
            $data['type'] = $objType->get_admin_type_details();


            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add expense";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add expense";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add expense";
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
                'expense.js',
            );
            $data['funinit'] = array(
                'Expense.add()'
            );
            $data['header'] = array(
                'title' => 'Add Expense',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Expense List' => route('admin.expense.list'),
                    'Add Expense' => 'Add Expense',
                )
            );
            return view('backend.pages.expense.add', $data);
        }else{
            return redirect()->route('admin.expense.list');
        }
        }

    public function saveAdd(Request $request)
    {
        $objExpense = new Expense();
        $result = $objExpense->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Expense details successfully added.';
            $return['redirect'] = route('admin.expense.list');
        } elseif ($result == "expense_name_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Expense has already exists.';
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

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(52, explode(',', $permission_array[0]['permission']))){

            $objManager = new Manager();
            $data['manager'] = $objManager->get_admin_manager_details();

            $objBranch = new Branch();
            $data['branch'] = $objBranch->get_admin_branch_details();

            $objType = new Type();
            $data['type'] = $objType->get_admin_type_details();

            $objExpense = new Expense();
            $data['expense_details'] = $objExpense->get_expense_details($editId);

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Edit Expense";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Edit Expense";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Edit Expense";
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
                'expense.js',
            );
            $data['funinit'] = array(
                'Expense.edit()'
            );
            $data['header'] = array(
                'title' => 'Edit Expense',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Expense List' => route('admin.expense.list'),
                    'Edit expense' => 'Edit expense',
                )
            );
            return view('backend.pages.expense.edit', $data);
        }else{
            return redirect()->route('admin.expense.list');
        }
    }

    public function saveEdit(Request $request)
    {
        $objExpense = new Expense();
        $result = $objExpense->saveEdit($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Expense details successfully updated.';
            $return['redirect'] = route('admin.expense.list');
        } elseif ($result == "Expense_name_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Expense has already exists.';
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
                $objExpense = new Expense();
                $list = $objExpense->getdatatable($request->input('data'));

                echo json_encode($list);
                break;

            case 'common-activity':
                $data = $request->input('data');
                $objExpense = new Expense();
                $result = $objExpense->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if ($data['activity'] == 'delete-records') {
                        $return['message'] = "Expense details successfully deleted.";
                    } elseif ($data['activity'] == 'active-records') {
                        $return['message'] = "Expense details successfully actived.";
                    } else {
                        $return['message'] = "Expense details successfully deactived.";
                    }
                    $return['redirect'] = route('admin.expense.list');
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

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(51, explode(',', $permission_array[0]['permission']))){
            $objExpense = new Expense();
            $data['expense_details'] = $objExpense->get_expense_details($viewId);

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || View Expense";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || View Expense";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || View Expense";
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
                'expense.js',
            );
            $data['funinit'] = array(
            );
            $data['header'] = array(
                'title' => 'Basic Detail',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Expense List' => route('admin.expense.list'),
                    'View expense detail' => 'View expense detail',
                )
            );
            return view('backend.pages.expense.view', $data);
        }else{
            return redirect()->route('admin.expense.list');
        }

    }

    public function save_import(Request $request){


        $path = $request->file('file')->store('temp');
        $data = \Excel::import(new ExpenseImport($request->file('file')),$path);
        $return['status'] = 'success';
        $return['message'] = 'Expense added successfully.';
        $return['redirect'] = route('admin.expense.list');

        echo json_encode($return);
        exit;
    }
}

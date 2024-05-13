<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Imports\RevenueImport;
use Illuminate\Http\Request;
use Config;
use App\Models\Manager;
use App\Models\Branch;
use App\Models\Revenue;
use App\Models\Technology;
use Excel;

class RevenueController extends Controller
{

    function __construct()
    {
        $this->middleware('admin');
    }

    public function list(Request $request)
    {
        $objManager = new Manager();
        $data['manager'] = $objManager->get_admin_manager_details();

        $objRevenue = new Revenue();
        $data['amount'] = $objRevenue->get_total_amount();

        $objTechnology = new Technology();
        $data['technology'] = $objTechnology->get_admin_technology_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Revenue list';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Revenue list';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Revenue list';
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
            'revenue.js',
        );
        $data['funinit'] = array(
            'Revenue.init()',
            'Revenue.add()'
        );
        $data['header'] = array(
            'title' => 'Revenue list',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Revenue list' => 'Revenue list',
            )
        );
        return view('backend.pages.revenue.list', $data);

    }

    public function add()
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);
        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(56, explode(',', $permission_array[0]['permission']))){
            $objManager = new Manager();
            $data['manager'] = $objManager->get_admin_manager_details();

            $objTechnology = new Technology();
            $data['technology'] = $objTechnology->get_admin_technology_details();

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add Revenue";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add Revenue";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add Revenue";
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
                'revenue.js',
            );
            $data['funinit'] = array(
                'Revenue.add()'
            );
            $data['header'] = array(
                'title' => 'Add Revenue',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Revenue List' => route('admin.revenue.list'),
                    'Add Revenue' => 'Add Revenue',
                )
            );
            return view('backend.pages.revenue.add', $data);
        }else{
            return redirect()->route('admin.revenue.list');
        }
    }

    public function saveAdd(Request $request)
    {
        $objRevenue = new Revenue();
        $result = $objRevenue->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Revenue details successfully added.';
            $return['redirect'] = route('admin.revenue.list');
        } elseif ($result == "revenue_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Revenue has already exists.';
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
        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(58, explode(',', $permission_array[0]['permission']))){
            $objManager = new Manager();
            $data['manager'] = $objManager->get_admin_manager_details();

            $objTechnology = new Technology();
            $data['technology'] = $objTechnology->get_admin_technology_details();

            $objRevenue = new Revenue();
            $data['revenue_details'] = $objRevenue->get_revenue_details($editId);

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Edit Revenue";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Edit Revenue";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Edit Revenue";
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
                'revenue.js',
            );
            $data['funinit'] = array(
                'Revenue.edit()'
            );
            $data['header'] = array(
                'title' => 'Edit revenue',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Revenue List' => route('admin.revenue.list'),
                    'Edit revenue' => 'Edit revenue',
                )
            );
            return view('backend.pages.revenue.edit', $data);
        }else{
            return redirect()->route('admin.revenue.list');
        }
    }

    public function saveEdit(Request $request)
    {
        $objRevenue = new Revenue();
        $result = $objRevenue->saveEdit($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Revenue details successfully updated.';
            $return['redirect'] = route('admin.revenue.list');
        } elseif ($result == "revenue_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Revenue has already exists.';
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
                $objRevenue = new Revenue();
                $list = $objRevenue->getdatatable($request->input('data'));

                echo json_encode($list);
                break;

            case 'get-revenue-trash':
                $objRevenue = new Revenue();
                $list = $objRevenue->getRevenueDatatable($request->input('data'));
                echo json_encode($list);
                break;

            case 'common-activity':
                $data = $request->input('data');
                $objRevenue = new Revenue();
                $result = $objRevenue->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if ($data['activity'] == 'delete-records') {
                        $return['message'] = "Revenue details successfully deleted.";
                        $return['redirect'] = route('admin.revenue.list');
                    } else if($data['activity'] == 'restore-records'){
                        $return['message'] = "Revenue details successfully restore.";
                        $return['redirect'] = route('admin.revenue.deleted');
                    } elseif ($data['activity'] == 'active-records') {
                        $return['message'] = "Revenue details successfully actived.";
                        $return['redirect'] = route('admin.revenue.list');
                    } else {
                        $return['message'] = "Revenue details successfully deactived.";
                        $return['redirect'] = route('admin.revenue.list');
                    }
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
        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(57, explode(',', $permission_array[0]['permission']))){
            $objRevenue = new Revenue();
            $data['revenue_details'] = $objRevenue->get_revenue_details($viewId);

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || View Revenue";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || View Revenue";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || View Revenue";
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
                'revenue.js',
            );
            $data['funinit'] = array(
            );
            $data['header'] = array(
                'title' => 'Basic Detail',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Revenue List' => route('admin.revenue.list'),
                    'View revenue detail' => 'View revenue detail',
                )
            );
            return view('backend.pages.revenue.view', $data);
        }else{
            return redirect()->route('admin.revenue.list');
        }

    }

    public function save_import(Request $request){

        try {
            $path = $request->file('file')->store('temp');
            $data = \Excel::import(new RevenueImport($request->file('file')),$path);
            $return['status'] = 'success';
            $return['message'] = 'Revenue added successfully.';
            $return['redirect'] = route('admin.revenue.list');

            echo json_encode($return);
            exit;

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

             $failures = $e->failures();
             $errorMessages = [];

             foreach ($failures as $failure) {
                $errorMessages[] = [
                    'row' => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'errors' => $failure->errors(),
                    'values' => $failure->values(),
                ];
             }


            $return['status'] = 'error';
            // $return['message'] = $errorMessages[0]['errors'][0]; // Sending all errors
            $return['message'] = "Row " . $errorMessages[0]['row'] . ": " . $errorMessages[0]['errors'][0];
            echo json_encode($return);
            exit;
        }
    }

    public function showDeletedData(Request $request)
    {
        $objManager = new Manager();
        $data['manager'] = $objManager->get_admin_manager_details();

        $objTechnology = new Technology();
        $data['technology'] = $objTechnology->get_admin_technology_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Revenue Deleted list';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Revenue Deleted list';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Revenue Deleted list';
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
            'revenue.js',
        );
        $data['funinit'] = array(
            'Revenue.trash_init()',
        );
        $data['header'] = array(
            'title' => 'Revenue Deleted list',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Revenue Deleted list' => 'Revenue Deleted list',
            )
        );
        return view('backend.pages.revenue.trash', $data);

    }
}

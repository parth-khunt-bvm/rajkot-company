<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Imports\DesignationImport;
use App\Models\Designation;
use Illuminate\Http\Request;
use Config;
use Excel;

class DesignationController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function list(Request $request)
    {

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Designation List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Designation List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Designation List';
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
            'designation.js',
        );
        $data['funinit'] = array(
            'Designation.init()',
            'Designation.add()'
        );
        $data['header'] = array(
            'title' => 'Designation List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Designation List' => 'Designation List',
            )
        );
        return view('backend.pages.designation.list', $data);

    }

    public function add()
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(38, explode(',', $permission_array[0]['permission']))){
            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add Designation List";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add Designation List";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add Designation List";
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array();
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'validate/jquery.validate.min.js',
            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'designation.js',
            );
            $data['funinit'] = array(
                'Designation.add()'
            );
            $data['header'] = array(
                'title' => 'Add Designation',
                'breadcrumb' => array(
                    'Dashboard' => route('my-dashboard'),
                    'Designation List' => 'Designation List',
                )
            );
            return view('backend.pages.designation.add', $data);
        }else{
            return redirect()->route('admin.designation.list');
        }
    }

    public function saveAdd(Request $request)
    {
        $objDesignation = new Designation();
        $result = $objDesignation->saveAdd($request->all());
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Designation details successfully added.';
            $return['redirect'] = route('admin.designation.list');
        }  elseif ($result == "designation_name_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Designation has already exists.';
        } else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function edit($designationId)
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(39, explode(',', $permission_array[0]['permission']))){
            $objDesignation = new Designation();
            $data['user_details'] = $objDesignation->get_designation_details($designationId);

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Edit Designation";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Edit Designation";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Edit Designation";
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array();
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'validate/jquery.validate.min.js',
            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'designation.js',
            );
            $data['funinit'] = array(
                'Designation.edit()'
            );
            $data['header'] = array(
                'title' => 'Edit designation',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Admin users' => route('admin.designation.list'),
                    'Edit admin users' => 'Edit admin users',
                )
            );
            return view('backend.pages.designation.edit', $data);
        }else{
            return redirect()->route('admin.designation.list');
        }
    }

    public function saveEdit(Request $request)
    {
        $objDesignation = new Designation();
        $result = $objDesignation->saveEdit($request->all());
        if ($result == "updated") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Designation details successfully added.';
            $return['redirect'] = route('admin.designation.list');
        }  elseif ($result == "designation_name_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Designation has already exists.';
        } else{
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
                $objDesignation = new Designation();
                $list = $objDesignation->getdatatable();
                echo json_encode($list);
                break;

            case 'common-activity':
                $objDesignation = new Designation();
                $data = $request->input('data');
                $result = $objDesignation->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if ($data['activity'] == 'delete-records') {
                        $return['message'] = "Designation details successfully deleted.";
                    } elseif ($data['activity'] == 'active-records') {
                        $return['message'] = "Designation details successfully actived.";
                    } else {
                        $return['message'] = "Designation details successfully deactived.";
                    }
                    $return['redirect'] = route('admin.designation.list');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'It seems like something is wrong';;
                }

                echo json_encode($return);
                exit;
        }
    }
    public function save_import(Request $request){


        $path = $request->file('file')->store('temp');
        $data = \Excel::import(new DesignationImport($request->file('file')),$path);
        $return['status'] = 'success';
        $return['message'] = 'Designation added successfully.';
        $return['redirect'] = route('admin.designation.list');

        echo json_encode($return);
        exit;
    }
}

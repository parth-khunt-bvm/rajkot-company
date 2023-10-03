<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Imports\BranchImport;
use Config;
use Excel;

class BranchController extends Controller
{
    function __construct()
    {
            $this->middleware('admin');
    }

    public function list(Request $request){

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Branch List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Branch List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Branch List';
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
            'branch.js',
        );
        $data['funinit'] = array(
            'Branch.init()'
        );
        $data['header'] = array(
            'title' => 'Branch List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Branch List' => 'Branch List',
            )
        );
        return view('backend.pages.branch.list', $data);
    }

    public function add (){
        $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Branch";
        $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Branch";
        $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Branch";
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
            'branch.js',
        );
        $data['funinit'] = array(
            'Branch.add()'
        );
        $data['header'] = array(
            'title' => 'Add Branch',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Branch List' => route('admin.branch.list'),
                'Add Branch' => 'Add Branch',
            )
        );
        return view('backend.pages.branch.add', $data);
    }

    public function saveAdd(Request $request){
        $objBranch = new Branch();
        $result = $objBranch->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Branch details successfully added.';
            $return['redirect'] = route('admin.branch.list');
        } elseif ($result == "branch_name_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Branch has already exists.';
        }  else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function edit ($branchId){

        $objBranch = new Branch();
        $data['branch_details'] = $objBranch->get_branch_details($branchId);
        $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Branch";
        $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Branch";
        $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Branch";
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
            'branch.js',
        );
        $data['funinit'] = array(
            'Branch.edit()'
        );
        $data['header'] = array(
            'title' => 'Edit Branch',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Branch List' => route('admin.branch.list'),
                'Edit Branch' => 'Edit Branch',
            )
        );
        return view('backend.pages.branch.edit', $data);
    }

    public function saveEdit(Request $request){
        $objBranch = new Branch();
        $result = $objBranch->saveEdit($request);
        if ($result == "updated") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Branch details successfully updated.';
            $return['redirect'] = route('admin.branch.list');
        } elseif ($result == "branch_name_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Branch has already exists.';
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
                $objBranch = new Branch();
                $list = $objBranch->getdatatable();

                echo json_encode($list);
                break;

            case 'common-activity':
                $objBranch = new Branch();
                $data = $request->input('data');
                $result = $objBranch->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if($data['activity'] == 'delete-records'){
                        $return['message'] = 'Branch details successfully deleted.';;
                    }elseif($data['activity'] == 'active-records'){
                        $return['message'] = 'Branch details successfully actived.';;
                    }else{
                        $return['message'] = 'Branch details successfully deactived.';;
                    }
                    $return['redirect'] = route('admin.branch.list');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'It seems like something is wrong';;
                }

                echo json_encode($return);
                exit;
        }
    }

    public function import(){
        $data['title'] = Config::get('constants.PROJECT_NAME') . ' ||Import Branch';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' ||Import Branch';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Import List';
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'validate/jquery.validate.min.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'branch.js',
        );
        $data['funinit'] = array(
            'Branch.import()'
        );
        $data['header'] = array(
            'title' => 'Import Branch',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Branch List' => route('admin.branch.list'),
                'Import Branch' => 'Import Branch',
            )
        );
        return view('backend.pages.branch.import', $data);
    }

    public function save_import(Request $request){
        $path = $request->file('file')->store('temp');
        $data = \Excel::import(new BranchImport($request->file('file')),$path);
        $return['status'] = 'success';
        $return['message'] = 'Branch added successfully.';
        $return['redirect'] = route('admin.branch.list');

        echo json_encode($return);
        exit;
    }
}

<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Imports\TypeImport;
use App\Models\Type;
use Illuminate\Http\Request;
use Config;

class TypeController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function list(Request $request){

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Type List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Type List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Type List';
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
            'type.js',
        );
        $data['funinit'] = array(
            'Type.init()'
        );
        $data['header'] = array(
            'title' => 'Type List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Type List' => 'Type List',
            )
        );
        return view('backend.pages.type.list', $data);
    }

    public function add (){
        $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Type";
        $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Type";
        $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Type";
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
            'type.js',
        );
        $data['funinit'] = array(
            'Type.add()'
        );
        $data['header'] = array(
            'title' => 'Add Type',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Type List' => route('admin.type.list'),
                'Add Type' => 'Add Type',
            )
        );
        return view('backend.pages.type.add', $data);
    }
    public function saveAdd(Request $request){
        $objType = new Type();
        $result = $objType->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Type details successfully added.';
            $return['redirect'] = route('admin.type.list');
        } elseif ($result == "type_name_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Type has already exists.';
        }  else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function edit ($typeId){

        $objType = new Type();
        $data['type_details'] = $objType->get_type_details($typeId);
        $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Type";
        $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Type";
        $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Type";
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
            'type.js',
        );
        $data['funinit'] = array(
            'Type.edit()'
        );
        $data['header'] = array(
            'title' => 'Edit Type',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'type List' => route('admin.type.list'),
                'Edit type' => 'Edit Type',
            )
        );
        return view('backend.pages.type.edit', $data);
    }

    public function saveEdit(Request $request){
        $objType = new Type();
        $result = $objType->saveEdit($request);
        if ($result == "updated") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Type details successfully updated.';
            $return['redirect'] = route('admin.type.list');
        } elseif ($result == "type_name_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Type has already exists.';
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
                $objType = new Type();
                $list = $objType->getdatatable();

                echo json_encode($list);
                break;

            case 'common-activity':
                $objType = new Type();
                $data = $request->input('data');
                $result = $objType->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if($data['activity'] == 'delete-records'){
                        $return['message'] = 'Type details successfully deleted.';;
                    }elseif($data['activity'] == 'active-records'){
                        $return['message'] = 'Type details successfully actived.';;
                    }else{
                        $return['message'] = 'Type details successfully deactived.';;
                    }
                    $return['redirect'] = route('admin.type.list');
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
        $data = \Excel::import(new TypeImport($request->file('file')),$path);
        $return['status'] = 'success';
        $return['message'] = 'Type added successfully.';
        $return['redirect'] = route('admin.type.list');

        echo json_encode($return);
        exit;
    }
}

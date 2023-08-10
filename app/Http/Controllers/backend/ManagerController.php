<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manager;
use Config;

class ManagerController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function list(Request $request){

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Manager List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Manager List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Manager List';
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
            'plugins/custom/datatables/datatables.bundle.css'
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'plugins/custom/datatables/datatables.bundle.js',
            'pages/crud/datatables/data-sources/html.js'
        );
        $data['js'] = array(
            'comman_function.js',
            'manager.js',
        );
        $data['funinit'] = array(
            'Manager.init()'
        );
        $data['header'] = array(
            'title' => 'Manager List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Manager List' => 'Manager List',
            )
        );
        return view('backend.pages.manager.list', $data);

    }

    public function add (){
        $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Manager List";
        $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Manager List";
        $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Manager List";
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
            'manager.js',
        );
        $data['funinit'] = array(
            'Manager.add()'
        );
        $data['header'] = array(
            'title' => 'Add Manager',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Manager List' => 'Manager List',
            )
        );
        return view('backend.pages.manager.add', $data);
    }

    public function saveAdd(Request $request){
        $objManager = new Manager();
        $result = $objManager->saveAdd($request->all());
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Manager details successfully added.';
            $return['redirect'] = route('admin.manager.list');
        }  elseif ($result == "manager_name_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Manager has already exists.';
        } else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function edit($managerId){
        $objManager = new Manager();
        $data['manager_details'] = $objManager->get_manager_details($managerId);

        $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Manager";
        $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Manager";
        $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Manager";
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
            'manager.js',
        );
        $data['funinit'] = array(
            'Manager.edit()'
        );
        $data['header'] = array(
            'title' => 'Edit manager',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Managers' => route('admin.manager.list'),
                'Edit Managers' => 'Edit Managers',
            )
        );
        return view('backend.pages.manager.edit', $data);
    }

    public function saveEdit(Request $request){
        $objManager = new Manager();
        $result = $objManager->saveEdit($request->all());
        if ($result == "updated") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Manager details successfully updated.';
            $return['redirect'] = route('admin.manager.list');
        } elseif ($result == "manager_name_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Manager has already exists.';
        } else{
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
                $objManager = new Manager();
                $list = $objManager->getdatatable();

                echo json_encode($list);
                break;



            case 'common-activity':
                $objManager = new Manager();
                $data = $request->input('data');
                $result = $objManager->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if($data['activity'] == 'delete-records'){
                        $return['message'] = "Manager's details successfully deleted.";
                    }elseif($data['activity'] == 'active-records'){
                        $return['message'] = "Manager's details successfully actived.";
                    }else{
                        $return['message'] = "Manager's details successfully deactived.";
                    }
                    $return['redirect'] = route('admin.manager.list');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'It seems like something is wrong';;
                }

                echo json_encode($return);
                exit;
        }
    }
}

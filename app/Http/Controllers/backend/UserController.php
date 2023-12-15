<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Config;

class UserController extends Controller
{
    public function list(){

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || User List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || User List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || User List';
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
            'user.js',
        );
        $data['funinit'] = array(
            'User.init()',
        );
        $data['header'] = array(
            'title' => 'User List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'User List' => 'User List',
            )
        );
        return view('backend.pages.user.user.list', $data);

    }

    public function add(){

        $objTechnology = new UserRole();
        $data['userRole'] = $objTechnology->get_admin_user_role_details();

        $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add User";
        $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add User";
        $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add User";
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
            'user.js',
        );
        $data['funinit'] = array(
            'User.add()'
        );
        $data['header'] = array(
            'title' => 'Add User',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'User List' => route('admin.user.list'),
                'Add User' => 'Add User',
            )
        );
        return view('backend.pages.user.user.add', $data);
    }

    public function saveAdd(Request $request){
        $objUser = new User();
        $result = $objUser->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'User details successfully added.';
            $return['redirect'] = route('admin.user.list');
        } elseif ($result == "user_name_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'User has already exists.';
        }  else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function edit ($userId){

        $objTechnology = new UserRole();
        $data['userRole'] = $objTechnology->get_admin_user_role_details();

        $objUser = new User();
        $data['user_detail'] = $objUser->get_user_details($userId);
        $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit User ";
        $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit User ";
        $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit User ";
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
            'user.js',
        );
        $data['funinit'] = array(
            'User.edit()'
        );
        $data['header'] = array(
            'title' => 'Edit User',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'User List' => route('admin.user.list'),
                'Edit User' => 'Edit User',
            )
        );
        return view('backend.pages.user.user.edit', $data);
    }

    public function saveEdit(Request $request){
        $objUser = new User();
        $result = $objUser->saveEdit($request);
        if ($result == "updated") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'User details successfully updated.';
            $return['redirect'] = route('admin.user.list');
        } elseif ($result == "user_name_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'User has already exists.';
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
                $objUser = new User();
                $list = $objUser->getdatatable($request->input('action'));

                echo json_encode($list);
                break;

                case 'common-activity':
                    $objUser = new User();
                    $data = $request->input('data');
                    $result = $objUser->common_activity($data);
                    if ($result) {
                        $return['status'] = 'success';
                        if($data['activity'] == 'delete-records'){
                            $return['message'] = 'User details successfully deleted.';;
                        }elseif($data['activity'] == 'active-records'){
                            $return['message'] = 'User details successfully actived.';;
                        }else{
                            $return['message'] = 'User details successfully deactived.';;
                        }
                        $return['redirect'] = route('admin.user.list');
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

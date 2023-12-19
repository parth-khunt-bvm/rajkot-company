<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Imports\UserRoleImport;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Config;

class UserroleController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function list(){

        $data['title'] =  Config::get('constants.SYSTEM_NAME') . ' || ' .trans('configuration.user_role_list');
        $data['description'] =  Config::get('constants.SYSTEM_NAME') . ' || ' .trans('configuration.user_role_list');
        $data['keywords'] =  Config::get('constants.SYSTEM_NAME') . ' || ' .trans('configuration.user_role_list');
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
            'user_role.js',
        );
        $data['funinit'] = array(
            'UserRole.init()',
            'UserRole.add()'
        );
        $data['header'] = array(
            'title' => 'User Role',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'User Role' => 'User Role',
            )
        );
        return view('backend.pages.user.user_role.list', $data);
    }
    public function add (){
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(7, explode(',', $permission_array[0]['permission']))){
            $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add User Role";
            $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add User Role";
            $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add User Role";
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
                'user_role.js',
            );
            $data['funinit'] = array(
                'UserRole.add()'
            );
            $data['header'] = array(
                'title' => 'Add User Role',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'User Role List' => route('admin.user-role.list'),
                    'Add User Role' => 'Add User Role',
                )
            );
            return view('backend.pages.user.user_role.add', $data);
        }else{
            return redirect()->route('admin.user-role.list');
        }
    }

    public function saveAdd(Request $request){
        $objUserRole = new UserRole();
        $result = $objUserRole->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'User Role details successfully added.';
            $return['redirect'] = route('admin.user-role.list');
        } elseif ($result == "user_role_name_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'User Role has already exists.';
        }  else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function edit ($userRoleId){
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(8, explode(',', $permission_array[0]['permission']))){

            $objUserRole = new UserRole();
            $data['user_role_details'] = $objUserRole->get_user_role_details($userRoleId);

            $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit User Role";
            $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit User Role";
            $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit User Role";
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
                'user_role.js',
            );
            $data['funinit'] = array(
                'UserRole.edit()'
            );
            $data['header'] = array(
                'title' => 'Edit User Role',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'User Role List' => route('admin.user-role.list'),
                    'Edit User Role' => 'Edit User Role',
                )
            );
            return view('backend.pages.user.user_role.edit', $data);
        }else{
            return redirect()->route('admin.user-role.list');
        }
    }

    public function saveEdit(Request $request){
        $objUserRole = new UserRole();
        $result = $objUserRole->saveEdit($request);
        if ($result == "updated") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'User Role details details successfully updated.';
            $return['redirect'] = route('admin.user-role.list');
        } elseif ($result == "user_role_name_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'User Role details has already exists.';
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
                $objUserRole = new UserRole();
                $list = $objUserRole->getdatatable();

                echo json_encode($list);
                break;

            case 'common-activity':
                $objUserRole = new UserRole();
                $data = $request->input('data');
                $result = $objUserRole->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if($data['activity'] == 'delete-records'){
                        $return['message'] = 'User Role details successfully deleted.';;
                    }elseif($data['activity'] == 'active-records'){
                        $return['message'] = 'User Role details successfully actived.';;
                    }else{
                        $return['message'] = 'User Role details successfully deactived.';;
                    }
                    $return['redirect'] = route('admin.user-role.list');
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
        $data = \Excel::import(new UserRoleImport($request->file('file')),$path);
        $return['status'] = 'success';
        $return['message'] = 'User Role added successfully.';
        $return['redirect'] = route('admin.user-role.list');

        echo json_encode($return);
        exit;
    }

    public function view($id){
        // $userId = Auth()->guard('admin')->user()->user_type;
        // $permission_array = get_users_permission($userId);

        // if(in_array(11, explode(',', $permission_array[0]['permission']))){

            $objUserRole = new UserRole();
            $data['user_roles'] = $objUserRole->get_user_permission_details($id);

            $data['user_role_id'] = $id;
            $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || View User Role";
            $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || View User Role";
            $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || View User Role";
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
                'user_role.js',
            );
            $data['funinit'] = array(
                'UserRole.view()'
            );
            $data['header'] = array(
                'title' => 'View User Roles',
                'breadcrumb' => array(
                    'Dashboard' => route('my-dashboard'),
                    'Users Role List' => route('admin.user-role.list'),
                    'View User Roles' => 'View Users Roles',
                )
            );
            return view('backend.pages.user.user_role.view', $data);
        // }else{
        //     return redirect()->route('admin.user-role.list');
        // }
    }

    public function permission(Request $request){

            $objUserroles = new UserRole();
            $res = $objUserroles->save_user_roles_permissions($request);
            if ($res) {
                $return['status'] = 'success';
                $return['message'] = 'User roles permission successfully updated.';
                $return['jscode'] = '$("#loader").hide();';
                $return['redirect'] = route('admin.user-role.list');
            }else{
                $return['status'] = 'error';
                $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'Something goes to wrong';
            }
            echo json_encode($return);
            exit;
    }
}

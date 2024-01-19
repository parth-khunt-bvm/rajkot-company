<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Config;
use Auth;
use Session;

class EmployeeLoginController extends Controller
{
    public function login(){
        $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Employee Login";
        $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Employee Login";
        $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Employee Login";

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
            'employee_login.js',
        );
        $data['funinit'] = array(
            'EmployeeLogin.init()'
        );

        return view('backend.pages.employee_login', $data);
    }

    public function auth_employee_login(Request $request){

        if (Auth::guard('employee')->attempt(['gmail' => $request->input('emp_email'), 'password' => $request->input('emp_password'), 'is_deleted'=>'N', 'status'=>'W']) ) {
            $loginData = array(
                'first_name' => Auth::guard('employee')->user()->first_name,
                'last_name' => Auth::guard('employee')->user()->last_name,
                'gmail' => Auth::guard('employee')->user()->email,
                // 'userimage' => Auth::guard('employee')->user()->userimage,
                // 'usertype' => Auth::guard('employee')->user()->user_type,
                'id' => Auth::guard('employee')->user()->id
            );


            Session::push('logindata', $loginData);
            // setcookie("branch", "", time() - 3600, "/");
            // setcookie("branch", "all", time() + (86400 * 30), "/"); // 86400 = 1 day
            $return['status'] = 'success';
            $return['message'] = 'You have successfully logged in.';
            $return['redirect'] = route('my-dashboard.index');
        } else {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Invalid Login Id/Password';
        }
        return json_encode($return);
        exit();
    }

    public function employeeLogout(Request $request) {
        $this->resetGuard();
        $request->session()->forget('logindata');
        return redirect()->route('my-login');
    }

    public function resetGuard() {
        Auth::logout();
        Auth::guard('employee')->logout();
        Auth::guard('admin')->logout();
    }

}

<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Employees;
use Illuminate\Http\Request;
use Config;


class EmployeeDashboardController extends Controller
{
    function __construct()
    {
        $this->middleware('employee');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['date'] =  date_formate(date("Y-m-d"));
        $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || My Dashboard";
        $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || My Dashboard";
        $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || My Dashboard";
        $data['css'] = array(
        );
        $data['plugincss'] = array(
            'plugins/custom/datatables/datatables.bundle.css'
        );
        $data['pluginjs'] = array(
            'plugins/custom/datatables/datatables.bundle.js',
            'pages/crud/datatables/data-sources/html.js',
        );
        $data['js'] = array(
            'dashboard.js',
            'jquery.form.min.js',
            'comman_function.js',
        );
        $data['funinit'] = array(
        );
        $data['header'] = array(
            'title' => 'Dashboard',
            'breadcrumb' => array(
                'My Dashboard' => 'My Dashboard',
            )
        );
        return view('backend.employee.pages.dashboard.dashboard', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function editProfile(){
        $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Profile";
        $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Profile";
        $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Profile";
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'validate/jquery.validate.min.js',
            'pages/crud/file-upload/image-input.js'
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'dashboard.js',
        );
        $data['funinit'] = array(
            'Dashboard.edit_profile()'
        );
        $data['header'] = array(
            'title' => 'Edit Profile',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Edit Profile' => 'Edit Profile',
            )
        );
        return view('backend.employee.pages.dashboard.editProfile', $data);
    }
    public function saveProfile(Request $request){
        $objEmployee = new Employees();
        $result = $objEmployee->saveProfile($request);
        if ($result == "true") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Your profile successfully updated.';
            $return['redirect'] = route('employee.edit-profile');
        } else {
            if ($result == "email_exist") {
                $return['status'] = 'error';
                 $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'The email address has already been registered.';
            }else{
                $return['status'] = 'error';
                 $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'Something goes to wrong';
            }
        }
        echo json_encode($return);
        exit;
    }

    public function change_password(Request $request){
        $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Profile";
        $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Profile";
        $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Profile";
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'validate/jquery.validate.min.js',
            'pages/crud/file-upload/image-input.js'
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'employee_dashboard.js',
        );
        $data['funinit'] = array(
            'EmployeeDashboard.change_password()'
        );
        $data['header'] = array(
            'title' => 'Change Password',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard.index'),
                'Change Password' => 'Change Password',
            )
        );
        return view('backend.employee.pages.dashboard.change_password', $data);
    }

    public function save_password(Request $request){
        $objUsers = new Employees();
        $result = $objUsers->changepassword($request);

        if ($result == "true") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Your password has been updated successfully.';
            $return['redirect'] = route('employee.change-password');
        } else {
            if ($result == "password_not_match") {
                $return['status'] = 'warning';
                $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'Your old password is not match.';

                $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';

            }else{
                $return['status'] = 'error';
                $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'Something goes to wrong';
            }
        }
        echo json_encode($return);
        exit;
    }
}

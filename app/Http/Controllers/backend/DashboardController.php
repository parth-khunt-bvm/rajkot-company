<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\EmployeeBirthday;
use App\Models\EmployeeBondLastDate;
use App\Models\SocialMediaPost;
use Illuminate\Http\Request;
use Config;
use App\Models\Users;
use DB;

class DashboardController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function myDashboard (){

        $objEmployee = new Attendance();
        $data['employee'] = $objEmployee->get_admin_attendance_daily_detail();

        $data['employees'] = EmployeeBirthday::from('employee')
        ->join("technology", "technology.id", "=", "employee.department")
        ->join("designation", "designation.id", "=", "employee.designation")
        ->join("branch", "branch.id", "=", "employee.branch")
        ->select('employee.id', 'employee.first_name', 'employee.last_name', 'employee.employee_image', 'technology.technology_name', 'employee.DOB', 'designation.designation_name')
        ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
        ->where("employee.is_deleted", "=", "N")
        ->where("employee.status", "=", "W")
        ->whereBetween(DB::raw('DATE_FORMAT(employee.DOB, "%m-%d")'), array(date("m-d", strtotime(today())), date("m-d", strtotime(today()->endOfMonth()))))
        ->orderBy(DB::raw('DATE_FORMAT(employee.DOB, "%m-%d")'))
        ->get();

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
            'Dashboard.employee_birthday()',
            'Dashboard.employee_bond_last_date()',
            'Dashboard.absent_employee_list()',
            'Dashboard.social_media_post_list()',
        );
        $data['header'] = array(
            'title' => 'Dashboard',
            'breadcrumb' => array(
                'My Dashboard' => 'My Dashboard',
            )
        );
        return view('backend.pages.dashboard.dashboard', $data);
    }

    public function editProfile (){
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
        return view('backend.pages.dashboard.editProfile', $data);
    }

    public function saveProfile(Request $request){
        $objUsers = new Users();
        $result = $objUsers->saveProfile($request);
        if ($result == "true") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Your profile successfully updated.';
            $return['redirect'] = route('edit-profile');
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
            'dashboard.js',
        );
        $data['funinit'] = array(
            'Dashboard.change_password()'
        );
        $data['header'] = array(
            'title' => 'Change Password',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Change Password' => 'Change Password',
            )
        );
        return view('backend.pages.dashboard.change_password', $data);
    }

    public function save_password(Request $request){
        $objUsers = new Users();
        $result = $objUsers->changepassword($request);

        if ($result == "true") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Your password has been updated successfully.';
            $return['redirect'] = route('change-password');
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

    public function ajaxcall(Request $request)
    {
        $action = $request->input('action');
        switch ($action) {
            case 'employees-birthday-list':
                $objEmployeeBirthday = new EmployeeBirthday();
                $list = $objEmployeeBirthday->employeeBirthdayList();
                echo json_encode($list);
                break;

            case 'employees-bond-last-date-list':
                $obEmployeeBondLastDate = new EmployeeBondLastDate();
                $list = $obEmployeeBondLastDate->employeeBondLastDateList();
                echo json_encode($list);
                break;

            case 'absent-emp-list':
                $objTodayAttendance = new Attendance();
                $list = $objTodayAttendance->getAbsentEmpList();
                echo json_encode($list);
                break;

            case 'social-media-post-list':
                $objSocialMediaPost = new SocialMediaPost();
                $list = $objSocialMediaPost->getSocialMediaPostList();
                echo json_encode($list);
                break;
        }
    }
}

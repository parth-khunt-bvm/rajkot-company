<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\Technology;
use Illuminate\Http\Request;
use Config;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }
    public function list(Request $request){

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Attendance List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Attendance List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Attendance List';
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
            'plugins/custom/datatables/datatables.bundle.css',
            'plugins/custom/fullcalendar/fullcalendar.bundle.css',
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'plugins/custom/datatables/datatables.bundle.js',
            'pages/crud/datatables/data-sources/html.js',
            'validate/jquery.validate.min.js',
            'plugins/custom/fullcalendar/fullcalendar.bundle.js',
            'pages/crud/forms/widgets/select2.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'attendance.js',
        );
        $data['funinit'] = array(
            'Attendance.init()',
        );
        $data['header'] = array(
            'title' => 'Attendance List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Attendance List' => 'Attendance List',
            )
        );
        return view('backend.pages.attendance.list', $data);
    }



    public function dayList(Request $request){

        $data['date'] = $request->date;
        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Attendance list';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Attendance list';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Attendance list';
        $data['css'] = array(
            'toastr/toastr.min.css',
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
            'attendance.js',
        );
        $data['funinit'] = array(
            'Attendance.list()'
        );
        $data['header'] = array(
            'title' => 'Attendance list',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Attendance list' => 'Attendance list',
            )
        );
        return view('backend.pages.attendance.attendance_day_list', $data);
    }
    public function add (){

        $objEmployee = new Employee();
        $data['employee'] = $objEmployee->get_admin_employee_details();

        $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Attendance";
        $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Attendance";
        $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Attendance";
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
            'attendance.js',
        );
        $data['funinit'] = array(
            'Attendance.add()'
        );
        $data['header'] = array(
            'title' => 'Add Attendance',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Attendance List' => route('admin.attendance.list'),
                'Add Attendance' => 'Add Attendance',
            )
        );
        return view('backend.pages.attendance.add', $data);
    }
    public function saveAdd(Request $request){
        $objAttendance = new Attendance();
        $result = $objAttendance->saveAdd($request);

        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Employee Attendance details successfully added.';
            $return['redirect'] = route('admin.attendance.list');
        } elseif ($result == "attendance_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Employee Attendance has already exists.';
        }  else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }
    public function dayEdit($editId)
    {
        $objEmployee = new Employee();
        $data['employee'] = $objEmployee->get_admin_employee_details();

        $attendance = new Attendance();
        $data['attendance_details'] = $attendance->get_attendance_details($editId);

        $data['title'] = Config::get('constants.PROJECT_NAME') . " || Edit Attendance";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || Edit Attendance";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Edit Attendance";
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'pages/crud/forms/widgets/select2.js',
            'validate/jquery.validate.min.js',
            'pages/crud/file-upload/image-input.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'attendance.js',
        );
        $data['funinit'] = array(
            'Attendance.edit()'
        );
        $data['header'] = array(
            'title' => 'Edit Attendance',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Attendance List' => route('admin.attendance.day-list'),
                'Edit Attendance' => 'Edit Attendance',
            )
        );
        return view('backend.pages.attendance.attendance_day_edit', $data);
    }
    public function daySaveEdit(Request $request){
        $data['date'] = $request->date;
        $objAttendance = new Attendance();
        $result = $objAttendance->daySaveEdit($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Attendance details successfully updated.';
            $return['redirect'] = route('admin.attendance.day-list',['date'=>$data['date']]);
        } elseif ($result == "Attendance_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Attendance has already exists.';
        } else {
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
            case 'get_employee_list':
                $data = $request->input('data');
                $objEmployee = new Employee();
                $data['employeeList'] = $objEmployee->get_admin_employee_details(json_decode($data['employee']));
                $details =  view('backend.pages.attendance.addEmployee', $data);
                echo $details;
                break;

            case 'getdatatable':
                $objAttendance = new Attendance();
                $list = $objAttendance->getdatatable($request->input('data'));
                echo json_encode($list);
                break;

            case 'get_attendance_list':
                $objAttendance = new Attendance();
                $list = $objAttendance->get_admin_attendance_details($request->input('data'));
                echo json_encode($list);
                break;

            case 'get_attendance_list_by_day';
                $data = $request->input('data');
                $objAttendance = new Attendance();
                $list = $objAttendance->get_admin_attendance_details_by_day($request->input('data'));
                $details =  view('backend.pages.attendance.attendance_day_list');
                echo $details;
                break;
        }

    }
}

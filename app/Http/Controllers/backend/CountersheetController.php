<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\Countersheet;
use App\Models\Branch;
use App\Models\Technology;
use App\Models\Employee;
use Config;
class CountersheetController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function list(Request $request){
        $objBranch = new Branch();
        $data['branch'] = $objBranch->get_admin_branch_details();

        $objTechnology = new Technology();
        $data['technology'] = $objTechnology->get_admin_technology_details();

        $data['date'] = $request->date;
        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Attendance Report List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Attendance Report List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Attendance Report List';
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
            'countersheet.js',
        );
        $data['funinit'] = array(
            'Countersheet.list()',
            'Countersheet.counterlist_calender()'
        );
        $data['header'] = array(
            'title' => 'Attendance Report List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Attendance Report List' => 'Attendance Report List',
            )
        );
        return view('backend.pages.attendance.report_list', $data);
    }

    public function ajaxcall(Request $request){
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objAttendance = new Countersheet();
                $list = $objAttendance->getdatatable($request->input('data'));
                echo json_encode($list);
                break;

            case 'get_employee_details':
                $inputData = $request->input('data');
                $data = $request->input('data');

                $objAttendance = new Attendance();
                $data['attendanceData'] = $objAttendance->get_attendance_details_by_employee($inputData['userId'],  $inputData['month'], $inputData['year']);

                $objEmployee = new Employee();
                $data['employeeDetails'] = $objEmployee->get_countsheet_detail_by_employee($inputData['userId'],  $inputData['month'], $inputData['year']);

                echo json_encode($data);
                exit;
        }
    }
}

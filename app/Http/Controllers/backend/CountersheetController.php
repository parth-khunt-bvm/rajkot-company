<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\Countersheet;
use App\Models\Branch;
use App\Models\Technology;
use App\Models\Employee;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportAttendance;
use Config;
use PDF;

class CountersheetController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function list(Request $request)
    {
        $data['technology'] = getTechnologyDetails();

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

    public function ajaxcall(Request $request)
    {
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

    public function pdfList(Request $request)
    {
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
        return view('backend.pages.counter_sheet.pdf', $data);
    }

    public function counterSheetPdf(Request $request){
        $technology = $request->input('technology');
        $month = $request->input('month');

        $data['branch'] = $_COOKIE['branch'] == 'all' ? 'All Branch' : [$_COOKIE['branch']];
        if($_COOKIE['branch'] == 'all'){
            $data['branch'] = 'All Branch';
        } else {
            $objBranch = new Branch();
            $branchDetails  = $objBranch->get_branch_details($_COOKIE['branch']);
            $data['branch'] = $branchDetails['branch_name'];
        }

        if($technology == ''){
            $data['technology'] = 'All Technology';
        } else {
            $objTechnology = new Technology();
            $technologyDetails  = $objTechnology->get_technology_details($technology);
            $data['technology'] = $technologyDetails['technology_name'];
        }

        $data['year'] = $request->input('year');
        $data['month'] = date('F', mktime(0, 0, 0, $month, 1));

        $objCounter = new Countersheet();
        $data['counterSheet'] = $objCounter->counterSheetPdf($technology, $month, $data['year']);
        $data['title'] = 'Counter Sheet Report';
        $data ['abbreviation'] = [
            'Emp.' => 'Employee',
            'Dept.' => 'Department',
            'W.D.' => 'Working Days',
            'P.D.' => 'Present Days',
            'A.B.' => 'Absent Days',
            'H.L.' => 'Half Leave',
            'S.L.' => 'Sick Leave',
            'O.T.' => 'Overtime',
            'NOW' => 'Total number of working days',
            'TP' => 'Total Paid Days',
        ];
        $customPaper = [0, 0, 612.00, 792.00];

        $pdf = PDF::loadView('backend.pages.counter_sheet.pdf', $data)->setPaper($customPaper, 'portrait');

        return $pdf->download('Counter-sheet-for - '.$data['branch'].'-'.$data['technology'].' - '.$data['month'].'-'.$data['year'].'.pdf');
    }

    public function counterSheetExcel(Request $request){
        $technology = $request->input('technology');
        $month = $request->input('month');

        $data['branch'] = $_COOKIE['branch'] == 'all' ? 'All Branch' : [$_COOKIE['branch']];

        if($_COOKIE['branch'] == 'all'){
            $data['branch'] = 'All Branch';
        } else {
            $objBranch = new Branch();
            $branchDetails  = $objBranch->get_branch_details($_COOKIE['branch']);
            $data['branch'] = $branchDetails['branch_name'];
        }

        if($technology == ''){
            $data['technology'] = 'All Technology';
        } else {
            $objTechnology = new Technology();
            $technologyDetails  = $objTechnology->get_technology_details($technology);
            $data['technology'] = $technologyDetails['technology_name'];
        }

        $data['year'] = $request->input('year');
        $data['month'] = date('F', mktime(0, 0, 0, $month, 1));

        $data['title'] = 'Counter Sheet Report';
        $data ['abbreviation'] = [
            'Emp.' => 'Employee',
            'Dept.' => 'Department',
            'W.D.' => 'Working Days',
            'P.D.' => 'Present Days',
            'A.B.' => 'Absent Days',
            'H.L.' => 'Half Leave',
            'S.L.' => 'Sick Leave',
            'O.T.' => 'Overtime',
            'NOW' => 'Total number of working days',
            'TP' => 'Total Paid Days',
        ];

        return Excel::download(new ExportAttendance($technology, $month, $data['year']), 'Counter-sheet-for - '.$data['branch'].'-'.$data['technology'].' - '.$data['month'].'-'.$data['year'].'.xlsx');
    }


}

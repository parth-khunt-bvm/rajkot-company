<?php

namespace App\Http\Controllers\backend\employee;

use App\Http\Controllers\Controller;
use App\Models\EmpAttendanceReport;
use Illuminate\Http\Request;
use Config;

class EmpAttendanceReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
     {
         $this->middleware('employee');
     }

    public function index(Request $request)
    {
        $data['date'] = '01-Feb-2024';
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
            'pages/crud/forms/widgets/select2.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'emp_attendance_report.js',
        );
        $data['funinit'] = array(
            'EmpAttendanceReport.init()',
        );
        $data['header'] = array(
            'title' => 'Attendance Report List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Attendance Report List' => 'Attendance Report List',
            )
        );
        return view('backend.employee.pages.attendance.report', $data);
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
        //
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
        //
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

    public function ajaxcall(Request $request)
    {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objEmpAttendanceReport = new EmpAttendanceReport();
                $list = $objEmpAttendanceReport->getdatatable($request->input('data'));
                echo json_encode($list);
                break;

        }
    }
}

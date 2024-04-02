<?php

namespace App\Http\Controllers\backend\employee;

use App\Http\Controllers\Controller;
use App\Models\EmpAttendance;
use Illuminate\Http\Request;
use Config;

class EmpAttendanceController extends Controller
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

    public function index()
    {
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
            'emp_attendance.js',
        );
        $data['funinit'] = array(
            'EmpAttendance.init()',
        );
        $data['header'] = array(
            'title' => 'Attendance List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Attendance List' => 'Attendance List',
            )
        );
        return view('backend.employee.pages.attendance.index', $data);
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


    public function ajaxcall(Request $request){

        $action = $request->input('action');
        switch ($action) {

            case 'get_emp_attendance_list':
                $data = $request->input('data');
                $userId = Auth()->guard('employee')->user()->id;
                $objAttendance = new EmpAttendance();
                $list = $objAttendance->get_attendance_details_by_employee($userId,  $data['month'], $data['year']);
                echo json_encode($list);
                break;
        }
    }
}

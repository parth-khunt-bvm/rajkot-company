<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\AttendanceSetting;
use Illuminate\Http\Request;
use Config;

class AttendanceSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $objAttendanceSetting = new AttendanceSetting();
        $data['attendanceDetails'] = $objAttendanceSetting->get_attendance_details(1);

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Attendance Setting List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Attendance Setting List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Attendance Setting List';
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
            'attendance_setting.js',
        );
        $data['funinit'] = array(
            'AttendanceSetting.add()',
        );
        $data['header'] = array(
            'title' => 'Attendance Setting List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Attendance Setting List' => 'Attendance Setting List',
            )
        );
        return view('backend.pages.attendance_setting.create', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $objAttendanceSetting = new AttendanceSetting();
        $result = $objAttendanceSetting->updateAttendanceSetting($request);

        if ($result) {
            $return['status'] = 'success';
            $return['message'] = 'Attendance Setting updated.';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['redirect'] = route('attendance-settings.index');
        } else {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
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
}

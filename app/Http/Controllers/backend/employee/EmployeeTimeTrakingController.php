<?php

namespace App\Http\Controllers\backend\employee;

use App\Http\Controllers\Controller;
use App\Models\EmployeeTimeTracking;
use Illuminate\Http\Request;
use Config;

class EmployeeTimeTrakingController extends Controller
{
    function __construct()
    {
        $this->middleware('employee');
    }


    public function list()
    {
        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Time Traking';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Time Traking';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Time Traking';
        $data['css'] = array(
            'toastr/toastr.min.css',
        );
        $data['plugincss'] = array(
            'plugins/custom/datatables/datatables.bundle.css'
        );
        $data['pluginjs'] = array(
            'plugins/custom/datatables/datatables.bundle.js',
        );
        $data['js'] = array(
            'emp_time_traking.js',
            'comman_function.js',
        );
        $data['funinit'] = array(
            'EmpTimeTraking.init()',
        );
        $data['header'] = array(
            'title' => 'Time Traking',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Time Traking' => 'Time Traking',
            )
        );
        return view('backend.employee.pages.time_traking.index', $data);
    }

    public function storeStartTime(Request $request)
    {
        $objEmployeeTimeTracking = new EmployeeTimeTracking();
        $result = $objEmployeeTimeTracking->storeStartTime($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Start Time traking details successfully added.';
            $return['redirect'] = route('time-tracking.index');
        } else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;

    }

    public function storeStopTime(Request $request)
    {
        $objEmployeeTimeTracking = new EmployeeTimeTracking();
        $result = $objEmployeeTimeTracking->storeStopTime($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'End time traking details successfully added.';
            $return['redirect'] = route('time-tracking.index');
        } else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function ajaxcall(Request $request)
    {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objEmployeeTimeTracking = new EmployeeTimeTracking();
                $list = $objEmployeeTimeTracking->getdatatable($request->input('data'));
                echo json_encode($list);
                break;
        }
    }
}

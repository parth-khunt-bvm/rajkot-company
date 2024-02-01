<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\AdminLeaveRequest;
use App\Models\LeaveRequest;
use App\Models\Manager;
use Illuminate\Http\Request;
use Config;

class LeaveRequestController extends Controller
{
    public function list()
    {
        $objManager = new Manager();
        $data['manager'] = $objManager->get_admin_manager_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Leave Request List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Leave Request List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Leave Request List';
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
            'admin_leave_request.js',
        );
        $data['funinit'] = array(
            'AdminLeaveRequest.init()',
        );
        $data['header'] = array(
            'title' => 'Leave Request List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard.index'),
                'Leave Request List' => 'Leave Request List',
            )
        );
        return view('backend.pages.leave_request.list', $data);
    }

    public function rejectLeaveReq(Request $request){
        $objLeaveRequest = new AdminLeaveRequest();
        $result = $objLeaveRequest->rejectLeaveReq($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Leave Request details successfully Rejected.';
            $return['redirect'] = route('admin.leave-request.list');
        } elseif ($result == "leave_request_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Leave Request has already exists.';
        } else {
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
                $objAdminLeaveRequest = new AdminLeaveRequest();
                $list = $objAdminLeaveRequest->getdatatable();
                echo json_encode($list);
                break;

            case 'admin-leave-request-view';
            $objAdminLeaveRequest = new AdminLeaveRequest();
            $list = $objAdminLeaveRequest->get_Leave_request_details($request->input('data'));
            echo json_encode($list);
            break;

            case 'common-activity':
                $objAdminLeaveRequest = new AdminLeaveRequest();
                $data = $request->input('data');
                $result = $objAdminLeaveRequest->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if($data['activity'] == 'approved-leave-request'){
                        $return['message'] = 'Leave Request details successfully Approved.';;
                    }
                    $return['redirect'] = route('admin.leave-request.list');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'It seems like something is wrong';;
                }
                echo json_encode($return);
                exit;
        }
    }
}




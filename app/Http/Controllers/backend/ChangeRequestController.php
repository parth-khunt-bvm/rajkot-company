<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ChangeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Config;

class ChangeRequestController extends Controller
{
    public function list()
    {

        $leaveUntilDate = 10; // Change this date as needed
        calculateMonthlySalary($leaveUntilDate);
        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Change Request List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Change Request List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Change Request List';
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
            'change_request.js',
        );
        $data['funinit'] = array(
            'ChangeRequest.init()',
        );
        $data['header'] = array(
            'title' => 'Change Request List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Change Request List' => 'Change Request List',
            )
        );
        return view('backend.pages.change_request.list',$data);
    }

    public function changeReqUpdate(Request $request){
            $objChangeRequest = new ChangeRequest();
            $result = $objChangeRequest->changeReqUpdate($request);
            if ($result == "added") {
                $return['status'] = 'success';
                 $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'Change request details successfully approved.';
                $return['redirect'] = route('admin.change-request.list');
            } else{
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
            case 'getdatatable':
                $objChangeRequest = new ChangeRequest();
                $list = $objChangeRequest->getdatatable();
                echo json_encode($list);
                break;

            case 'change-request-view':
                $inputData = $request->input('data');
                $objChangeRequest = new ChangeRequest();

                $data = $objChangeRequest->get_change_request_details($inputData['id']);

                if (!empty($data) && isset($data[0])) {
                    $oldData = $objChangeRequest->get_employee_old_info_details($inputData['id'], $data[0]['employee_id']);
                    if (!empty($oldData)) {
                        $jsonData = [
                            'changeRequestData' => $data[0]->data,
                            'oldEmployeeData' => $oldData
                        ];
                        echo json_encode($jsonData);
                    }
                }
                break;

            case 'common-activity':
                $objChangeRequest = new ChangeRequest();
                $data = $request->input('data');
                $result = $objChangeRequest->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if($data['activity'] == 'delete-records'){
                        $return['message'] = "Change request details successfully rejected.";
                    }
                    $return['redirect'] = route('admin.change-request.list');
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

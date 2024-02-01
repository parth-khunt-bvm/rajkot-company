<?php

namespace App\Http\Controllers\backend\employee;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\Manager;
use Illuminate\Http\Request;
use Config;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
            'leave_request.js',
        );
        $data['funinit'] = array(
            'LeaveRequest.init()',
            'LeaveRequest.add()'
        );
        $data['header'] = array(
            'title' => 'Leave Request List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard.index'),
                'Leave Request List' => 'Leave Request List',
            )
        );
        return view('backend.employee.pages.leave_request.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $objManager = new Manager();
        $data['manager'] = $objManager->get_admin_manager_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add Leave Request";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add Leave Request";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add Leave Request";
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
            'leave_request.js',
        );
        $data['funinit'] = array(
            'LeaveRequest.add()'
        );
        $data['header'] = array(
            'title' => 'Add Leave Request',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Leave Request List' => route('leave-request.index'),
                'Add Leave Request' => 'Add Leave Request',
            )
        );
        return view('backend.employee.pages.leave_request.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $objLeaveRequest = new LeaveRequest();
        $result = $objLeaveRequest->store($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Leave Request details successfully added.';
            $return['redirect'] = route('leave-request.index');
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

        $objManager = new Manager();
        $data['manager'] = $objManager->get_admin_manager_details();

        $objLeaveRequest = new LeaveRequest();
        $data['Leave_request_details'] = $objLeaveRequest->get_Leave_request_details($id);

        $data['title'] = Config::get('constants.PROJECT_NAME') . " || Edit Leave Request";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || Edit Leave Request";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Edit Leave Request";
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
            'leave_request.js',
        );
        $data['funinit'] = array(
            'LeaveRequest.edit()'
        );
        $data['header'] = array(
            'title' => 'Edit Leave Request',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Leave Request List' => route('leave-request.index'),
                'Edit Leave Request' => 'Edit Leave Request',
            )
        );
        return view('backend.employee.pages.leave_request.edit', $data);
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
        $objLeaveRequest = new LeaveRequest();
        $result = $objLeaveRequest->saveEdit($request);
        if ($result == "updated") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Leave Request details successfully updated.';
            $return['redirect'] = route('leave-request.index');
        } elseif ($result == "leave_request_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Leave Request.index has already exists.';
        }  else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
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
                $objLeaveRequest = new LeaveRequest();
                $list = $objLeaveRequest->getdatatable();
                echo json_encode($list);
                break;

                case 'leave-request-view';
                $objLeaveRequest = new LeaveRequest();
                $list = $objLeaveRequest->get_Leave_request_details($request->input('data'));
                echo json_encode($list);
                break;

                case 'common-activity':
                    $objLeaveRequest = new LeaveRequest();
                    $data = $request->input('data');
                    $result = $objLeaveRequest->common_activity($data);
                    if ($result) {
                        $return['status'] = 'success';
                        if($data['activity'] == 'delete-records'){
                            $return['message'] = 'Leave Request details successfully deleted.';;
                        }
                        $return['redirect'] = route('leave-request.index');
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

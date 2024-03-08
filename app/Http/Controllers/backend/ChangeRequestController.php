<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ChangeRequest;
use Illuminate\Http\Request;
use Config;

class ChangeRequestController extends Controller
{
    public function list()
    {
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

    public function ajaxcall(Request $request){
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objChangeRequest = new ChangeRequest();
                $list = $objChangeRequest->getdatatable();
                echo json_encode($list);
                break;

                // case 'change-request-view';
                // $objChangeRequest = new ChangeRequest();
                // $list = $objChangeRequest->get_change_request_details($request->input('data'));
                // echo json_encode($list);
                // break;

                case 'change-request-view' :
                $objChangeRequest = new ChangeRequest();
                $data = $objChangeRequest->get_change_request_details($request->input('data'));

                echo $data[0]->data;

                // if ($data) {
                //     echo "Employee ID: " . $data->employee_id . "\n";
                //     echo "Data: " . $data->data;
                // } else {
                //     echo "Change request not found.";
                // }

                break;
        }
    }
}

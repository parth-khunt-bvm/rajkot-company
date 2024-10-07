<?php

namespace App\Http\Controllers\backend\employee;

use App\Http\Controllers\Controller;
use App\Models\EmpChangeRequest;
use Illuminate\Http\Request;

class EmpChangeRequestController extends Controller
{
    public function savePersonalInfo(Request $request)
    {

        $objEmpChangeRequest = new EmpChangeRequest();
        $result = $objEmpChangeRequest->savePersonalInfo($request);

        if ($result == "email_exist") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'The email address has already been registered.';
        } else if ($result == "no_change") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = "You don't have made any changes";
        } else if ($result == "change") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = " Change request details successfully added";
            $return['reload'] = true;
        } else if($result = 'change_request_exit'){
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = " Change request details already added";
        }
        echo json_encode($return);
        exit;
    }

    public Function saveBankInfo(Request $request){

        $objEmpChangeRequest = new EmpChangeRequest();
        $result = $objEmpChangeRequest->saveBankInfo($request);

        if ($result == "no_change") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = "You don't have made any changes";
        } else if ($result == "change") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = " Change request details successfully added";
        } else if($result = 'change_request_exit'){
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = " Change request details allready added";
        }
        echo json_encode($return);
        exit;

    }

    public function saveParentInfo(Request $request){

        $objEmpChangeRequest = new EmpChangeRequest();
        $result = $objEmpChangeRequest->saveParentInfo($request);

        if ($result == "no_change") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = "You don't have made any changes";
        } else if ($result == "change") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = " Change request details successfully added";
        } else if($result = 'change_request_exit'){
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = " Change request details allready added";
        }
        echo json_encode($return);
        exit;

    }
}

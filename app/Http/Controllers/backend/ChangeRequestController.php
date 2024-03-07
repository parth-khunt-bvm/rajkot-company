<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ChangeRequest;
use Illuminate\Http\Request;

class ChangeRequestController extends Controller
{
    public function savePersonalInfo(Request $request)
    {

        $objChangeRequest = new ChangeRequest();
        $result = $objChangeRequest->savePersonalInfo($request);

        if ($result == "email_exist") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'The email address has already been registered.';
        } else if ($result == "no_change") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = "you don't have made any changes";
        } else if ($result == "change") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = " Change request details successfully added";
        }
        echo json_encode($return);
        exit;
    }


    public Function saveBankInfo(Request $request){

        $objChangeRequest = new ChangeRequest();
        $result = $objChangeRequest->saveBankInfo($request);

        if ($result == "no_change") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = "you don't have made any changes";
        } else if ($result == "change") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = " Change request details successfully added";
        }
        echo json_encode($return);
        exit;

    }

    public function saveParentInfo(Request $request){

        $objChangeRequest = new ChangeRequest();
        $result = $objChangeRequest->saveParentInfo($request);

        if ($result == "no_change") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = "you don't have made any changes";
        } else if ($result == "change") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = " Change request details successfully added";
        }
        echo json_encode($return);
        exit;

    }
}

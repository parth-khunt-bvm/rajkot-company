<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Config;

class SystemsettingController extends Controller
{
    public function systemColorSetting(Request $request){

            $objCompanyinfo = new CompanyInfo();
            $data['systemDetails'] = $objCompanyinfo->get_system_details(1);

            $data['title'] =  Config::get('constants.PROJECT_NAME') . ' || System Setting';
            $data['description'] =  Config::get('constants.PROJECT_NAME') . ' || System Setting';
            $data['keywords'] = Config::get('constants.PROJECT_NAME') .  ' || System Setting';
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array(
            );
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'validate/jquery.validate.min.js',
                'pages/crud/file-upload/image-input.js'
            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'system.js',
            );
            $data['funinit'] = array(
                'System.init()'
            );
            $data['header'] = array(
                'title' => 'System Setting',
                'breadcrumb' => array(
                    'Dashboard' => route('my-dashboard'),
                    'System Setting' => 'System Setting',
                )
                );
            return view('backend.pages.systemsetting.systemsetting', $data);
    }

    public function saveAdd(Request $request){

        $objCompanyinfo = new CompanyInfo();
        $result = $objCompanyinfo->updateSystemSetting($request);

        if ($result) {
            $return['status'] = 'success';
            $return['message'] = 'System Setting updated.';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['redirect'] = route('system-color-setting');
        } else {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;

    }

}

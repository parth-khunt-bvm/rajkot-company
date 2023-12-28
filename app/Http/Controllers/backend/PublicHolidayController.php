<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\PublicHoliday;
use Illuminate\Http\Request;
use Config;

class PublicHolidayController extends Controller
{
    public function list(Request $request){

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Public Holiday List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Public Holiday List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Public Holiday List';
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
            'public_holiday.js',
        );
        $data['funinit'] = array(
            'PublicHoliday.init()',
            'PublicHoliday.add()'
        );
        $data['header'] = array(
            'title' => 'Public Holiday List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Public Holiday List' => 'Public Holiday List',
            )
        );
        return view('backend.pages.public_holiday.list', $data);
    }

    public function add()
    {
        // $userId = Auth()->guard('admin')->user()->user_type;
        // $permission_array = get_users_permission($userId);

        // if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(112, explode(',', $permission_array[0]['permission']))){

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add Public Holiday";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add Public Holiday";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add Public Holiday";
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
                'public_holiday.js',
            );
            $data['funinit'] = array(
                'PublicHoliday.add()'
            );
            $data['header'] = array(
                'title' => 'Add Public Holiday',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Public Holiday List' => route('admin.public-holiday.list'),
                    'Add Public Holiday' => 'Add Public Holiday',
                )
            );
            return view('backend.pages.public_holiday.add', $data);

        // }else{
        //     return redirect()->route('admin.public-holiday.list');
        // }
    }

    public function saveAdd(Request $request)
    {
        $objPublicHoliday = new PublicHoliday();
        $result = $objPublicHoliday->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Public Holiday details successfully added.';
            $return['redirect'] = route('admin.public-holiday.list');
        } elseif ($result == "public_holiday_name_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Public Holiday has already exists.';
        }  else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function edit ($publicHolidayId){
        // $userId = Auth()->guard('admin')->user()->user_type;
        // $permission_array = get_users_permission($userId);

        // if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(21, explode(',', $permission_array[0]['permission']))){

            $objPublicHoliday = new PublicHoliday();
            $data['public_holiday_details'] = $objPublicHoliday->get_public_holiday_details($publicHolidayId);
            $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Public Holiday";
            $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Public Holiday";
            $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Public Holiday";
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array(
            );
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'pages/crud/forms/widgets/select2.js',
                'validate/jquery.validate.min.js',
            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'public_holiday.js',
            );
            $data['funinit'] = array(
                'PublicHoliday.edit()'
            );
            $data['header'] = array(
                'title' => 'Edit Public Holiday',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Public Holiday List' => route('admin.public-holiday.list'),
                    'Edit Public Holiday' => 'Edit Public Holiday',
                )
            );
            return view('backend.pages.public_holiday.edit', $data);
        // }else{
        //     return redirect()->route('admin.public-holiday.list');
        // }
    }

    public function saveEdit(Request $request){
        $objPublicHoliday = new PublicHoliday();
        $result = $objPublicHoliday->saveEdit($request);
        if ($result == "updated") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Public Holiday details successfully updated.';
            $return['redirect'] = route('admin.public-holiday.list');
        } elseif ($result == "public_holiday_name_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Public Holiday has already exists.';
        }  else{
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
                $objPublicHoliday = new PublicHoliday();
                $list = $objPublicHoliday->getdatatable();
                echo json_encode($list);
                break;

                case 'common-activity':
                    $objPublicHoliday = new PublicHoliday();
                    $data = $request->input('data');
                    $result = $objPublicHoliday->common_activity($data);
                    if ($result) {
                        $return['status'] = 'success';
                        if($data['activity'] == 'delete-records'){
                            $return['message'] = 'Public Holiday details successfully deleted.';
                        }
                        $return['redirect'] = route('admin.public-holiday.list');
                    } else {
                        $return['status'] = 'error';
                        $return['jscode'] = '$("#loader").hide();';
                        $return['message'] = 'It seems like something is wrong';
                    }

                    echo json_encode($return);
                    exit;
        }
    }
}

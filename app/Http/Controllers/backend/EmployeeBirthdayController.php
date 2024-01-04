<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Config;
use App\Models\Technology;
use App\Models\Designation;
use App\Models\EmployeeBirthday;

class EmployeeBirthdayController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function birthDayList(Request $request)
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(95, explode(',', $permission_array[0]['permission']))){
            $objTechnology = new Technology();
            $data['technology'] = $objTechnology->get_admin_technology_details();

            $objDesignation = new Designation();
            $data['designation'] = $objDesignation->get_admin_designation_details();

            $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Employee Birthday list';
            $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Employee Birthday list';
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Employee Birthday list';
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
                'employee_birthday.js',
            );
            $data['funinit'] = array(
                'EmployeeBirthday.init()',
            );
            $data['header'] = array(
                'title' => 'Employee Birthday list',
                'breadcrumb' => array(
                    'Dashboard' => route('my-dashboard'),
                    'Employee Birthday list' => 'Employee Birthday list',
                )
            );
            return view('backend.pages.employee.birthday_list', $data);
        }else{
            return redirect()->route('my-dashboard');
        }
    }

    public function ajaxcall(Request $request)
    {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objEmployeeBirthday = new EmployeeBirthday();
                $list = $objEmployeeBirthday->getdatatable($request->input('data'));
                echo json_encode($list);
                break;
        }
    }
}

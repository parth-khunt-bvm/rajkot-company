<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\EmployeeAssetAllocation;
use Illuminate\Http\Request;

class EmployeeAssetAllocationController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function assetAllocationList(Request $request)
    {
        // $userId = Auth()->guard('admin')->user()->user_type;
        // $permission_array = get_users_permission($userId);

        // if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(95, explode(',', $permission_array[0]['permission']))){

            $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Employee Asset Allocation list';
            $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Employee Asset Allocation list';
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Employee Asset Allocation list';
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
                'employee_asset_allocation.js',
            );
            $data['funinit'] = array(
                'EmployeeAssetAllocation.init()',
            );
            $data['header'] = array(
                'title' => 'Employee Asset Allocation list',
                'breadcrumb' => array(
                    'Dashboard' => route('my-dashboard'),
                    'Employee Asset Allocation list' => 'Employee Asset Allocation list',
                )
            );
            return view('backend.pages.employee.view', $data);
        // }else{
        //     return redirect()->route('my-dashboard');
        // }
    }

    public function ajaxcall(Request $request)
    {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                // $data = $request->input('data');
                // dd();
                $objEmployeeAssetAllocation = new EmployeeAssetAllocation();
                $list = $objEmployeeAssetAllocation->getdatatable($request->input('data'));
                echo json_encode($list);
                break;
        }
    }
}

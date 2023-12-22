<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetAllocation;
use App\Models\AssetMaster;
use App\Models\Employee;
use Illuminate\Http\Request;
use Config;

class AssetAllocationController extends Controller
{
    public function list(Request $request)
    {

        $objAsset = new Asset();
        $data['asset'] = $objAsset->get_admin_asset_details();

        $objEmployee = new Employee();
        $data['employee'] = $objEmployee->get_admin_employee_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Asset Allocation list';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Asset Allocation list';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Asset Allocation list';
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
            'pages/crud/forms/widgets/select2.js',
            'validate/jquery.validate.min.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'asset_allocation.js',
        );
        $data['funinit'] = array(
            'AssetAllocation.init()',
            'AssetAllocation.add()'
        );
        $data['header'] = array(
            'title' => 'Asset Allocation list',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Asset Allocation list' => 'Asset Allocation list',
            )
        );
        return view('backend.pages.asset_allocation.list', $data);

    }

    public function add()
    {
        // $userId = Auth()->guard('admin')->user()->user_type;
        // $permission_array = get_users_permission($userId);

        // if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(112, explode(',', $permission_array[0]['permission']))){

            $objAsset = new AssetMaster();
            $data['asset_master'] = $objAsset->get_admin_asset_master_details();

            $objEmployee = new Employee();
            $data['employee'] = $objEmployee->get_admin_employee_details();

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add Asset Allocation";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add Asset Allocation";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add Asset Allocation";
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
                'asset_allocation.js',
            );
            $data['funinit'] = array(
                'AssetAllocation.add()'
            );
            $data['header'] = array(
                'title' => 'Add Asset Allocation',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Asset Allocation List' => route('admin.asset-allocation.list'),
                    'Add Asset Allocation' => 'Add Asset Allocation',
                )
            );
            return view('backend.pages.asset_allocation.add', $data);

        // }else{
        //     return redirect()->route('admin.assets-master.list');
        // }
    }

    public function saveAdd(Request $request)
    {
        $objAssetAllocation = new AssetAllocation();
        $result = $objAssetAllocation->saveAdd($request->all());
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Assets AssetAllocation details successfully added.';
            $return['redirect'] = route('admin.asset-allocation.list');
        } else {
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
            case 'get_asset_master_list':
                $data = $request->input('data');
                $objAssetMaster = new AssetMaster();
                $data['assetMasterList'] = $objAssetMaster->get_admin_asset_master_details(json_decode($data['assetMaster']));
                $details =  view('backend.pages.asset_allocation.addAsset', $data);
                echo $details;
                break;
        }

    }
}

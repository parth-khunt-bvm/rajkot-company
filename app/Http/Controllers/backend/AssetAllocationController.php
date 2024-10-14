<?php

namespace App\Http\Controllers\backend;

use App\Exports\AssetAllocationExport;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetAllocation;
use App\Models\AssetMaster;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Employee;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Config;

class AssetAllocationController extends Controller
{
    public function list(Request $request)
    {
        $objAsset = new Asset();
        $data['asset'] = $objAsset->get_admin_asset_details();

        $objEmployee = new Employee();
        $data['employee'] = $objEmployee->get_admin_employee_details();

        $objBrand = new Brand();
        $data['brand'] = $objBrand->get_admin_brand_details();

        $objSupplier = new Supplier();
        $data['suppier'] = $objSupplier->get_admin_suplier_details();

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
            'AssetAllocation.add()',
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
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(117, explode(',', $permission_array[0]['permission']))){

            $objAsset = new Asset();
            $data['asset'] = $objAsset->get_admin_asset_details();

            $objEmployee = new Employee();
            $data['employee'] = $objEmployee->get_admin_employee_details();

            $objBranch = new Branch();
            $data['branch'] = $objBranch->get_admin_branch_details();

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

        }else{
            return redirect()->route('admin.asset-allocation.list');
        }
    }

    public function saveAdd(Request $request)
    {
        $objAssetAllocation = new AssetAllocation();
        $result = $objAssetAllocation->saveAdd($request->all());
        if ($result == "updated") {
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

    public function edit ($assetMasterId){

        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(118, explode(',', $permission_array[0]['permission']))){

            $objAsset = new Asset();
            $data['asset'] = $objAsset->get_admin_asset_details();

            $objEmployee = new Employee();
            $data['employee'] = $objEmployee->get_admin_employee_details();

            $objAssetMaster = new AssetMaster();
            $data['asset_master_details'] = $objAssetMaster->get_asset_master_details($assetMasterId);

            $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Asset Allocation";
            $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Asset Allocation";
            $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Asset Allocation";
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
                'asset_allocation.js',
            );
            $data['funinit'] = array(
                'AssetAllocation.edit()'
            );
            $data['header'] = array(
                'title' => 'Edit Asset Allocation',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Asset Allocation List' => route('admin.asset-allocation.list'),
                    'Edit Asset Allocation' => 'Edit Asset Allocation',
                )
            );
            return view('backend.pages.asset_allocation.edit', $data);
        }else{
            return redirect()->route('admin.asset-allocation.list');
        }
    }

    public function saveEdit(Request $request)
    {
        $objAssetAllocation = new AssetAllocation();
        $result = $objAssetAllocation->saveEdit($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Asset Allocation details successfully updated.';
            $return['redirect'] = route('admin.asset-allocation.list');
        } elseif ($result == "asset_allocation_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Asse Allocation has already exists.';
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

            case 'getdatatable':
                    $objBranch = new AssetAllocation();
                    $list = $objBranch->getdatatable($request->input('data'));

                    echo json_encode($list);
                    break;

            case 'get_asset_master_list':
                $data = $request->input('data');

                $objAsset = new Asset();
                $data['assetList'] = $objAsset->get_admin_asset_details();

                $details =  view('backend.pages.asset_allocation.addAsset', $data);
                echo $details;
                break;

            case 'get_asset_list' :
                $data = $request->input();
                $objAsset = new Asset();
                $list = $objAsset->get_asset_list($data['branchId'],$data['assetTypeVal'], json_decode($data['selectedAsset']));
                echo json_encode($list);
                break;

            case 'get_asset_master_list_data' :
                $data = $request->input();
                $objAsset = new Asset();
                $list = $objAsset->get_asset_master_list_data($data['id'], json_decode($data['selecteBranch']));
                echo json_encode($list);
                break;

                case 'common-activity':
                    $AssetAllocation = new AssetAllocation();
                    $data = $request->input('data');
                    $result = $AssetAllocation->common_activity($data);
                    if ($result) {
                        $return['status'] = 'success';
                        if($data['activity'] == 'delete-records'){
                            $return['message'] = 'Asset Allocation details successfully deleted.';;
                        }
                        $return['redirect'] = route('admin.asset-allocation.list');
                    } else {
                        $return['status'] = 'error';
                        $return['jscode'] = '$("#loader").hide();';
                        $return['message'] = 'It seems like something is wrong';;
                    }

                    echo json_encode($return);
                    exit;
            }
        }

        public function assetAllocationExcel(){

            return Excel::download(new AssetAllocationExport(), 'Assets-allocation.xlsx');
        }

    }


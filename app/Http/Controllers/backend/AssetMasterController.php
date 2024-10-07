<?php

namespace App\Http\Controllers\backend;

use App\Exports\AssetMasterExport;
use App\Http\Controllers\Controller;
use App\Models\AssetAllocationHistory;
use Illuminate\Http\Request;
use App\Models\AssetMaster;
use App\Models\Branch;
use App\Models\Supplier;
use Maatwebsite\Excel\Facades\Excel;
use Config;
use App\Models\Brand;
use App\Models\Asset;

class AssetMasterController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function list(Request $request)
    {
        $objSupplier = new Supplier();
        $data['suppier'] = $objSupplier->get_admin_suplier_details();

        $objBrand = new Brand();
        $data['brand'] = $objBrand->get_admin_brand_details();

        $objBranch = new Branch();
        $data['branch'] = $objBranch->get_admin_branch_details();

        $objAsset = new Asset();
        $data['asset'] = $objAsset->get_admin_asset_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Asset Master list';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Asset Master list';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Asset Master list';
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
            'assetmaster.js',
        );
        $data['funinit'] = array(
            'AssetMaster.init()',
            'AssetMaster.add()'
        );
        $data['header'] = array(
            'title' => 'Asset Master List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Asset Master list' => 'Asset Master list',
            )
        );
        return view('backend.pages.assetmaster.list', $data);
    }

    public function add()
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(112, explode(',', $permission_array[0]['permission']))){

            $objSupplier = new Supplier();
            $data['suppier'] = $objSupplier->get_admin_suplier_details();

            $objBrand = new Brand();
            $data['brand'] = $objBrand->get_admin_brand_details();

            $objBranch = new Branch();
            $data['branch'] = $objBranch->get_admin_branch_details();

            $objAsset = new Asset();
            $data['asset'] = $objAsset->get_admin_asset_details();


            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add Asset Master";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add Asset Master";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add Asset Master";
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
                'assetmaster.js',
            );
            $data['funinit'] = array(
                'AssetMaster.add()'
            );
            $data['header'] = array(
                'title' => 'Add Asset Master',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Asset Master List' => route('admin.assets-master.list'),
                    'Add Asset Master' => 'Add Asset Master',
                )
            );
            return view('backend.pages.assetmaster.add', $data);

        }else{
            return redirect()->route('admin.assets-master.list');
        }
    }

    public function saveAdd(Request $request)
    {
        $objAssetMaster = new AssetMaster();
        $result = $objAssetMaster->saveAdd($request->all());
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Assets Master details successfully added.';
            $return['redirect'] = route('admin.assets-master.list');
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

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(114, explode(',', $permission_array[0]['permission']))){

            $objSupplier = new Supplier();
            $data['suppier'] = $objSupplier->get_admin_suplier_details();

            $objBrand = new Brand();
            $data['brand'] = $objBrand->get_admin_brand_details();

            $objBranch = new Branch();
            $data['branch'] = $objBranch->get_admin_branch_details();

            $objAsset = new Asset();
            $data['asset'] = $objAsset->get_admin_asset_details();

            $objAssetMaster = new AssetMaster();
            $data['asset_master_details'] = $objAssetMaster->get_asset_master_details($assetMasterId);
            $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Asset Master";
            $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Asset Master";
            $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Asset Master";
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
                'assetmaster.js',
            );
            $data['funinit'] = array(
                'AssetMaster.edit()'
            );
            $data['header'] = array(
                'title' => 'Edit Asset Master',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Asset Master List' => route('admin.assets-master.list'),
                    'Edit Asset Master' => 'Edit Asset Master',
                )
            );
            return view('backend.pages.assetmaster.edit', $data);
        }else{
            return redirect()->route('admin.assets-master.list');
        }
    }

    public function saveEdit(Request $request)
    {
        $objAssetMaster = new AssetMaster();
        $result = $objAssetMaster->saveEdit($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Asset Master details successfully updated.';
            $return['redirect'] = route('admin.assets-master.list');
        } elseif ($result == "asset_master_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Asse tMaster has already exists.';
        } else {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function view($viewId){
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(113, explode(',', $permission_array[0]['permission']))){
            $objAssetMaster = new AssetMaster();
            $data['asset_master_details'] = $objAssetMaster->get_asset_master_details($viewId);

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || View Asset Master";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || View Asset Master";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || View Asset Master";
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
                'assetmaster.js',
            );
            $data['funinit'] = array(
            );
            $data['header'] = array(
                'title' => 'Basic Detail',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Asset Master List' => route('admin.assets-master.list'),
                    'View Asset Master detail' => 'View Asset Master detail',
                )
            );
            return view('backend.pages.assetmaster.view', $data);
        }else{
            return redirect()->route('admin.assets-master.list');
        }

    }
    public function ajaxcall(Request $request)
    {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objAssetMaster = new AssetMaster();
                $list = $objAssetMaster->getdatatable($request->input('data'));
                echo json_encode($list);
                break;

            case 'get-asset-master-trash':
                $objAssetMaster = new AssetMaster();
                $list = $objAssetMaster->getAssetMasterDatatable($request->input('data'));
                echo json_encode($list);
                break;

            case 'asset-master-view';
                $objAssetMaster = new AssetMaster();
                $list = $objAssetMaster->get_asset_master_details_view($request->input('data'));
                echo json_encode($list);
                break;

            case 'common-activity':
                $data = $request->input('data');
                $objAssetMaster = new AssetMaster();
                $result = $objAssetMaster->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if ($data['activity'] == 'delete-records') {
                        $return['message'] = "Assets details successfully deleted.";
                        $return['redirect'] = route('admin.assets-master.list');
                    }else if($data['activity'] == 'restore-records'){
                        $return['message'] = "Assets details successfully restore.";
                        $return['redirect'] = route('admin.asset-master.deleted');
                    }
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'It seems like something is wrong';;
                }

                echo json_encode($return);
                exit;
        }
    }

    public function showDeletedData(Request $request)
    {
        $objSupplier = new Supplier();
        $data['suppier'] = $objSupplier->get_admin_suplier_details();

        $objBrand = new Brand();
        $data['brand'] = $objBrand->get_admin_brand_details();

        $objBranch = new Branch();
        $data['branch'] = $objBranch->get_admin_branch_details();

        $objAsset = new Asset();
        $data['asset'] = $objAsset->get_admin_asset_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Asset Master Deleted list';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Asset Master Deleted list';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Asset Master Deleted list';
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
            'assetmaster.js',
        );
        $data['funinit'] = array(
            'AssetMaster.trash_init()',
        );
        $data['header'] = array(
            'title' => 'Asset Master Deleted List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'AssetMaster Deleted list' => 'Asset Master Deleted list',
            )
        );
        return view('backend.pages.assetmaster.trash', $data);
    }

}

<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use Config;

class AssetController extends Controller
{
    public function list(Request $request)
    {
        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Assets List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Assets List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Assets List';
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
            'assets.js',
        );
        $data['funinit'] = array(
            'Assets.init()',
            'Assets.add()'
        );
        $data['header'] = array(
            'title' => 'Assets List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Assets List' => 'Assets List',
            )
        );
        return view('backend.pages.assets.list',$data);
    }

    public function add()
    {
        $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add Assets List";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add Assets List";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add Assets List";
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array();
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'validate/jquery.validate.min.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'assets.js',
        );
        $data['funinit'] = array(
            'Assets.add()'
        );
        $data['header'] = array(
            'title' => 'Add Assets',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Assets List' => 'Assets List',
            )
        );
        return view('backend.pages.assets.add', $data);
    }

    public function saveAdd(Request $request)
    {
        $objAsset = new Asset();
        $result = $objAsset->saveAdd($request->all());
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Assets details successfully added.';
            $return['redirect'] = route('admin.asset.list');
        }  elseif ($result == "asset_type_exists" || $result == "asset_code_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Assets has already exists.';
        } else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }


    public function ajaxcall(Request $request)
    {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objAsset = new Asset();
                $list = $objAsset->getdatatable();

                echo json_encode($list);
                break;
            case 'common-activity':
                $objAsset = new Asset();
                $data = $request->input('data');
                $result = $objAsset->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                        $return['message'] = "Asset details successfully deactived.";
                    $return['redirect'] = route('admin.asset.list');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'It seems like something is wrong';;
                }

                echo json_encode($return);
                exit;
        }
    }
}

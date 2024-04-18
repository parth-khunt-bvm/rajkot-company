<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Config;

class BrandController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function list()
    {
        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Brand List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Brand List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Brand List';
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
            'brand.js',
        );
        $data['funinit'] = array(
            'Brand.init()',
            'Brand.add()'
        );
        $data['header'] = array(
            'title' => 'Brand List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Brand List' => 'Brand List',
            )
        );
        return view('backend.pages.brand.list',$data);
    }

    public function add (){
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(26, explode(',', $permission_array[0]['permission']))){
            $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Brand List";
            $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Brand List";
            $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Brand List";
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array(
            );
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'validate/jquery.validate.min.js',
            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'brand.js',
            );
            $data['funinit'] = array(
                'Brand.add()'
            );
            $data['header'] = array(
                'title' => 'Add Brand',
                'breadcrumb' => array(
                    'Dashboard' => route('my-dashboard'),
                    'Brand List' => 'Brand List',
                )
            );
            return view('backend.pages.brand.add', $data);
        }else{
            return redirect()->route('admin.brand.list');
        }
    }


    public function saveAdd(Request $request){
        $objBrand = new Brand();
        $result = $objBrand->saveAdd($request->all());
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Brand details successfully added.';
            $return['redirect'] = route('admin.brand.list');
        }  elseif ($result == "brand_name_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Brand has already exists.';
        } else{
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
                $objBrand = new Brand();
                $list = $objBrand->getdatatable();
                echo json_encode($list);
                break;

            case 'get-brand-trash':
                $objBrand = new Brand();
                $list = $objBrand->getBrandDatatable($request->input('data'));
                echo json_encode($list);
                break;

            case 'common-activity':
                $objBrand = new Brand();
                $data = $request->input('data');
                $result = $objBrand->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if($data['activity'] == 'delete-records'){
                        $return['message'] = "Brand's details successfully deleted.";
                        $return['redirect'] = route('admin.brand.list');
                    }elseif($data['activity'] == 'restore-records'){
                        $return['message'] = "Brand's details successfully restore.";
                        $return['redirect'] = route('admin.brand.deleted');
                    }elseif($data['activity'] == 'active-records'){
                        $return['message'] = "Brand's details successfully actived.";
                        $return['redirect'] = route('admin.brand.list');
                    }else{
                        $return['message'] = "Brand's details successfully deactived.";
                        $return['redirect'] = route('admin.brand.list');
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

    public function edit($brandId){
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(27, explode(',', $permission_array[0]['permission']))){
            $objBrand = new Brand();
            $data['brand_details'] = $objBrand->get_brand_details($brandId);

            $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Manager";
            $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Manager";
            $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Manager";
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array(
            );
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'validate/jquery.validate.min.js',
            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'brand.js',
            );
            $data['funinit'] = array(
                'Brand.edit()'
            );
            $data['header'] = array(
                'title' => 'Edit Brand',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Brand' => route('admin.brand.list'),
                    'Edit Brand' => 'Edit Brand',
                )
            );
            return view('backend.pages.brand.edit', $data);
        }else{
            return redirect()->route('admin.brand.list');
        }
    }

    public function saveEdit(Request $request){
        $objBrand = new Brand();
        $result = $objBrand->saveEdit($request->all());
        if ($result == "updated") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Brand details successfully updated.';
            $return['redirect'] = route('admin.brand.list');
        } elseif ($result == "brand_name_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Brand has already exists.';
        } else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function showDeletedData()
    {
        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Brand Deleted List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Brand Deleted List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Brand Deleted List';
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
            'brand.js',
        );
        $data['funinit'] = array(
            'Brand.trash_init()',
        );
        $data['header'] = array(
            'title' => 'Brand Deleted List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Brand Deleted List' => 'Brand Deleted List',
            )
        );
        return view('backend.pages.brand.trash',$data);
    }
}

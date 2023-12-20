<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Config;

class SupplierController extends Controller
{
    public function list(){

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Supplier List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Supplier List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Supplier List';
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
            'supplier.js',
        );
        $data['funinit'] = array(
            'Supplier.init()',
            'Supplier.add()'
        );
        $data['header'] = array(
            'title' => 'Supplier List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Supplier List' => 'Supplier List',
            )
        );
        return view('backend.pages.supplier.list', $data);
    }

    public function add (){
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(7, explode(',', $permission_array[0]['permission']))){
            $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Supplier";
            $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Supplier";
            $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Supplier";
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
                'supplier.js',
            );
            $data['funinit'] = array(
                'Supplier.add()'
            );
            $data['header'] = array(
                'title' => 'Add Supplier',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Supplier List' => route('admin.supplier.list'),
                    'Add Supplier' => 'Add Supplier',
                )
            );
            return view('backend.pages.supplier.add', $data);
        }else{
            return redirect()->route('admin.supplier.list');
        }
    }

    public function saveAdd(Request $request)
    {
        $objSupplier = new Supplier();
        $result = $objSupplier->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Supplier details successfully added.';
            $return['redirect'] = route('admin.supplier.list');
        } elseif ($result == "supplier_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Supplier has already exists.';
        } else {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }
    public function edit($editId)
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(102, explode(',', $permission_array[0]['permission']))){

            $objSupplier = new Supplier();
            $data['supplier_details'] = $objSupplier->get_Supplier_details($editId);

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Edit Supplier";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Edit Supplier";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Edit Supplier";
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
                'supplier.js',
            );
            $data['funinit'] = array(
                'Supplier.edit()'
            );
            $data['header'] = array(
                'title' => 'Edit Supplier',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Supplier List' => route('admin.supplier.list'),
                    'Edit Supplier' => 'Edit Supplier',
                )
            );
            return view('backend.pages.supplier.edit', $data);

        }else{
            return redirect()->route('admin.supplier.list');
        }

    }

    public function saveEdit(Request $request)
    {
        $objSupplier = new Supplier();
        $result = $objSupplier->saveEdit($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Supplier details successfully updated.';
            $return['redirect'] = route('admin.supplier.list');
        } elseif ($result == "supplier_name_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Supplier has already exists.';
        } else {
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
                $objSupplier = new Supplier();
                $list = $objSupplier->getdatatable($request->input('data'));
                echo json_encode($list);
                break;

            case 'common-activity':
                $objSupplier = new Supplier();
                $data = $request->input('data');
                $result = $objSupplier->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if($data['activity'] == 'delete-records'){
                        $return['message'] = 'Supplier details successfully deleted.';;
                    }elseif($data['activity'] == 'active-records'){
                        $return['message'] = 'Supplier details successfully actived.';;
                    }else{
                        $return['message'] = 'Supplier details successfully deactived.';;
                    }
                    $return['redirect'] = route('admin.supplier.list');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'It seems like something is wrong';;
                }

                echo json_encode($return);
                exit;
        }
    }

    public function view($viewId){
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(101, explode(',', $permission_array[0]['permission']))){

            $objSupplier = new Supplier();
            $data['supplier_details'] = $objSupplier->get_Supplier_details($viewId);

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || View Supplier";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || View Supplier";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || View Supplier";
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
            );
            $data['funinit'] = array(
            );
            $data['header'] = array(
                'title' => 'Basic Detail',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Supplier List' => route('admin.supplier.list'),
                    'View Supplier detail' => 'View Supplier detail',
                )
            );
            return view('backend.pages.supplier.view', $data);
        }else{
            return redirect()->route('admin.supplier.list');
        }
    }
}

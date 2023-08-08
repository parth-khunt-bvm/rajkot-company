<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use Config;

class BranchController extends Controller
{
    function __construct()
    {
            $this->middleware('admin');
    }

    public function list(Request $request){

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Branch List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Branch List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Branch List';
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
            'plugins/custom/datatables/datatables.bundle.css'
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'plugins/custom/datatables/datatables.bundle.js',
            'pages/crud/datatables/data-sources/html.js'
        );
        $data['js'] = array(
            'comman_function.js',
            'branch.js',
        );
        $data['funinit'] = array(
            'Branch.init()'
        );
        $data['header'] = array(
            'title' => 'Branch List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Branch List' => 'Branch List',
            )
        );
        return view('backend.pages.branch.list', $data);
    }

    public function add (){
        $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Branch";
        $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Branch";
        $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Branch";
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
            'branch.js',
        );
        $data['funinit'] = array(
            'Branch.add()'
        );
        $data['header'] = array(
            'title' => 'Add Branch',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Branch List' => route('admin.branch.list'),
                'Add Branch' => 'Add Branch',
            )
        );
        return view('backend.pages.branch.add', $data);
    }

    public function saveAdd(Request $request){
        $objBranch = new Slug();
        $result = $objBranch->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Slug details successfully added.';
            $return['redirect'] = route('slug.list');
        } elseif ($result == "slug_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Slug has already exists.';
        }  else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function edit ($editId){

        $objBranchcategory = new Slugcategory();
        $data['slug_category'] = $objBranchcategory->get_slug_category();

        $objBranch = new Slug();
        $data['slug_details'] = $objBranch->get_slug_details($editId);

        $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Slug";
        $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Slug";
        $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Slug";
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
            'slug.js',
        );
        $data['funinit'] = array(
            'Slug.edit()'
        );
        $data['header'] = array(
            'title' => 'Edit slug',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Slug List' => route('slug.list'),
                'Edit slug' => 'Edit slug',
            )
        );
        return view('backend.pages.slugs.edit', $data);
    }

    public function saveEdit(Request $request){
        $objBranch = new Slug();
        $result = $objBranch->saveEdit($request);
        if ($result == "added") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Slug details successfully updated.';
            $return['redirect'] = route('slug.list');
        } elseif ($result == "slug_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Slug has already exists.';
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
                $objBranch = new Branch();
                $list = $objBranch->getdatatable();

                echo json_encode($list);
                break;

            case 'common-activity':
                $objBranch = new Branch();
                $data = $request->input('data');
                $result = $objBranch->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if($data['activity'] == 'delete-records'){
                        $return['message'] = 'Branch details successfully deleted.';;
                    }elseif($data['activity'] == 'active-records'){
                        $return['message'] = 'Branch details successfully actived.';;
                    }else{
                        $return['message'] = 'Branch details successfully deactived.';;
                    }
                    $return['redirect'] = route('admin.branch.list');
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

<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Config;

class DocumentTypeController extends Controller
{
    function __construct()
    {
            $this->middleware('admin');
    }

    public function list(Request $request){

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Document Type List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Document Type List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Document Type List';
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
            'document_type.js',
        );
        $data['funinit'] = array(
            'DocumentType.init()',
            'DocumentType.add()'
        );
        $data['header'] = array(
            'title' => 'Document Type List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Document Type List' => 'Document Type List',
            )
        );
        return view('backend.pages.document_type.list', $data);
    }

    public function add (){
        // $userId = Auth()->guard('admin')->user()->user_type;
        // $permission_array = get_users_permission($userId);

        // if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(20, explode(',', $permission_array[0]['permission']))){
            $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Document Type";
            $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Document Type";
            $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Document Type";
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
                'document_type.js',
            );
            $data['funinit'] = array(
                'DocumentType.add()'
            );
            $data['header'] = array(
                'title' => 'Add Document Type',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Document Type List' => route('admin.document-type.list'),
                    'Add Document Type' => 'Add Document Type',
                )
            );
            return view('backend.pages.document_type.add', $data);
        // }else{
        //     return redirect()->route('admin.document-type.list');
        // }
    }

    public function saveAdd(Request $request){
        $objDocumentType = new DocumentType();
        $result = $objDocumentType->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Document Type successfully added.';
            $return['redirect'] = route('admin.document-type.list');
        } elseif ($result == "document_type_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Document Type has already exists.';
        }  else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function edit ($documentTypeId){
        // $userId = Auth()->guard('admin')->user()->user_type;
        // $permission_array = get_users_permission($userId);

        // if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(21, explode(',', $permission_array[0]['permission']))){
            $objDocumentType = new DocumentType();
            $data['document_type_details'] = $objDocumentType->get_document_type_details($documentTypeId);

            $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Document Type";
            $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Document Type";
            $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Document Type";
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
                'document_type.js',
            );
            $data['funinit'] = array(
                'DocumentType.edit()'
            );
            $data['header'] = array(
                'title' => 'Edit Document Type',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Document Type List' => route('admin.document-type.list'),
                    'Edit Document Type' => 'Edit Document Type',
                )
            );
            return view('backend.pages.document_type.edit', $data);
        // }else{
        //     return redirect()->route('admin.document-type.list');
        // }
    }

    public function saveEdit(Request $request){
        $objDocumentType = new DocumentType();
        $result = $objDocumentType->saveEdit($request);
        if ($result == "updated") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Document Type successfully updated.';
            $return['redirect'] = route('admin.document-type.list');
        } elseif ($result == "document_type_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Document Type has already exists.';
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
                $objDocumentType = new DocumentType();
                $list = $objDocumentType->getdatatable();

                echo json_encode($list);
                break;

            case 'common-activity':
                $objDocumentType = new DocumentType();
                $data = $request->input('data');
                $result = $objDocumentType->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if($data['activity'] == 'delete-records'){
                        $return['message'] = 'Document Type successfully deleted.';
                    }elseif($data['activity'] == 'active-records'){
                        $return['message'] = 'Document Type successfully actived.';
                    }else{
                        $return['message'] = 'Document Type successfully deactived.';
                    }
                    $return['redirect'] = route('admin.document-type.list');
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

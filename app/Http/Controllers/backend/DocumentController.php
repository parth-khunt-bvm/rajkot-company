<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Employee;
use Illuminate\Http\Request;
use Config;

class DocumentController extends Controller
{
    function __construct()
    {
            $this->middleware('admin');
    }

    public function list(Request $request){

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Document List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Document List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Document List';
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
            'document.js',
        );
        $data['funinit'] = array(
            'Document.init()',
            'Document.add()'
        );
        $data['header'] = array(
            'title' => 'Document List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Document List' => 'Document List',
            )
        );
        return view('backend.pages.document.list', $data);
    }

    public function add (){
        // $userId = Auth()->guard('admin')->user()->user_type;
        // $permission_array = get_users_permission($userId);

        // if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(20, explode(',', $permission_array[0]['permission']))){

            $objEmployee = new Employee;
            $data['employee'] = $objEmployee->get_admin_employee_details();

            $objDocumentType = new DocumentType;
            $data['document_type'] = $objDocumentType->get_admin_document_type_details();

            $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Document";
            $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Document";
            $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Add Document";
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array(
            );
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'pages/crud/forms/widgets/select2.js',
                'validate/jquery.validate.min.js',
                'pages/crud/file-upload/image-input.js'
            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'document.js',
            );
            $data['funinit'] = array(
                'Document.add()'
            );
            $data['header'] = array(
                'title' => 'Add Document',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Document List' => route('admin.document.list'),
                    'Add Document' => 'Add Document',
                )
            );
            return view('backend.pages.document.add', $data);
        // }else{
        //     return redirect()->route('admin.document-type.list');
        // }
    }

    public function saveAdd(Request $request){
        $objDocument = new Document();
        $result = $objDocument->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Document successfully added.';
            $return['redirect'] = route('admin.document.list');
        } elseif ($result == "document_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Document has already exists.';
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

        case 'get-image-requirement-number':
            $data = $request->input('data');
            $objDocument = new DocumentType();
            $list = $objDocument->getImageRequirementNumber($data['document_type']);
            echo json_encode($list);
            break;
        }
    }
}

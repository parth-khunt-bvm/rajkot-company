<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\LatterTemplate;
use Illuminate\Http\Request;
use Config;

class LatterTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Latter Templates List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Latter Templates List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Latter Templates List';
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
            'latter_template.js',
        );
        $data['funinit'] = array(
            'LatterTemplate.init()',
            'LatterTemplate.add()'
        );
        $data['header'] = array(
            'title' => 'Latter Templates List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Latter Templates List' => 'Latter Templates List',
            )
        );
        return view('backend.pages.latter_template.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add Latter Template";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add Latter Template";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add Latter Template";
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array();
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'pages/crud/forms/widgets/select2.js',
            'validate/jquery.validate.min.js',
            // 'pages/crud/forms/editors/ckeditor-classic.js',
            'plugins/custom/ckeditor/ckeditor-classic.bundle.js'
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'latter_template.js',
        );
        $data['funinit'] = array(
            'LatterTemplate.add()'
        );
        $data['header'] = array(
            'title' => 'Add Latter Template',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Latter Templates List' => route('latter-templates.index'),
                'Add Latter Template' => 'Add Latter Template',
            )
        );
        return view('backend.pages.latter_template.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $objLatterTemplate = new LatterTemplate();
        $result = $objLatterTemplate->store($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Latter Template details successfully added.';
            $return['redirect'] = route('latter-templates.index');
        }else {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $objLatterTemplate = new LatterTemplate();
        $data['latter_template_details'] = $objLatterTemplate->get_latter_template_details($id);


        $data['title'] = Config::get('constants.PROJECT_NAME') . " || Edit Latter Template";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || Edit Latter Template";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Edit Latter Template";
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array();
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'pages/crud/forms/widgets/select2.js',
            'validate/jquery.validate.min.js',
            'plugins/custom/ckeditor/ckeditor-classic.bundle.js'
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'latter_template.js',
        );
        $data['funinit'] = array(
            'LatterTemplate.edit()'
        );
        $data['header'] = array(
            'title' => 'Edit Latter Template',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Latter Template List' => route('latter-templates.index'),
                'Edit Latter Template' => 'Edit Latter Template',
            )
        );
        return view('backend.pages.latter_template.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $objLatterTemplate = new LatterTemplate();
        $result = $objLatterTemplate->saveEdit($request);
        if ($result == "updated") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Latter Template details successfully updated.';
            $return['redirect'] = route('latter-templates.index');
        }  else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajaxcall(Request $request){
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objLatterTemplate = new LatterTemplate();
                $list = $objLatterTemplate->getdatatable();
                echo json_encode($list);
                break;

            case 'common-activity':
                $objLatterTemplate = new LatterTemplate();
                $data = $request->input('data');
                $result = $objLatterTemplate->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if($data['activity'] == 'delete-records'){
                        $return['message'] = 'Latter Template details successfully deleted.';
                    }elseif($data['activity'] == 'active-records'){
                        $return['message'] = 'Latter Template details successfully actived.';
                    }else{
                        $return['message'] = 'Latter Template details successfully deactived.';
                    }
                    $return['redirect'] = route('latter-templates.index');
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

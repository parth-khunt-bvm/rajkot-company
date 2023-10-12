<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Imports\TechnologyImport;
use App\Models\Technology;
use Illuminate\Http\Request;
use Config;

class TechnologyController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function list(Request $request)
    {

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Technology List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Technology List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Technology List';
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
            'technology.js',
        );
        $data['funinit'] = array(
            'Technology.init()'
        );
        $data['header'] = array(
            'title' => 'Technology List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Technology List' => 'Technology List',
            )
        );
        return view('backend.pages.technology.list', $data);

    }

    public function add()
    {
        $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add Technology List";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add Technology List";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add Technology List";
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
            'technology.js',
        );
        $data['funinit'] = array(
            'Technology.add()'
        );
        $data['header'] = array(
            'title' => 'Add Technology',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Technology List' => 'Technology List',
            )
        );
        return view('backend.pages.technology.add', $data);
    }

    public function saveAdd(Request $request)
    {
        $objTechnology = new Technology();
        $result = $objTechnology->saveAdd($request->all());
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Technology details successfully added.';
            $return['redirect'] = route('admin.technology.list');
        }  elseif ($result == "technology_name_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Technology has already exists.';
        } else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function edit($technologyId)
    {
        $objTechnology = new Technology();
        $data['user_details'] = $objTechnology->get_technology_details($technologyId);

        $data['title'] = Config::get('constants.PROJECT_NAME') . " || Edit Technology";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || Edit Technology";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Edit Technology";
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
            'technology.js',
        );
        $data['funinit'] = array(
            'Technology.edit()'
        );
        $data['header'] = array(
            'title' => 'Edit technology',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Admin users' => route('admin.technology.list'),
                'Edit admin users' => 'Edit admin users',
            )
        );
        return view('backend.pages.technology.edit', $data);
    }

    public function saveEdit(Request $request)
    {
        $objTechnology = new Technology();
        $result = $objTechnology->saveEdit($request->all());
        if ($result == "updated") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Technology details successfully added.';
            $return['redirect'] = route('admin.technology.list');
        }  elseif ($result == "technology_name_exists") {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Technology has already exists.';
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
                $objTechnology = new Technology();
                $list = $objTechnology->getdatatable();

                echo json_encode($list);
                break;


            case 'common-activity':
                $objTechnology = new Technology();
                $data = $request->input('data');
                $result = $objTechnology->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if ($data['activity'] == 'delete-records') {
                        $return['message'] = "Technology details successfully deleted.";
                    } elseif ($data['activity'] == 'active-records') {
                        $return['message'] = "Technology details successfully actived.";
                    } else {
                        $return['message'] = "Technology details successfully deactived.";
                    }
                    $return['redirect'] = route('admin.technology.list');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'It seems like something is wrong';;
                }

                echo json_encode($return);
                exit;
        }
    }
    public function save_import(Request $request){


        $path = $request->file('file')->store('temp');
        $data = \Excel::import(new TechnologyImport($request->file('file')),$path);
        $return['status'] = 'success';
        $return['message'] = 'Technology added successfully.';
        $return['redirect'] = route('admin.technology.list');

        echo json_encode($return);
        exit;
    }
}

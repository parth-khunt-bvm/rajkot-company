<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\LatterAbbreviation;
use Illuminate\Http\Request;
use Config;

class LatterAbbreviationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Latter Abbreviation List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Latter Abbreviation List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Latter Abbreviation List';
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
            'latter_abbreviation.js',
        );
        $data['funinit'] = array(
            'LatterAbbreviation.init()',
            'LatterAbbreviation.add()'
        );
        $data['header'] = array(
            'title' => 'Latter Abbreviation List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Latter Abbreviation List' => 'Latter Abbreviation List',
            )
        );
        return view('backend.pages.latter_abbreviation.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add Latter Abbreviation";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add Latter Abbreviation";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add Latter Abbreviation";
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
            'latter_abbreviation.js',
        );
        $data['funinit'] = array(
            'LatterAbbreviation.add()'
        );
        $data['header'] = array(
            'title' => 'Add Latter Abbreviation',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Latter Abbreviation List' => route('latter-abbreviations.index'),
                'Add Latter Abbreviation' => 'Add Latter Abbreviation',
            )
        );
        return view('backend.pages.latter_abbreviation.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $objLatterAbbreviation = new LatterAbbreviation();
        $result = $objLatterAbbreviation->store($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Latter Abbreviation details successfully added.';
            $return['redirect'] = route('latter-abbreviations.index');
        }elseif ($result == "latter_abbreviation_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Latter Abbreviation has already exists.';
        } else
         {
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
        $objLatterAbbreviation = new LatterAbbreviation();
        $data['latter_abbreviations_details'] = $objLatterAbbreviation->get_latter_abbreviation_details($id);

        $data['title'] = Config::get('constants.PROJECT_NAME') . " || Edit Latter Abbreviation";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || Edit Latter Abbreviation";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Edit Latter Abbreviation";
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
            'latter_abbreviation.js',
        );
        $data['funinit'] = array(
            'LatterAbbreviation.edit()'
        );
        $data['header'] = array(
            'title' => 'Edit Latter Abbreviation',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Latter Abbreviation List' => route('latter-abbreviations.index'),
                'Edit Latter Abbreviation' => 'Edit Latter Abbreviation',
            )
        );
        return view('backend.pages.latter_abbreviation.edit', $data);
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
        $objLatterAbbreviation = new LatterAbbreviation();
        $result = $objLatterAbbreviation->saveEdit($request);
        if ($result == "updated") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Latter Abbreviation details successfully updated.';
            $return['redirect'] = route('latter-abbreviations.index');
        } elseif ($result == "latter_abbreviation_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Latter Abbreviation has already exists.';
        }
        else{
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
                $objLatterAbbreviation = new LatterAbbreviation();
                $list = $objLatterAbbreviation->getdatatable();
                echo json_encode($list);
                break;

        }
    }
}

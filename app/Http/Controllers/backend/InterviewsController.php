<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interview;
use App\Models\Designation;
use App\Models\Technology;
use App\Models\Branch;
use Config;

class InterviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Interview list';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Interview list';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Interview list';
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
            'interview.js',
        );
        $data['funinit'] = array(
            'Interview.init()',
        );
        $data['header'] = array(
            'title' => 'Interview list',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Interview list' => 'Interview list',
            )
        );
        return view('backend.pages.interview.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $objTechnology = new Technology();
        $data['technology'] = $objTechnology->get_admin_technology_details();

        $objDesignation = new Designation();
        $data['designation'] = $objDesignation->get_admin_designation_details();

        $objBranch = new Branch();
        $data['branch'] = $objBranch->get_admin_branch_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add Interview";
        $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add Interview";
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add Interview";
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
            'interview.js',
        );
        $data['funinit'] = array(
            'Interview.add()'
        );
        $data['header'] = array(
            'title' => 'Add Interview',
            'breadcrumb' => array(
                'My Dashboard' => route('my-dashboard'),
                'Interview List' => route('admin.interviews.index'),
                'Add Interview' => 'Add Interview',
            )
        );
        return view('backend.pages.interview.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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

    public function ajaxcall(Request $request)
    {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objHrExpense = new Interview();
                $list = $objHrExpense->getdatatable($request->input('data'));
                echo json_encode($list);
                break;
        }
    }
}

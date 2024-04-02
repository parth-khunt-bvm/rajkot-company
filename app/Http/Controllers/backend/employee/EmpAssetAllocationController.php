<?php

namespace App\Http\Controllers\backend\employee;

use App\Http\Controllers\Controller;
use App\Models\EmpAssetAllocation;
use Illuminate\Http\Request;
use Config;

class EmpAssetAllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('employee');
    }

    public function index()
    {
        $data['date'] = '01-Feb-2024';
        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Asset Allocation List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Asset Allocation List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Asset Allocation List';
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
            'plugins/custom/datatables/datatables.bundle.css',
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'plugins/custom/datatables/datatables.bundle.js',
            'pages/crud/datatables/data-sources/html.js',
            'validate/jquery.validate.min.js',
            'pages/crud/forms/widgets/select2.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'emp_asset_allocation.js',
        );
        $data['funinit'] = array(
            'EmpAssetAllocation.init()',
        );
        $data['header'] = array(
            'title' => 'Asset Allocation List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Asset Allocation List' => 'Asset Allocation List',
            )
        );
        return view('backend.employee.pages.asset_allocation.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
                $objEmpAssetAllocation = new EmpAssetAllocation();
                $list = $objEmpAssetAllocation->getdatatable($request->input('data'));
                echo json_encode($list);
                break;

        }
    }
}

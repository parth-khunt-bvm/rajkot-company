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
}

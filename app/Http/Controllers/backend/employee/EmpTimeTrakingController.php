<?php

namespace App\Http\Controllers\backend\employee;

use App\Http\Controllers\Controller;
use App\Models\EmpTimeTracking;
use Illuminate\Http\Request;
use Config;

class EmpTimeTrakingController extends Controller
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
        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Time Traking';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Time Traking';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Time Traking';
        $data['css'] = array(
            'toastr/toastr.min.css',
            'emp_time_traking.css',
        );
        $data['plugincss'] = array(
        );
        $data['pluginjs'] = array(
        );
        $data['js'] = array(
            'emp_time_traking.js',
            'comman_function.js',
        );
        $data['funinit'] = array(
            'EmpTimeTraking.init()',
        );
        $data['header'] = array(
            'title' => 'Time Traking',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Time Traking' => 'Time Traking',
            )
        );
        return view('backend.employee.pages.time_traking.index', $data);
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

    public function storeStart(Request $request)
    {
        $objEmpTimeTracking = new EmpTimeTracking();
        $result = $objEmpTimeTracking->storeStart($request);
        if ($result == "added") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Time traking details successfully added.';
            $return['redirect'] = route('time-traking.index');
        } else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;

    }

    // public function storeStop(Request $request)
    // {
    //     $EmpTimeTraking = new EmpTimeTraking();
    //     $EmpTimeTraking->value = 'stop'; // Store the value 'stop'
    //     $EmpTimeTraking->save();

    //     return response()->json(['success' => true]);
    // }


}

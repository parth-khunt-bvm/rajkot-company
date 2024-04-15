<?php

namespace App\Http\Controllers;

use App\Models\EmployeeSalaryIncrement;
use App\Models\SalaryIncrement;
use Illuminate\Http\Request;

class EmployeeSalaryIncrementController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function ajaxcall(Request $request)
    {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objEmployeeSalaryIncrement = new EmployeeSalaryIncrement();
                $list = $objEmployeeSalaryIncrement->getdatatable($request->input('data'));
                echo json_encode($list);
                break;
        }
    }
}

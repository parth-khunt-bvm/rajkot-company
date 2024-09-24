<?php

namespace App\Http\Controllers\backend;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonActivityController extends Controller
{
    public function common_activity(Request $request)
    {
        $action = $request->input('action');
        switch ($action) {

            case 'get_employee_from_branch':
                $list = Employee::from('employee')->select('employee.id','employee.first_name','employee.last_name')
                        ->join("branch", "branch.id", "=", "employee.branch")
                        ->where('employee.branch', $request->input('branchId'))
                        ->where("employee.status", "=", "W")
                        ->where("employee.is_deleted", "=", "N")
                        ->get();

                echo json_encode($list);
                break;
            
        }
    }
}

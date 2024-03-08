<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ChangeRequest extends Model
{
    use HasFactory;

    protected $table = 'change_request';

    public function getdatatable()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'change_request.id',
            1 => \DB::raw('CONCAT(employee.first_name, " ", employee.last_name)'),
            2 => DB::raw('(CASE WHEN change_request.request_type = "1" THEN "Persona Info"
                                WHEN change_request.request_type = "2" THEN "Bank Info"
                                ELSE "Parent Info" END)'),
            3 => 'branch.branch_name',
            4 => 'technology.technology_name',
            5 => 'designation.designation_name',
        );

        $query = ChangeRequest::from('change_request')
               ->join("employee", "employee.id", "=", "change_request.employee_id")
               ->join("branch", "branch.id", "=", "employee.id")
               ->join("technology", "technology.id", "=", "employee.id")
               ->join("designation", "designation.id", "=", "employee.id");

        if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchVal = $requestData['search']['value'];
            $query->where(function ($query) use ($columns, $searchVal, $requestData) {
                $flag = 0;
                foreach ($columns as $key => $value) {
                    $searchVal = $requestData['search']['value'];
                    if ($requestData['columns'][$key]['searchable'] == 'true') {
                        if ($flag == 0) {
                            $query->where($value, 'like', '%' . $searchVal . '%');
                            $flag = $flag + 1;
                        } else {
                            $query->orWhere($value, 'like', '%' . $searchVal . '%');
                        }
                    }
                }
            });
        }

        $temp = $query->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $totalData = count($temp->get());
        $totalFiltered = count($temp->get());

        $resultArr = $query->skip($requestData['start'])
            ->take($requestData['length'])
            ->select('change_request.id', 'change_request.employee_id', 'change_request.request_type', 'change_request.data', 'branch.branch_name','technology.technology_name', 'designation.designation_name', DB::raw('CONCAT(employee.first_name, " ", employee.last_name) as EmpName'))
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            // $target = [];
            // $target = [33, 34, 35];
            // $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            // if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            // }

            if ($row['request_type'] == '1') {
                $request_type = '<span class="label label-lg label-light-info label-inline">Personal Info</span>';
            } else if ($row['request_type'] == '2') {
                $request_type = '<span class="label label-lg label-light-info label-inline">Bank Info</span>';
            } else {
                $request_type = '<span class="label label-lg label-light-info  label-inline">parent Info</span>';
            }
            // if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(35, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href=""data-toggle="modal" data-target="#change-request-view" data-id="'.$row['id'].'" class="btn btn-icon change-request-view"><i class="fa fa-eye text-primary"> </i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['EmpName'];
            $nestedData[] = $row['branch_name'];
            $nestedData[] = $row['technology_name'];
            $nestedData[] = $row['designation_name'];
            $nestedData[] = $request_type;
            // if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $nestedData[] = $actionhtml;
            // }
            $data[] = $nestedData;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
        );
        return $json_data;
    }

    // public function get_change_request_details($id){
    //     $req = ChangeRequest::from('change_request')
    //     ->join("employee", "employee.id", "=", "change_request.employee_id")
    //     ->join("branch", "branch.id", "=", "employee.id")
    //     ->join("technology", "technology.id", "=", "employee.id")
    //     ->join("designation", "designation.id", "=", "employee.id")
    //     ->select('change_request.id', 'change_request.employee_id', 'change_request.request_type', 'change_request.data', 'branch.branch_name','technology.technology_name', 'designation.designation_name', DB::raw('CONCAT(employee.first_name, " ", employee.last_name) as EmpName'))
    //     ->where('change_request.id', $id)
    //     ->first();
    //     ccd($req);
    // }

    public function get_change_request_details($data){
        return ChangeRequest::select('employee_id','data')->where('id',$data['id'])->get();
    }

}

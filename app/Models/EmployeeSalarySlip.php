<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class EmployeeSalarySlip extends Model
{
    use HasFactory;

    protected $table = 'salary_slip';

    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'salary_slip.id',
            1 => DB::raw("CONCAT(employee.first_name,' ',employee.last_name)"),
            2 => 'branch.technology_name',
            3 => 'designation.designation_name',
            4 =>  DB::raw('CONCAT(MONTHNAME(CONCAT("2023-", salary_slip.month, "-01")), "-", year)'),
        );

        $query = SalarySlip::from('salary_slip')
            ->join("employee", "employee.id", "=", "salary_slip.employee")
            ->join("designation", "designation.id", "=", "salary_slip.designation")
            ->join("technology", "technology.id", "=", "salary_slip.department")
            ->where("salary_slip.employee", $fillterdata['userId'])
            ->where("salary_slip.is_deleted", "=", "N");

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
            ->select('salary_slip.id', DB::raw("CONCAT(employee.first_name,' ',employee.last_name) as full_name"), 'designation.designation_name', 'technology.technology_name', DB::raw('CONCAT(MONTHNAME(CONCAT("2023-", salary_slip.month, "-01")), "-", year) as monthYear'))
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {

            $target = [];
            $target = [128, 129, 130, 131];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if (Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0) {
                $actionhtml = '';
            }
            if (Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(128, explode(',', $permission_array[0]['permission'])))
                $actionhtml .= '<a href="' . route('admin.employee-salaryslip.view', $row['id']) . '" class="btn btn-icon"><i class="fa fa-eye text-primary"> </i></a>';

            if (Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(129, explode(',', $permission_array[0]['permission'])))
                $actionhtml .= '<a href="' . route('admin.employee-salaryslip.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

            if (Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(130, explode(',', $permission_array[0]['permission'])))
                $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            if (Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(131, explode(',', $permission_array[0]['permission'])))
                $actionhtml .= '<a href="' . route('admin.employee-salaryslip.pdf', $row['id']) . '" class="btn btn-icon" data-toggle="tooltip" data-placement="top" title="salary slip pdf"><i class="far fa-file-pdf text-success"></i></a>';


            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['full_name'];
            $nestedData[] = $row['technology_name'];
            $nestedData[] = $row['designation_name'];
            $monthName = $row['monthYear'];
            $nestedData[] = $monthName;
            if (Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0) {
                $nestedData[] = $actionhtml;
            }
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

}

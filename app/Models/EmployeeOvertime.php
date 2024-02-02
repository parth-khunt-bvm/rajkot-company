<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class EmployeeOvertime extends Model
{
    use HasFactory;

    protected $table = 'emp_overtime';

    public function getdatatable()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'emp_overtime.id',
            1 => DB::raw('DATE_FORMAT(emp_overtime.date, "%d-%b-%Y")'),
            2 => DB::raw('CONCAT(employee.first_name, " ", employee.last_name)'),
            3 => 'emp_overtime.hours',
            4 => 'emp_overtime.note',
        );
        $query = EmpOvertime::from('emp_overtime')
            ->join("employee", "employee.id", "=", "emp_overtime.employee_id")
            ->where("emp_overtime.employee_id", "=", Auth()->guard('employee')->user()->id);


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
            ->select('emp_overtime.id', 'emp_overtime.date', DB::raw('CONCAT(employee.first_name, " ", employee.last_name) as EmpName'), 'emp_overtime.hours', 'emp_overtime.note')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
                $actionhtml = '';
            $actionhtml .= '<a href=""data-toggle="modal" data-target="#emp-overtime-view" data-id="'.$row['id'].'" class="btn btn-icon emp-overtime-view"><i class="fa fa-eye text-primary"> </i></a>';
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['date'] != '' && $row['date'] != NULL ? date_formate($row['date']) : '-';
            $nestedData[] = $row['EmpName'];
            $nestedData[] = numberformat($row['hours'], 0);
            $nestedData[] = $row['note'] ?? '-';
            $nestedData[] = $actionhtml;
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

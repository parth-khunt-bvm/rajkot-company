<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class EmployeeSalaryIncrement extends Model
{
    use HasFactory;

    protected $table = 'salary_increment';

    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'salary_increment.id',
            1 => DB::raw('CONCAT(employee.first_name, " ", employee.last_name)'),
            2 => 'salary_increment.previous_salary',
            3 => 'salary_increment.current_salary',
            4 => DB::raw('DATE_FORMAT(salary_increment.date, "%d-%b-%Y")'),
        );

        $query = SalaryIncrement::from('salary_increment')
            ->join("employee", "employee.id", "=", "salary_increment.employee_id")
            ->where('salary_increment.is_deleted', 'N')
            ->where("salary_increment.employee_id", $fillterdata['userId']);;


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
            ->select( DB::raw('CONCAT(employee.first_name, " ", employee.last_name) as EmpName'), 'salary_increment.id','salary_increment.previous_salary', 'salary_increment.current_salary', 'salary_increment.start_from')
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {
            $actionhtml = '';
            $actionhtml .= '<a href="' . route('admin.salary-increment.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['EmpName'];
            $nestedData[] = numberformat($row['previous_salary']);
            $nestedData[] = numberformat($row['current_salary']);
            $nestedData[] = date_formate($row['start_from']);
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

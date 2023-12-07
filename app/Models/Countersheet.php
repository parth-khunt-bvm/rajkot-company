<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Employee;

class Countersheet extends Model
{
    use HasFactory;
    protected $table = "attendance";
    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'employee.id',
            1 => DB::raw('CONCAT(employee.first_name, " ", employee.last_name)'),
            2 => 'technology.technology_name',
            3 => DB::raw('COUNT("attendance_type")'),
            4 => DB::raw('SUM(CASE WHEN attendance_type="0" THEN 1 ELSE 0 END)'),
            5 => DB::raw('SUM(CASE WHEN attendance_type="1" THEN 1 ELSE 0 END)'),
            6 => DB::raw('SUM(CASE WHEN attendance_type="2" THEN 1 ELSE 0 END)'),
            7 => DB::raw('SUM(CASE WHEN attendance_type="3" THEN 1 ELSE 0 END)'),
            8 => DB::raw('CONCAT(
                FLOOR((SUM(CASE WHEN attendance_type="0" THEN 1 ELSE 0 END)*8 + SUM(CASE WHEN attendance_type="2" THEN 1 ELSE 0 END)*4 + SUM(CASE WHEN attendance_type="3" THEN 1 ELSE 0 END)*6) / 8),
                ".",
                (SUM(CASE WHEN attendance_type="0" THEN 1 ELSE 0 END)*8 + SUM(CASE WHEN attendance_type="2" THEN 1 ELSE 0 END)*4 + SUM(CASE WHEN attendance_type="3" THEN 1 ELSE 0 END)*6) % 8,
                ""
            )'),
        );
        $query = Employee::from('employee')
             ->join("technology", "technology.id", "=", "employee.department")
             ->leftjoin("attendance", "attendance.employee_id", "=", "employee.id")
             ->where("employee.is_deleted", "=", "N")
             ->groupBy("attendance.employee_id")
             ->whereMonth('attendance.date', $fillterdata['month'])
             ->whereYear('attendance.date', $fillterdata['year']);

        if($fillterdata['technology'] != null && $fillterdata['technology'] != ''){
            $query->where("technology.id", $fillterdata['technology']);
        }
        // if($fillterdata['branch'] != null && $fillterdata['branch'] != ''){
        //     $query->where("branch.id", $fillterdata['branch']);
        // }

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
            ->select( 'employee.id', 'technology.technology_name',
                    DB::raw('CONCAT(employee.first_name, " ", employee.last_name) as full_name'),
                    DB::raw('COUNT(attendance_type) as totalDays'),
                    DB::raw('SUM(CASE WHEN attendance_type="0" THEN 1 ELSE 0 END) as presentCount'),
                    DB::raw('SUM(CASE WHEN attendance_type="1" THEN 1 ELSE 0 END) as absentcount'),
                    DB::raw('SUM(CASE WHEN attendance_type="2" THEN 1 ELSE 0 END) as halfdaycount'),
                    DB::raw('SUM(CASE WHEN attendance_type="3" THEN 1 ELSE 0 END) as sortleavecount'),
                    DB::raw('CONCAT(
                        FLOOR((SUM(CASE WHEN attendance_type="0" THEN 1 ELSE 0 END)*8 + SUM(CASE WHEN attendance_type="2" THEN 1 ELSE 0 END)*4 + SUM(CASE WHEN attendance_type="3" THEN 1 ELSE 0 END)*6) / 8),
                        ".",
                        (SUM(CASE WHEN attendance_type="0" THEN 1 ELSE 0 END)*8 + SUM(CASE WHEN attendance_type="2" THEN 1 ELSE 0 END)*4 + SUM(CASE WHEN attendance_type="3" THEN 1 ELSE 0 END)*6) % 8,
                        ""
                    ) as total')
                )
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {

            $actionhtml  = '';
            // $actionhtml .= '<a href="' . route('admin.employee.view', $row['id']) . '" class="btn btn-icon"><i class="fa fa-eye text-primary"> </i></a>';
            $actionhtml  =  '<button data-toggle="modal" data-user-id="'.$row['id'].'" data-month="'.$fillterdata['month'].'"  data-year="'.$fillterdata['year'].'"data-target="#countersheet" class="counter-sheet btn btn-icon user-menu"><i class="fa fa-eye text-primary"> </i></button>';
            ;
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['full_name'];
            $nestedData[] = $row['technology_name'];
            $nestedData[] = $row['totalDays'];
            $nestedData[] = $row['presentCount'];
            $nestedData[] = $row['absentcount'];
            $nestedData[] = $row['halfdaycount'];
            $nestedData[] = $row['sortleavecount'];
            $nestedData[] = $row['total'];
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

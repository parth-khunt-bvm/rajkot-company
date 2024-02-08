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
            1 => \DB::raw('CONCAT(employee.first_name, " ", employee.last_name)'),
            2 => 'technology.technology_name',
            3 => \DB::raw('COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.halfDayCount, 0) + COALESCE(a.sortLeaveCount, 0)'),
            4 => 'a.presentCount',
            5 => 'a.absentCount',
            6 => 'a.halfDayCount',
            7 => 'a.sortLeaveCount',
            8 =>  DB::raw('IFNULL(o.overTime, 0)'),
            9 =>   DB::raw('
            CONCAT(
                FLOOR(
                    (COALESCE(a.presentCount, 0)*8 + COALESCE(a.halfDayCount, 0)*4 + COALESCE(a.sortLeaveCount, 0)*2 + IFNULL(o.overTime, 0))/8
                ),
                ".",
                FLOOR((COALESCE(a.presentCount, 0)*8 + COALESCE(a.halfDayCount, 0)*4 + COALESCE(a.sortLeaveCount, 0)*2 + IFNULL(o.overTime, 0))%8)
            )')

        );

        $query = Employee::query()
            ->join('technology', 'technology.id', '=', 'employee.department')
            ->leftJoin(\DB::raw('(SELECT employee_id, SUM(hours) AS overTime FROM emp_overtime WHERE MONTH(date) ='  . $fillterdata['month'] . ' AND YEAR(date) = '  . $fillterdata['year'] . ' GROUP BY employee_id) o'), 'o.employee_id', '=', 'employee.id')
            ->leftJoin(\DB::raw('(SELECT employee_id, COUNT(CASE WHEN attendance_type = "0" THEN 1  END) AS presentCount, COUNT(CASE WHEN attendance_type = "1" THEN 1  END) AS absentCount, COUNT(CASE WHEN attendance_type = "2" THEN 1  END) AS halfDayCount, COUNT(CASE WHEN attendance_type = "3" THEN 1  END) AS sortLeaveCount FROM attendance WHERE MONTH(date) ='  . $fillterdata['month'] . ' AND YEAR(date) = ' . $fillterdata['year'] . ' GROUP BY employee_id) a'), 'a.employee_id', '=', 'employee.id')
            ->where('employee.is_deleted', 'N');


            if($fillterdata['technology'] != null && $fillterdata['technology'] != ''){
                $query->where("technology.id", $fillterdata['technology']);
        }

            if($fillterdata['branch'] != null && $fillterdata['branch'] != ''){
                $query->where("employee.branch", $fillterdata['branch']);
            }

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
            ->select('employee.id', 'technology.technology_name', DB::raw('IFNULL(o.overTime, 0) as overTime'), \DB::raw('CONCAT(employee.first_name, " ", employee.last_name) AS full_name'), 'a.presentCount', 'a.absentCount', 'a.halfDayCount', 'a.sortLeaveCount', \DB::raw('COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.halfDayCount, 0) + COALESCE(a.sortLeaveCount, 0) AS totalDays'),
            DB::raw('
            CONCAT(
                FLOOR(
                    (COALESCE(a.presentCount, 0)*8 + COALESCE(a.halfDayCount, 0)*4 + COALESCE(a.sortLeaveCount, 0)*2 + IFNULL(o.overTime, 0))/8
                ),
                ".",
                FLOOR((COALESCE(a.presentCount, 0)*8 + COALESCE(a.halfDayCount, 0)*4 + COALESCE(a.sortLeaveCount, 0)*2 + IFNULL(o.overTime, 0))%8)
            )
            as total'))
            ->get();

        $data = array();
        $i = 0;
        // ccd($resultArr);
        foreach ($resultArr as $row) {

            $actionhtml  = '';
            // $actionhtml .= '<a href="' . route('admin.employee.view', $row['id']) . '" class="btn btn-icon"><i class="fa fa-eye text-primary"> </i></a>';
            $actionhtml  =  '<button data-toggle="modal" data-user-id="' . $row['id'] . '" data-month="' . $fillterdata['month'] . '"  data-year="' . $fillterdata['year'] . '"data-target="#countersheet" class="counter-sheet btn btn-icon user-menu"><i class="fa fa-eye text-primary"> </i></button>';;
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['full_name'];
            $nestedData[] = $row['technology_name'];
            $nestedData[] = $row['totalDays'];
            $nestedData[] = $row['presentCount'];
            $nestedData[] = $row['absentCount'];
            $nestedData[] = $row['halfDayCount'];
            $nestedData[] = $row['sortLeaveCount'];
            $nestedData[] = $row['overTime'];
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


    public function counterSheetPdf($fillterdata)
    {

        $query = Employee::query()
            ->join('technology', 'technology.id', '=', 'employee.department')
            ->leftJoin(\DB::raw('(SELECT employee_id, SUM(hours) AS overTime FROM emp_overtime WHERE MONTH(date) ='  . $fillterdata['month'] . ' AND YEAR(date) = '  . $fillterdata['year'] . ' GROUP BY employee_id) o'), 'o.employee_id', '=', 'employee.id')
            ->leftJoin(\DB::raw('(SELECT employee_id, COUNT(CASE WHEN attendance_type = "0" THEN 1  END) AS presentCount, COUNT(CASE WHEN attendance_type = "1" THEN 1  END) AS absentCount, COUNT(CASE WHEN attendance_type = "2" THEN 1  END) AS halfDayCount, COUNT(CASE WHEN attendance_type = "3" THEN 1  END) AS sortLeaveCount FROM attendance WHERE MONTH(date) ='  . $fillterdata['month'] . ' AND YEAR(date) = ' . $fillterdata['year'] . ' GROUP BY employee_id) a'), 'a.employee_id', '=', 'employee.id')
            ->where('employee.is_deleted', 'N');


        if ($fillterdata['technology'] != null && $fillterdata['technology'] != '') {
            $query->where("technology.id", $fillterdata['technology']);
        }

        if ($fillterdata['branch'] != null && $fillterdata['branch'] != '') {
            $query->where("employee.branch", $fillterdata['branch']);
        }



        $resultArr = $query->select(
            'employee.id',
            'technology.technology_name',
            DB::raw('IFNULL(o.overTime, 0) as overTime'),
            \DB::raw('CONCAT(employee.first_name, " ", employee.last_name) AS full_name'),
            'a.presentCount',
            'a.absentCount',
            'a.halfDayCount',
            'a.sortLeaveCount',
            \DB::raw('COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.halfDayCount, 0) + COALESCE(a.sortLeaveCount, 0) AS totalDays'),
            DB::raw('
        CONCAT(
            FLOOR(
                (COALESCE(a.presentCount, 0)*8 + COALESCE(a.halfDayCount, 0)*4 + COALESCE(a.sortLeaveCount, 0)*2 + IFNULL(o.overTime, 0))/8
            ),
            ".",
            FLOOR((COALESCE(a.presentCount, 0)*8 + COALESCE(a.halfDayCount, 0)*4 + COALESCE(a.sortLeaveCount, 0)*2 + IFNULL(o.overTime, 0))%8)
        )
        as total')
        )
            ->get();

        $data = array();
        $i = 0;

        $data['title'] = 'contact data';


        $customPaper = [0, 0, 612.00, 792.00];
        $pdf = PDF::loadView('backend.pages.counter_sheet.pdf', $data)->setPaper($customPaper, 'portrait');

        return $pdf->download('contact_data.pdf');
    }
}

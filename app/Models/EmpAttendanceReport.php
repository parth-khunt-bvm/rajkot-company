<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class EmpAttendanceReport extends Model
{
    use HasFactory;

    protected $table = "attendance";

    public function getdatatable($fillterdata)
    {
        // $dateObject = Carbon::createFromFormat('d-M-Y', $fillterdata['date']);
        // $outputDate = $dateObject->format('Y-m-d');

        $currentMonth = today()->format('d-M-Y');
        // dd($currentMonth);
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'attendance.id',
            1 => 'attendance.date',
            2 => DB::raw('CONCAT(first_name, " ", last_name)'),
            3 => DB::raw('(CASE WHEN attendance.attendance_type = "0" THEN "Actived"
                                WHEN attendance.attendance_type = "1" THEN "Absent"
                                WHEN attendance.attendance_type = "2" THEN "Half Day"
                                ELSE "Short Leave" END)'),
            4 => 'attendance.reason',
            5 => 'attendance.minutes',
        );
        // if ($outputDate != null && $outputDate != '') {
            $query = Attendance::from('attendance')
                ->join("employee", "employee.id", "=", "attendance.employee_id")
                ->join("branch", "branch.id", "=", "employee.branch")
                ->where("attendance.date", '2024-02-02')
                // ->whereMonth('date', $fillterdata['month'])
                // ->whereYear('date', $fillterdata['year']);
                ->where("employee.id", Auth()->guard('employee')->user()->id);
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
            ->select('attendance.id', DB::raw('CONCAT(first_name, " ", last_name) as fullName'), 'attendance.date', 'attendance.attendance_type','attendance.minutes', 'attendance.reason')
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {

            $actionhtml = '';
            $actionhtml .= '<a href="' . route('admin.attendance.day-edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';
            if ($row['attendance_type'] == '0') {
                $attendance_type = '<span class="label label-lg label-light-success label-inline">Present</span>';
            } else if ($row['attendance_type'] == '1') {
                $attendance_type = '<span class="label label-lg label-light-danger label-inline">Absent</span>';
            } else if ($row['attendance_type'] == '2') {
                $attendance_type = '<span class="label label-lg label-light-warning label-inline">Half Day</span>';
            } else {
                $attendance_type = '<span class="label label-lg label-light-info  label-inline">Short Leave</span>';
            }
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = date_formate($row['date']);
            $nestedData[] = $row['fullName'];
            $nestedData[] = $attendance_type;
            $nestedData[] = $row['minutes'];
            if (strlen($row['reason']) > $max_length) {
                $nestedData[] = substr($row['reason'], 0, $max_length) . '...' ?? '-';
            } else {
                $nestedData[] = $row['reason'] ?? '-'; // If it's not longer than max_length, keep it as is
            }
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

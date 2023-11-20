<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Exists;
use DB;
use Doctrine\DBAL\Query;

class Attendance extends Model
{
    use HasFactory;
    protected $table = "attendance";

    public function getdatatable($fillterdata)
    {
        $dateObject = Carbon::createFromFormat('d-M-Y', $fillterdata['date']);
        $outputDate = $dateObject->format('Y-m-d');
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'attendance.id',
            1 => 'attendance.date',
            2 => 'employee.first_name',
            3 => DB::raw('(CASE WHEN attendance.attendance_type = "o" THEN "Actived"
                                WHEN attendance.attendance_type = "1" THEN "Absent"
                                WHEN attendance.attendance_type = "2" THEN "Half Day"
                                ELSE "Sort Leave" END)'),
            4 => 'attendance.reason',
        );

        // $query = Attendance::from('attendance')
        //     ->join("employee", "employee.id", "=", "attendance.employee_id")
        //     ->where("attendance.date", "=", "2023-11-16");

        if($outputDate != null && $outputDate != ''){
            $query = Attendance::from('attendance')
            ->join("employee", "employee.id", "=", "attendance.employee_id")
            ->where("attendance.date", $outputDate);
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
            ->select('attendance.id', 'employee.first_name','attendance.date','attendance.attendance_type','attendance.reason')
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {

            $actionhtml = '';
            $actionhtml .= '<a href="' . route('admin.attendance.view', $row['id']) . '" class="btn btn-icon"><i class="fa fa-eye text-primary"> </i></a>';
            $actionhtml .= '<a href="' . route('admin.attendance.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';
            if ($row['attendance_type'] == '0') {
                $attendance_type = '<span class="label label-lg label-light-success label-inline">Present</span>';
                $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deactiveModel" class="btn btn-icon  deactive-records" data-id="' . $row["id"] . '" ><i class="fa fa-times text-primary" ></i></a>';
            } else if($row['attendance_type'] == '1'){
                $attendance_type = '<span class="label label-lg label-light-success label-inline">Absent</span>';
                $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deactiveModel" class="btn btn-icon  deactive-records" data-id="' . $row["id"] . '" ><i class="fa fa-times text-primary" ></i></a>';
            } else if($row['attendance_type'] == '2'){
                $attendance_type = '<span class="label label-lg label-light-success label-inline">Half Day</span>';
                $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deactiveModel" class="btn btn-icon  deactive-records" data-id="' . $row["id"] . '" ><i class="fa fa-times text-primary" ></i></a>';
            } else {
                $attendance_type = '<span class="label label-lg label-light-danger  label-inline">Sort Leave</span>';
                $actionhtml .= '<a href="#" data-toggle="modal" data-target="#activeModel" class="btn btn-icon  active-records" data-id="' . $row["id"] . '" ><i class="fa fa-check text-primary" ></i></a>';
            }
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = date_formate($row['date']);
            $nestedData[] = $row['first_name'];
            $nestedData[] = $attendance_type;
            if (strlen($row['reason']) > $max_length) {
                $nestedData[] = substr($row['reason'], 0, $max_length) . '...' ?? '-';
            }else {
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

    public function saveAdd($requestData)
    {
        $employee = Employee::where("is_deleted", "N")->pluck('id')->toArray();
        $employeeId = $requestData->employee_id;

        $matchValue = array_intersect($employee, $employeeId);

        $checkAttendance = Attendance::from('attendance')
        ->where('Attendance.employee_id', $requestData['employee_id'])
        ->count();
        if($checkAttendance == 0){

        if($matchValue ){
        foreach ($employee as $employeeNameKey => $value) {
            $objAttendance = new Attendance();
            $objAttendance->employee_id = $value;
            if(in_array( $value, $requestData->employee_id)){
                $key = array_search ($value, $requestData->employee_id);
                $objAttendance->attendance_type = $requestData->input('leave_type')[$key];
                $objAttendance->reason = $requestData->input('reason')[$key];
                $objAttendance->date = date('Y-m-d', strtotime($requestData['date']));
            }else{
                $objAttendance->date = date('Y-m-d', strtotime($requestData['date']));
                $objAttendance->attendance_type = "0";
                $objAttendance->reason = NULL;
            }
            $objAttendance->created_at = date('Y-m-d H:i:s');
            $objAttendance->updated_at = date('Y-m-d H:i:s');
            $objAttendance->save();
            }
            if($objAttendance->save()){
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $requestData, 'Attendance');
                return 'added';
            }else{
                return 'wrong';
            }
        }
    }
    return 'attendance_exists';
    }

    public function common_activity($requestData)
    {

        $objtype = Type::find($requestData['id']);
        if ($requestData['activity'] == 'delete-records') {
            $objtype->is_deleted = "Y";
            $event = 'D';
        }

        if ($requestData['activity'] == 'active-records') {
            $objtype->status = "A";
            $event = 'A';
        }

        if ($requestData['activity'] == 'deactive-records') {
            $objtype->status = "I";
            $event = 'DA';
        }

        $objtype->updated_at = date("Y-m-d H:i:s");
        if ($objtype->save()) {
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'type');
            return true;
        } else {
            return false;
        }
    }

    public function get_admin_attendance_details(){

        $month = '2023-11';
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();
        $period = CarbonPeriod::create($start, $end);

        $index = 0; // Initialize the index

        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');

            $dates[$index]['date'] = $formattedDate;
            $dates[$index]['present'] = Attendance::from('attendance')
                ->where('attendance_type', '0')
                ->where('date', $formattedDate)
                ->count();

            $dates[$index]['absent'] = Attendance::from('attendance')
                ->where('attendance_type', '1')
                ->where('date', $formattedDate)
                ->count();

            $dates[$index]['half_day'] = Attendance::from('attendance')
                ->where('attendance_type', '2')
                ->where('date', $formattedDate)
                ->count();

            $dates[$index]['sort_leave'] = Attendance::from('attendance')
                ->where('attendance_type', '3')
                ->where('date', $formattedDate)
                ->count();

            $index++;
        }

        return $dates;

    }


    public function get_admin_attendance_details_by_day(){
        return Attendance::from('attendance')
        ->select('id','date','employee_id','attendance_type','reason')
        ->get();
    }
}

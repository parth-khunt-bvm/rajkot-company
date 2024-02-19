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
            2 => DB::raw('CONCAT(first_name, " ", last_name)'),
            3 => DB::raw('(CASE WHEN attendance.attendance_type = "0" THEN "Actived"
                                WHEN attendance.attendance_type = "1" THEN "Absent"
                                WHEN attendance.attendance_type = "2" THEN "Half Day"
                                ELSE "Short Leave" END)'),
            4 => 'attendance.reason',
        );
        if ($outputDate != null && $outputDate != '') {
            $query = Attendance::from('attendance')
                ->join("employee", "employee.id", "=", "attendance.employee_id")
                ->join("branch", "branch.id", "=", "employee.branch")
                ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
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
            ->select('attendance.id', DB::raw('CONCAT(first_name, " ", last_name) as fullName'), 'attendance.date', 'attendance.attendance_type', 'attendance.reason')
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
    public function getreportdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 =>  DB::raw('CONCAT(first_name, " ", last_name)'),
            1 => 'technology.technology_name',
            // 2 => DB::raw('COUNT(date) as total'),
        );
        $query = Attendance::from('attendance')
            ->join("employee", "employee.id", "=", "attendance.employee_id")
            ->join('technology', 'technology.id', '=', 'employee.department')
            ->whereMonth('date', $fillterdata['month'])
            ->whereYear('date', $fillterdata['year']);

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
            ->select(
                DB::raw('CONCAT(first_name, " ", last_name) as fullname'),
                'technology.technology_name',
                DB::raw("(SELECT COUNT('id')  FROM attendance WHERE attendance_type='0') as presentEmp ")
            )
            ->get();
        ccd($resultArr);
        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {

            $actionhtml = '';
            // $actionhtml .= '<a href="' . route('admin.attendance.day-edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';
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

            $present = $row['present_days'] * 8;
            $half_leave = $row['half_leaves'] * 4;
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['fullname'];
            $nestedData[] = $row['technology_name'];
            $nestedData[] = $row['total_days'];
            $nestedData[] = $row['totalPresendDay'];
            $nestedData[] = $row['full_leaves'];
            $nestedData[] = $row['half_leaves'];
            $nestedData[] = $row['half_leaves'];
            $nestedData[] = $row['half_leaves'];
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
        $holidayCount = PublicHoliday::where('public_holiday.date', date('Y-m-d', strtotime($requestData['date'])))->count();
        if ($holidayCount == 1) {
            return 'holiday_day';
        }

        $employee = Employee::from('employee')
            ->join("branch", "branch.id", "=", "employee.branch")
            ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
            ->where("employee.status", "=", "W")
            ->where("employee.is_deleted", "=", "N")
            ->pluck('employee.id')->toArray();

        $employeeId = $requestData->employee_id;

        $checkAttendance = Attendance::from('attendance')
            ->join("employee", "employee.id", "=", "attendance.employee_id")
            ->join("branch", "branch.id", "=", "employee.branch")
            ->where('attendance.date', date('Y-m-d', strtotime($requestData['date'])))
            ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
            ->count();

        $allPresent = $requestData['all_present'];
        if ($checkAttendance == 0) {

            foreach ($employee as $employeeNameKey => $value) {
                $objAttendance = new Attendance();
                $objAttendance->employee_id = $value;
                if ($allPresent) {
                    $objAttendance->attendance_type = "0";
                    $objAttendance->reason = NULL;
                } else
                    if (in_array($value, $requestData->employee_id)) {
                    $key = array_search($value, $requestData->employee_id);
                    $objAttendance->attendance_type = $requestData->input('leave_type')[$key];
                    $objAttendance->reason = $requestData->input('reason')[$key];
                    $objAttendance->date = date('Y-m-d', strtotime($requestData['date']));
                } else {
                    $objAttendance->date = date('Y-m-d', strtotime($requestData['date']));
                    $objAttendance->attendance_type = "0";
                    $objAttendance->reason = NULL;
                }
                $objAttendance->date = date('Y-m-d', strtotime($requestData['date']));
                $objAttendance->created_at = date('Y-m-d H:i:s');
                $objAttendance->updated_at = date('Y-m-d H:i:s');
                $objAttendance->save();
            }
            if ($objAttendance->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $inputData, 'Attendance');
                return 'added';
            } else {
                return 'wrong';
            }
        }
        return 'attendance_exists';
    }
    public function empSaveAdd($requestData)
    {
        $holidayCount = PublicHoliday::where('public_holiday.date', date('Y-m-d', strtotime($requestData['date'])))->count();
        if ($holidayCount == 1) {
            return 'holiday_day';
        }

        $employeeId = $requestData->employee_id;

        $checkAttendance = Attendance::from('attendance')
            ->join("employee", "employee.id", "=", "attendance.employee_id")
            ->join("branch", "branch.id", "=", "employee.branch")
            ->where('attendance.date', date('Y-m-d', strtotime($requestData['date'])))
            ->where('attendance.employee_id', $requestData['employee_id'])
            ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
            ->count();

        if ($checkAttendance == 0) {

            foreach ($requestData['employee_id'] as $employeeNameKey => $value) {
                $objAttendance = new Attendance();
                $objAttendance->employee_id = $value;

                if (in_array($value, $requestData->employee_id)) {
                    $key = array_search($value, $requestData->employee_id);
                    $objAttendance->attendance_type = $requestData->input('leave_type')[$key];
                    $objAttendance->reason = $requestData->input('reason')[$key];
                    $objAttendance->date = date('Y-m-d', strtotime($requestData['date']));
                } else {
                    $objAttendance->date = date('Y-m-d', strtotime($requestData['date']));
                    $objAttendance->attendance_type = "0";
                    $objAttendance->reason = NULL;
                }
                $objAttendance->date = date('Y-m-d', strtotime($requestData['date']));
                $objAttendance->created_at = date('Y-m-d H:i:s');
                $objAttendance->updated_at = date('Y-m-d H:i:s');
                $objAttendance->save();
            }
            if ($objAttendance->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $inputData, 'Attendance');
                return 'added';
            } else {
                return 'wrong';
            }
        }
        return 'attendance_exists';
    }
    public function daySaveEdit($requestData)
    {
        $objattendance = Attendance::find($requestData['attendance_id']);
        $objattendance->date = date('Y-m-d', strtotime($requestData['date']));
        $objattendance->attendance_type = $requestData['leave_type'];
        $objattendance->reason = $requestData['reason'];
        $objattendance->updated_at = date('Y-m-d H:i:s');
        if ($objattendance->save()) {
            $inputData = $requestData->input();
            unset($inputData['_token']);
            $objAudittrails = new Audittrails();
            $objAudittrails->add_audit('U', $inputData, 'Attendance');
            return 'added';
        }
        return 'wrong';
    }
    public function get_attendance_details($attendanceId)
    {
        return Attendance::from('attendance')
            ->join("employee", "employee.id", "=", "attendance.employee_id")
            ->select('attendance.id', 'attendance.date', 'attendance.attendance_type', 'attendance.reason', 'attendance.employee_id')
            ->where('attendance.id', $attendanceId)
            ->first();
    }
    public function common_activity($requestData)
    {
        $objAttendance =  Attendance::find($requestData['id']);
        if ($requestData['activity'] == 'delete-records') {
            $objAttendance->where('id',$requestData['id'])->delete();
            $event = 'D';
        }

        $objAttendance->updated_at = date("Y-m-d H:i:s");
        if ($objAttendance->save()) {
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'Attendance');
            return true;
        } else {
            return false;
        }

    }
    public function get_admin_attendance_details($requestData)
    {
        $month = $requestData['year'] . '-' . $requestData['month'];
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();
        $period = CarbonPeriod::create($start, $end);

        $index = 0; // Initialize the index
        $dates = [];
        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');
            // dd($formattedDate);
            // if($formattedDate <= date('Y-m-d') && date('w', strtotime($formattedDate)) != 6 && date('w', strtotime($formattedDate)) != 0){
            if ($formattedDate <= date('Y-m-d')) {
                $dates[$index]['date'] = $formattedDate;

                $isHoliday = PublicHoliday::from('public_holiday')
                    ->where('date', $formattedDate)
                    ->where('is_deleted', "N")
                    ->select('holiday_name')
                    ->first();

                if (!empty($isHoliday)) {
                    $dates[$index]['is_holiday'] = $isHoliday['holiday_name'];
                    $dates[$index]['emp_overtime'] = EmployeeOvertime::from('emp_overtime')
                        ->join("employee", "employee.id", "=", "emp_overtime.employee_id")
                        ->where('date', $formattedDate)
                        ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
                        ->count();
                } else {
                    $dates[$index]['present'] = Attendance::from('attendance')
                        ->join("employee", "employee.id", "=", "attendance.employee_id")
                        ->join("branch", "branch.id", "=", "employee.branch")
                        ->where('attendance_type', '0')
                        ->where('date', $formattedDate)
                        ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
                        ->count();

                    $dates[$index]['absent'] = Attendance::from('attendance')
                        ->join("employee", "employee.id", "=", "attendance.employee_id")
                        ->join("branch", "branch.id", "=", "employee.branch")
                        ->where('attendance_type', '1')
                        ->where('date', $formattedDate)
                        ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
                        ->count();

                    $dates[$index]['half_day'] = Attendance::from('attendance')
                        ->join("employee", "employee.id", "=", "attendance.employee_id")
                        ->join("branch", "branch.id", "=", "employee.branch")
                        ->where('attendance_type', '2')
                        ->where('date', $formattedDate)
                        ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
                        ->count();

                    $dates[$index]['sort_leave'] = Attendance::from('attendance')
                        ->join("employee", "employee.id", "=", "attendance.employee_id")
                        ->join("branch", "branch.id", "=", "employee.branch")
                        ->where('attendance_type', '3')
                        ->where('date', $formattedDate)
                        ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
                        ->count();

                    $dates[$index]['emp_overtime'] = EmployeeOvertime::from('emp_overtime')
                        ->join("employee", "employee.id", "=", "emp_overtime.employee_id")
                        ->where('date', $formattedDate)
                        ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
                        ->count();
                }
            }

            $index++;
        }
        return $dates;
    }

    public function get_attendance_details_by_employee($employeeId, $month, $year)
    {
        $month = $year . '-' . $month;
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();

        $period = CarbonPeriod::create($start, $end);

        $dates = [];
        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');
            if ($formattedDate <= date('Y-m-d')) {
                $isHoliday = PublicHoliday::from('public_holiday')
                    ->where('date', $formattedDate)
                    ->where('is_deleted', 'N')
                    ->select('holiday_name')
                    ->first();

                $dates[] = [
                    'date' => $formattedDate,
                    'attendance_type' => null, // Default value for attendance type
                    'class' => null, // Default value for class
                    'description' => null, // Default value for description
                    'is_holiday' => !empty($isHoliday) ? $isHoliday->holiday_name : "null", // Holiday data
                    'emp_overtime' => EmployeeOvertime::from('emp_overtime')
                        ->join('employee', 'employee.id', '=', 'emp_overtime.employee_id')
                        ->where('date', $formattedDate)
                        ->where('emp_overtime.employee_id', $employeeId)
                        ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
                        ->sum('hours'), // Employee overtime data
                ];
            }
        }

        $attendanceData = Attendance::from('attendance')
            ->select('attendance.date', 'attendance.attendance_type', 'attendance.reason')
            ->where('attendance.employee_id', $employeeId)
            ->whereDate('date', '>=', $start)
            ->whereDate('date', '<=', $end)
            ->get();

        foreach ($attendanceData as $value) {
            $dateIndex = array_search($value->date, array_column($dates, 'date')); // No need to format here
            if ($dateIndex !== false) {
                switch ($value->attendance_type) {
                    case 0:
                        $attendance_type = 'Present';
                        $className = 'fc-event-success';
                        $description = $value->reason;
                        break;
                    case 1:
                        $attendance_type = 'Absent';
                        $className = 'fc-event-danger';
                        $description = $value->reason;
                        break;
                    case 2:
                        $attendance_type = 'Half Leave';
                        $className = 'fc-event-info';
                        $description = $value->reason;
                        break;
                    default:
                        $attendance_type = 'Short Leave';
                        $className = 'fc-event-warning';
                        $description = $value->reason;
                        break;
                }
                $dates[$dateIndex]['attendance_type'] = $attendance_type;
                $dates[$dateIndex]['class'] = $className;
                $dates[$dateIndex]['description'] = $description;
            }
        }

        return $dates;
    }
    public function get_admin_attendance_details_by_day()
    {
        return Attendance::from('attendance')
            ->select('id', 'date', 'employee_id', 'attendance_type', 'reason')
            ->get();
    }
    public function get_admin_attendance_daily_detail()
    {

        $formattedDate = date("Y-m-d");

        $data['attendance'] = Attendance::from('attendance')
            ->leftjoin("employee", "employee.id", "=", "attendance.employee_id")
            ->leftjoin("branch", "branch.id", "=", "employee.branch")
            ->selectRaw('
                SUM(CASE WHEN attendance.attendance_type = "0" THEN 1 ELSE 0 END) AS present,
                SUM(CASE WHEN attendance.attendance_type = "1" THEN 1 ELSE 0 END) AS absent,
                SUM(CASE WHEN attendance.attendance_type = "2" THEN 1 ELSE 0 END) AS half_day,
                SUM(CASE WHEN attendance.attendance_type = "3" THEN 1 ELSE 0 END) AS short_leave
            ')
            ->where('attendance.date', $formattedDate)
            ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
            ->where("employee.is_deleted", "=", "N")
            ->where("employee.status", "=", "W")
            ->first();
        $formattedDate = now()->format('Y-m-d');
        $monthDayFormat = now()->format('m-d');

        $data['employee'] = Employee::selectRaw('
                    COUNT(*) AS employee_count,
                    SUM(CASE WHEN DATE_FORMAT(DOB, "%m-%d") = ? THEN 1 ELSE 0 END) AS birthday_count,
                    SUM(CASE WHEN bond_last_date = ? THEN 1 ELSE 0 END) AS bond_last_date_count
                ', [$monthDayFormat, $formattedDate])
            ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
            ->where("employee.is_deleted", "=", "N")
            ->where("employee.status", "=", "W")
            ->first();

        return $data;
    }
}

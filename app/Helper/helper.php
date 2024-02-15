<?php

use App\Models\Attendance;
use App\Models\Codenumber;
use App\Models\CompanyInfo;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\PublicHoliday;
use Faker\Provider\ar_EG\Company;

function numberformat($value, $comma =  null){
    return number_format((float)$value, 2, '.', $comma ? $comma : '');
}

function date_formate($date){
    return date("d-M-Y", strtotime($date));
}

function check_value($value){
    if($value == null || $value == ''){
        return number_format(0.000, 3, '.', '');
    }else{
        return (number_format($value, 3, '.', ''));
    }
}

function ccd($data){
    echo "<pre>";
    print_r($data);
    die();
}

function get_company_info(){
    $objCompanyinfo = new CompanyInfo();
   return $objCompanyinfo->get_company_info(1);
}

function get_system_details(){
    $objCompanyinfo = new CompanyInfo();
    return $objCompanyinfo->get_system_details(1);
}

function get_users_permission($userId){
    $objUsersroles = new UserRole();
    return $objUsersroles->get_user_permission_details($userId);
}

function get_no_by_name($no_for){
    $objCodenumber = new Codenumber();
    return $objCodenumber->get_no_by_name($no_for);
}
function auto_increment_no($no_for){
    $objCodenumber = new Codenumber();
    $res = $objCodenumber->auto_increment_no($no_for);
}

function user_branch($inArray = false){

    $qurey =  Branch::from('branch');

    if(Auth()->guard('admin')->user()->is_admin != 'Y'){
        $qurey->join("user_branch", "user_branch.branch_id", "=", "branch.id");
        $qurey->join("users", "users.id", "=", "user_branch.user_id");
        $qurey->where("users.id", "=", Auth()->guard('admin')->user()->id);
    }
    $result = $qurey->select("branch.branch_name", "branch.id")
                ->where("branch.status", "=", "A")
                ->where("branch.is_deleted", "=", "N")
                ->get()->toArray();
    if($inArray == false){
        return $result;
    } else{
        $branchIdArray = [];
        foreach ($result as $key => $value) {
           array_push($branchIdArray, $value['id']);
        }
        return $branchIdArray;
    }

}

function salaryCount($month ,$year, $employeeIdArray, $employeeArray = false){

    $firstDate = $year . '-' . $month . '-01';
    $lastDate = date('t', strtotime($firstDate));
    for ($d = 1; $d <= $lastDate; $d++) {
        $time = mktime(12, 0, 0, $month, $d, $year);
        if (date('D', $time) != "Sat" && date('D', $time) != "Sun") {
            // echo date('D', $time) . "<br>"; // Echo day name
            $days[] = date('Y-m-d H:i:s', $time); // Store dates in array if not Saturday or Sunday
        }
    }

    $numberOfDays = count($days);
    $holidayCount = PublicHoliday::whereYear('public_holiday.date', $year)->whereMonth('public_holiday.date', $month)->count();
    $working_day = $numberOfDays - $holidayCount;


    if($employeeArray == false){

        $employeeIds = Employee::from('employee')
        ->join("technology", "technology.id", "=", "employee.department")
        ->join("branch", "branch.id", "=", "employee.branch")
        ->join("designation", "designation.id", "=", "employee.designation")
        ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']] )
        ->where("employee.is_deleted", "=", "N")
        ->where("employee.status", "=", "W")
        ->pluck('employee.id')
        ->toArray();

        $attendanceCounts = [];

        foreach ($employeeIds as $key =>$employeeId) {
            $query = Attendance::from('attendance')
                ->join("employee", "employee.id", "=", "attendance.employee_id")
                ->join("technology", "technology.id", "=", "employee.department")
                ->join("designation", "designation.id", "=", "employee.designation")
                ->join("branch", "branch.id", "=", "employee.branch")
                ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
                ->whereYear('attendance.date', $year)
                ->whereMonth('attendance.date', $month)
                ->where("attendance.employee_id", $employeeId);

            $presentQuery = clone $query;
            $attendanceCounts[$key]['present'] = $presentQuery->where("attendance.attendance_type", "0")->count();

            $absentQuery = clone $query;
            $attendanceCounts[$key]['absent'] = $absentQuery->where("attendance.attendance_type", "1")->count();

            $halfDayQuery = clone $query;
            $attendanceCounts[$key]['half_day'] = $halfDayQuery->where("attendance.attendance_type", "2")->count();

            $sortLeaveQuery = clone $query;
            $attendanceCounts[$key]['sort_leave'] = $sortLeaveQuery->where("attendance.attendance_type", "3")->count();

            $attendanceCounts[$key]['working_day'] =  $working_day;

            $employeeQuery = clone $query;
            $employee = $employeeQuery->select('employee.id','employee.first_name','employee.last_name','technology.technology_name','designation.designation_name','branch.branch_name','employee.salary')->first();

            // dd($employee);

            if ($employee !== null) {
                $attendanceCounts[$key]['employee'] = $employee->toArray();
            } else {
                // Handle the case where the employee attendance does not exist
                $attendanceCounts[$key]['employee'] = null; // Or any other appropriate action
            }

            if($attendanceCounts[$key]['present'] >= 15){
                // $working_day /
            }
        }
        ccd($attendanceCounts);
        return $attendanceCounts;

    }else {

        $query = Attendance::from('attendance')
        ->join("employee", "employee.id", "=", "attendance.employee_id")
        ->join("technology", "technology.id", "=", "employee.department")
        ->join("designation", "designation.id", "=", "employee.designation")
        ->join("branch", "branch.id", "=", "employee.branch")
        ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
        ->whereYear('attendance.date', $year)
        ->whereMonth('attendance.date', $month)
        ->where("attendance.employee_id", $employeeIdArray);

      $attendanceCounts = [];

      $presentQuery = clone $query;
      $attendanceCounts['present_query'] = $presentQuery->where("attendance.attendance_type", "0")
                      ->count();

      $absentQuery = clone $query;
      $attendanceCounts['absent_query'] = $absentQuery->where("attendance.attendance_type", "1")
                      ->count();

      $halfDayQuery = clone $query;
      $attendanceCounts['half_day_query'] = $halfDayQuery->where("attendance.attendance_type", "2")
                      ->count();

      $sortLeaveQuery = clone $query;
      $attendanceCounts['sort_leave_query'] = $sortLeaveQuery->where("attendance.attendance_type", "3")
                      ->count();

      $attendanceCounts['working_day'] =  $working_day;

            $employeeQuery = clone $query;
            $employee = $employeeQuery->select('employee.id','employee.first_name','employee.last_name','technology.technology_name','designation.designation_name','branch.branch_name','employee.salary')->first();

            if ($employee !== null) {
                $attendanceCounts['employee'] = $employee->toArray();
            } else {
                // Handle the case where the employee attendance does not exist
                $attendanceCounts['employee'] = null; // Or any other appropriate action
            }

      ccd($attendanceCounts);
      return $attendanceCounts;
    }


}
?>

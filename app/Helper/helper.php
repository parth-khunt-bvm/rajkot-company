<?php

use App\Models\Attendance;
use App\Models\Codenumber;
use App\Models\CompanyInfo;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\LatterAbbreviation;
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

function salaryCount($salary, $workingDay, $present, $absent, $halfLeave, $shortLeave){

    $totalPaidAmount = 0;
    $totalLossOfPay = 0;
    $paidHours = 0;
    $absentHours  = 0;
    $perDaySalay = numberformat($salary/$workingDay);
    $perHourSalay = numberformat($perDaySalay/8);
    $presentDaySalay = numberformat($present*$perDaySalay);

    if($present > 15){
        $paidHours = 8;
    }

    $absentHours  = numberformat($absent*8) + numberformat($halfLeave*4) + numberformat($shortLeave > 2 ? $shortLeave*2 : 0);
    $totalAbsentHours = numberformat($absentHours - $paidHours);

    if($totalAbsentHours > 0){
        $salaryDeduction = numberformat($salary) - numberformat($totalAbsentHours * $perHourSalay);
    } else {
        $salaryDeduction = numberformat($salary);
    }

    // echo "<pre>";
    // print_r("perDaySalay =".$perDaySalay);
    // print_r("<br>");
    // print_r("perHourSalay =".$perHourSalay);
    // print_r("<br>");
    // print_r("presentDaySalay =".$presentDaySalay);
    // print_r("<br>");
    // print_r("absentHours =".$absentHours);
    // print_r("<br>");
    // print_r("totalAbsentHours =".$totalAbsentHours);
    // print_r("<br>");
    // print_r("salaryDeduction =".$salaryDeduction);
    // die();

}

function stringReplace(){

   $latter_abbreviation  = LatterAbbreviation::all()->toArray();

   $employee = Employee::all()->toArray();

   ccd($employee);

}
?>

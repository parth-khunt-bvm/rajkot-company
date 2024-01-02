<?php

use App\Models\Codenumber;
use App\Models\CompanyInfo;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Branch;
use Faker\Provider\ar_EG\Company;
function numberformat($value, $afterDecimal = 4){
    return number_format((float)$value, $afterDecimal,'.', '');
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

function user_branch(){

    $qurey =  Branch::from('branch');

    if(Auth()->guard('admin')->user()->is_admin != 'Y'){
        $qurey->join("user_branch", "user_branch.branch_id", "=", "branch.id");
        $qurey->join("users", "users.id", "=", "user_branch.user_id");
        $qurey->where("users.id", "=", Auth()->guard('admin')->user()->id);
    }
    return $qurey->select("branch.branch_name", "branch.id")
                ->where("branch.status", "=", "A")
                ->where("branch.is_deleted", "=", "N")
                ->get()->toArray();
}
?>

<?php

use App\Models\CompanyInfo;
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

?>

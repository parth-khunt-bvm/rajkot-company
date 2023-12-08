<?php

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

?>

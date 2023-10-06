<?php

function numberformat($value, $afterDecimal = 4){
    return number_format((float)$value, $afterDecimal,'.', '');
}

function date_formate($date){
    return date("d-M-Y", strtotime($date));
}
function ccd($data){
    echo "<pre>";
    print_r($data);
    die();
}

?>

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpTimeTracking extends Model
{
    use HasFactory;

    protected $table = 'time_tracking';

    public function storeStart($requestData)
    {
        $EmpTimeTraking = new EmpTimeTracking();
        $EmpTimeTraking->employee_id = Auth()->guard('employee')->user()->id;
        $EmpTimeTraking->start_time = date('Y-m-d H:i:s');
        $EmpTimeTraking->end_time = "";
        $EmpTimeTraking->created_at = date('Y-m-d H:i:s');
        $EmpTimeTraking->updated_at = date('Y-m-d H:i:s');

        if ($EmpTimeTraking->save()) {
            $inputData = $requestData->input();
            unset($inputData['_token']);
            $objAudittrails = new Audittrails();
            $objAudittrails->add_audit("I", $inputData, 'Time Traking   ');
            return 'added';
        } else {
            return 'wrong';
        }
    }
}

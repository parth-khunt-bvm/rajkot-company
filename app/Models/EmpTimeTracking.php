<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpTimeTracking extends Model
{
    use HasFactory;

    protected $table = 'time_tracking';

    public function storeStartTime($requestData)
    {
        $dt = new DateTime();
        $dt->setTimezone(new DateTimeZone('Asia/Kolkata'));
        $indianDateTime = $dt->format('Y-m-d H:i:s');

        $EmpTimeTraking = new EmpTimeTracking();
        $EmpTimeTraking->employee_id = Auth()->guard('employee')->user()->id;
        $EmpTimeTraking->start_time = $indianDateTime;
        $EmpTimeTraking->end_time = "";
        $EmpTimeTraking->created_at = $indianDateTime;
        $EmpTimeTraking->updated_at = $indianDateTime;

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

    public function storeStopTime($requestData)
    {
        $dt = new DateTime();
        $dt->setTimezone(new DateTimeZone('Asia/Kolkata'));
        $indianDateTime = $dt->format('Y-m-d H:i:s');

        $EmpTimeTracking = EmpTimeTracking::where('employee_id', Auth()->guard('employee')->user()->id)
            ->whereNotNull('start_time')
            ->whereNull('end_time')
            ->latest()
            ->first();

        if ($EmpTimeTracking) {
            $EmpTimeTracking->end_time = $indianDateTime;
            $EmpTimeTracking->updated_at = $indianDateTime;

            if ($EmpTimeTracking->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $inputData, 'Time Tracking');
                return 'updated';
            } else {
                return 'wrong';
            }
        } else {
            return 'No ongoing time tracking found.';
        }
    }
}

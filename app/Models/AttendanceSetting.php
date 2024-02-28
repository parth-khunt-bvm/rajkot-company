<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSetting extends Model
{
    use HasFactory;

    protected $table = "attendance_setting";


    public function updateAttendanceSetting($requestData){
        $data = Auth()->guard('admin')->user();

        $result = AttendanceSetting::select('id')->where('id',1)->get()->toArray();
        if(!empty($result)){
            $objAttendanceSetting = AttendanceSetting::find($data['id']);
        }else{
            $objAttendanceSetting = new AttendanceSetting();
        }
        $objAttendanceSetting->allowed_hours = $requestData->input('allowed_hours');
        $objAttendanceSetting->updated_at = date("Y-m-d H:i:s");
        if($objAttendanceSetting->save()){
            $objAudittrails = new Audittrails();
            $objAudittrails->add_audit("U", $requestData->all(), 'Attendance Setting');
            return 'success';
        }else{
            return false;
        }
    }

    public function get_attendance_details($id){
        $result = AttendanceSetting::select('allowed_hours')
                            ->where('id',$id)
                            ->get()->toArray();

        if(empty($result)){
            $result[0]['allowed_hours'] = '0';
        }

        return $result;
    }
}

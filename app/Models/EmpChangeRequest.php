<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpChangeRequest extends Model
{
    use HasFactory;

    protected $table = 'change_request';

    public function savePersonalInfo($request)
    {

        $countEmployee = Employees::where("gmail", $request->input('gmail'))
            ->where("id", '!=', $request->input('edit_id'))
            ->count();

        if ($countEmployee == 0) {

            $objEmpChangeRequest = Employees::find($request->input('edit_id'));
            if ($objEmpChangeRequest->first_name != $request['first_name'] || $objEmpChangeRequest->last_name != $request['last_name'] || $objEmpChangeRequest->branch != $request['branch'] || $objEmpChangeRequest->department != $request['technology'] || $objEmpChangeRequest->designation != $request['designation'] || $objEmpChangeRequest->DOB != date('Y-m-d', strtotime($request['dob'])) || $objEmpChangeRequest->DOJ != date('Y-m-d', strtotime($request['doj'])) || $objEmpChangeRequest->gmail != $request['gmail'] || $objEmpChangeRequest->gmail_password != $request['gmail_password'] || $objEmpChangeRequest->slack_password != $request['slack_password'] || $objEmpChangeRequest->personal_email != $request['personal_email']) {
                $data = $request->input();
                unset($data['_token']);
                $objEmpChangeRequest = new EmpChangeRequest();
                $objEmpChangeRequest->employee_id = Auth()->guard('employee')->user()->id;
                $objEmpChangeRequest->request_type = "1";
                $objEmpChangeRequest->data = json_encode($data);
                if ($objEmpChangeRequest->save()) {
                    $inputData = $request->input();
                    unset($inputData['_token']);
                    $objAudittrails = new Audittrails();
                    $objAudittrails->add_audit("U", $inputData, 'Update Personal Info');
                    return "change";
                }
            } else {
                return 'no_change';
            }
        } else {
            return "email_exist";
        }
    }

    public function saveBankInfo($request){

        $objEmpChangeRequest = Employees::find($request->input('edit_id'));
        if ($objEmpChangeRequest->bank_name != $request['bank_name'] || $objEmpChangeRequest->acc_holder_name != $request['acc_holder_name'] || $objEmpChangeRequest->account_number != $request['account_number'] || $objEmpChangeRequest->ifsc_number != $request['ifsc_code'] || $objEmpChangeRequest->pan_number != $request['pan_number'] || $objEmpChangeRequest->aadhar_card_number != $request['aadhar_card_number'] || $objEmpChangeRequest->google_pay_number != $request['google_pay'] ) {
            $data = $request->input();
            unset($data['_token']);
            $objChangeRequest = new EmpChangeRequest();
            $objChangeRequest->employee_id = Auth()->guard('employee')->user()->id;
            $objChangeRequest->request_type = "2";
            $objChangeRequest->data = json_encode($data);
            $objChangeRequest->save();

            if ($objEmpChangeRequest->save()) {
                $inputData = $request->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $inputData, 'Update Bank Info');
                return "change";
            }
        } else {
            return 'no_change';
        }
    }

    public function saveParentInfo($request){

        $objEmpChangeRequest = Employees::find($request->input('edit_id'));
        if ($objEmpChangeRequest->parents_name != $request['parent_name'] || $objEmpChangeRequest->personal_number != $request['personal_number'] || $objEmpChangeRequest->emergency_number != $request['emergency_contact'] || $objEmpChangeRequest->address != $request['address']) {
            $data = $request->input();
            unset($data['_token']);
            $objChangeRequest = new EmpChangeRequest();
            $objChangeRequest->employee_id = Auth()->guard('employee')->user()->id;
            $objChangeRequest->request_type = "3";
            $objChangeRequest->data = json_encode($data);
            $objChangeRequest->save();

            if ($objEmpChangeRequest->save()) {
                $inputData = $request->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $inputData, 'Update Parent Info');
                return "change";
            }
        } else {
            return 'no_change';
        }

    }

}

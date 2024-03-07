<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeRequest extends Model
{
    use HasFactory;

    protected $table = 'change_request';


    public function savePersonalInfo($request)
    {

        $countEmployee = Employees::where("gmail", $request->input('gmail'))
            ->where("id", '!=', $request->input('edit_id'))
            ->count();

        if ($countEmployee == 0) {

            $objEmployees = Employees::find($request->input('edit_id'));
            if ($objEmployees->first_name != $request['first_name'] || $objEmployees->last_name != $request['last_name'] || $objEmployees->branch != $request['branch'] || $objEmployees->department != $request['technology'] || $objEmployees->designation != $request['designation'] || $objEmployees->DOB != date('Y-m-d', strtotime($request['dob'])) || $objEmployees->DOJ != date('Y-m-d', strtotime($request['doj'])) || $objEmployees->gmail != $request['gmail'] || $objEmployees->gmail_password != $request['gmail_password'] || $objEmployees->slack_password != $request['slack_password'] || $objEmployees->personal_email != $request['personal_email'] || $objEmployees->status != $request['status']) {
                $data = $request->input();
                unset($data['_token']);
                $objChangeRequest = new ChangeRequest();
                $objChangeRequest->employee_id = Auth()->guard('employee')->user()->id;
                $objChangeRequest->request_type = "1";
                $objChangeRequest->data = json_encode($data);
                $objChangeRequest->save();

                if ($objEmployees->save()) {
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

        $objEmployees = Employees::find($request->input('edit_id'));
        if ($objEmployees->bank_name != $request['bank_name'] || $objEmployees->acc_holder_name != $request['acc_holder_name'] || $objEmployees->account_number != $request['account_number'] || $objEmployees->ifsc_number != $request['ifsc_code'] || $objEmployees->pan_number != $request['pan_number'] || $objEmployees->aadhar_card_number != $request['aadhar_card_number'] || $objEmployees->google_pay_number != $request['google_pay'] ) {
            $data = $request->input();
            unset($data['_token']);
            $objChangeRequest = new ChangeRequest();
            $objChangeRequest->employee_id = Auth()->guard('employee')->user()->id;
            $objChangeRequest->request_type = "2";
            $objChangeRequest->data = json_encode($data);
            $objChangeRequest->save();

            if ($objEmployees->save()) {
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

        $objEmployees = Employees::find($request->input('edit_id'));
        if ($objEmployees->parents_name != $request['parent_name'] || $objEmployees->personal_number != $request['personal_number'] || $objEmployees->emergency_number != $request['emergency_contact'] || $objEmployees->address != $request['address']) {
            $data = $request->input();
            unset($data['_token']);
            $objChangeRequest = new ChangeRequest();
            $objChangeRequest->employee_id = Auth()->guard('employee')->user()->id;
            $objChangeRequest->request_type = "3";
            $objChangeRequest->data = json_encode($data);
            $objChangeRequest->save();

            if ($objEmployees->save()) {
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

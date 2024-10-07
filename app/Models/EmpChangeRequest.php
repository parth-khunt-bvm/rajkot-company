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
        // dd($request);
        $countRequest = ChangeRequest::where("employee_id", $request->input('id'))->where("request_type", '1')->count();

        if ($countRequest === 0) {

            $countEmployee = Employees::where("gmail", $request->input('gmail'))
                ->where("id", '!=', $request->input('id'))
                ->count();

            // if ($countEmployee == 0) {

                $objEmpChangeRequest = Employees::find($request->input('id'));
                $request['DOB'] = $request['DOB'] != null && $request['DOB'] != '' ? date('Y-m-d', strtotime($request['DOB'])) : null;
                $request['DOJ'] = $request['DOJ'] != null && $request['DOJ'] != '' ? date('Y-m-d', strtotime($request['DOJ'])) : null;

                if (!isset($request['gmail_password']) && !isset($request['slack_password'])) {
                    $gmail_password = $request['old_gmail_password'];
                    $slack_password = $request['old_slack_password'];
                } else {
                    $gmail_password = $request['gmail_password'];
                    $slack_password = $request['slack_password'];
                }

                if ($objEmpChangeRequest->branch != $request['branch'] || $objEmpChangeRequest->department != $request['department'] || $objEmpChangeRequest->designation != $request['designation'] || $objEmpChangeRequest->DOB != $request['DOB'] || $objEmpChangeRequest->DOJ != $request['DOJ'] || $objEmpChangeRequest->gmail != $request['gmail'] || $objEmpChangeRequest->gmail_password != $gmail_password || $objEmpChangeRequest->slack_password != $slack_password || $objEmpChangeRequest->personal_email != $request['personal_email']) {
                    $data = $request->input();
                    unset($data['_token'], $data['old_gmail_password'], $data['old_slack_password']);
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
            // } else {
            //     return "email_exist";
            // }
        } else {
            return "change_request_exit";
        }
    }

    public function saveBankInfo($request)
    {
        $countRequest = ChangeRequest::where("employee_id", $request->input('id'))->where("request_type", '2')->count();

        if ($countRequest === 0) {
            $objEmpChangeRequest = Employees::find($request->input('id'));
            if ($objEmpChangeRequest->bank_name != $request['bank_name'] || $objEmpChangeRequest->acc_holder_name != $request['acc_holder_name'] || $objEmpChangeRequest->account_number != $request['account_number'] || $objEmpChangeRequest->ifsc_number != $request['ifsc_number'] || $objEmpChangeRequest->pan_number != $request['pan_number'] || $objEmpChangeRequest->aadhar_card_number != $request['aadhar_card_number'] || $objEmpChangeRequest->google_pay_number != $request['google_pay_number']) {
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
        } else {
            return "change_request_exit";
        }
    }

    public function saveParentInfo($request)
    {
        $countRequest = ChangeRequest::where("employee_id", $request->input('id'))->where("request_type", '3')->count();

        if ($countRequest === 0) {
            $objEmpChangeRequest = Employees::find($request->input('id'));
            if ($objEmpChangeRequest->parents_name != $request['parents_name'] || $objEmpChangeRequest->personal_number != $request['personal_number'] || $objEmpChangeRequest->emergency_number != $request['emergency_number'] || $objEmpChangeRequest->address != $request['address']) {
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
        } else {
            return "change_request_exit";
        }
    }
}

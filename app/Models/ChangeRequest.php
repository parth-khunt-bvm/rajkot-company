<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Doctrine\DBAL\Schema\Schema;
use Illuminate\Support\Facades\Schema as FacadesSchema;

class ChangeRequest extends Model
{
    use HasFactory;

    protected $table = 'change_request';

    public function getdatatable()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'change_request.id',
            1 => \DB::raw('CONCAT(employee.first_name, " ", employee.last_name)'),
            2 => DB::raw('(CASE WHEN change_request.request_type = "1" THEN "Persona Info"
                                WHEN change_request.request_type = "2" THEN "Bank Info"
                                ELSE "Parent Info" END)'),
            3 => 'branch.branch_name',
            4 => 'technology.technology_name',
            5 => 'designation.designation_name',
        );

        $query = ChangeRequest::from('change_request')
            ->join("employee", "employee.id", "=", "change_request.employee_id")
            ->join("branch", "branch.id", "=", "employee.branch")
            ->join("technology", "technology.id", "=", "employee.department")
            ->join("designation", "designation.id", "=", "employee.designation");

        if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchVal = $requestData['search']['value'];
            $query->where(function ($query) use ($columns, $searchVal, $requestData) {
                $flag = 0;
                foreach ($columns as $key => $value) {
                    $searchVal = $requestData['search']['value'];
                    if ($requestData['columns'][$key]['searchable'] == 'true') {
                        if ($flag == 0) {
                            $query->where($value, 'like', '%' . $searchVal . '%');
                            $flag = $flag + 1;
                        } else {
                            $query->orWhere($value, 'like', '%' . $searchVal . '%');
                        }
                    }
                }
            });
        }

        $temp = $query->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $totalData = count($temp->get());
        $totalFiltered = count($temp->get());

        $resultArr = $query->skip($requestData['start'])
            ->take($requestData['length'])
            ->select('change_request.id', 'change_request.employee_id', 'change_request.request_type', 'change_request.data', 'branch.branch_name', 'technology.technology_name', 'designation.designation_name', DB::raw('CONCAT(employee.first_name, " ", employee.last_name) as EmpName'))
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $target = [];
            $target = [149, 150];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
            $actionhtml = '';
            }

            if ($row['request_type'] == '1') {
                $request_type = '<span class="label label-lg label-light-info label-inline">Personal Info</span>';
            } else if ($row['request_type'] == '2') {
                $request_type = '<span class="label label-lg label-light-info label-inline">Bank Info</span>';
            } else {
                $request_type = '<span class="label label-lg label-light-info  label-inline">parent Info</span>';
            }
            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(150, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#changeRequestModel" class="btn btn-icon  change-requests delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-eye text-primary" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['EmpName'];
            $nestedData[] = $row['branch_name'];
            $nestedData[] = $row['technology_name'];
            $nestedData[] = $row['designation_name'];
            $nestedData[] = $request_type;
            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
            $nestedData[] = $actionhtml;
            }
            $data[] = $nestedData;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
        );
        return $json_data;
    }

    public function get_change_request_details($id)
    {
        return ChangeRequest::select('employee_id', 'data')->where('id', $id)->get();
    }
    public function get_employee_old_info_details($id, $empId)
    {
        $employeeColumns = FacadesSchema::getColumnListing('employee');
        $changeRequestData = ChangeRequest::from('change_request')
            ->select('data')
            ->where('id', $id)
            ->where('employee_id', $empId)
            ->first();

        $data = json_decode($changeRequestData->data, true);
        $filteredData = array_intersect_key($data, array_flip($employeeColumns));
        $employeeDetails = [];
        foreach ($filteredData as $key => $value) {
            $employeeDetail = Employee::where('id', $empId)->pluck($key)->first();
            $employeeDetails[$key] = $employeeDetail;
        }
        return $employeeDetails;
    }

    public function changeReqUpdate($request)
    {

        $objChangeRequest = ChangeRequest::where('change_request.employee_id', $request['emp_id'])->first();
        $data = json_decode($objChangeRequest->data, true);
        $objEmployee = Employee::find($request['emp_id']);
        $objEmployee->first_name = $data['first_name'];
        $objEmployee->last_name = $data['last_name'];
        $objEmployee->branch = $data['branch'];
        $objEmployee->department = $data['department'];
        $objEmployee->designation = $data['designation'];
        $objEmployee->DOB = $data['DOB'];
        $objEmployee->DOJ = $data['DOJ'];
        $objEmployee->gmail = $data['gmail'];
        $objEmployee->gmail_password = $data['gmail_password'];
        $objEmployee->slack_password = $data['slack_password'];
        $objEmployee->personal_email = $data['personal_email'];

        if ($objEmployee->save()) {
            $inputData = $request->input();
            unset($inputData['_token']);
            $objAudittrails = new Audittrails();
            $objAudittrails->add_audit("u", $inputData, 'Change Request Approved');
            $objChangeRequest->where('change_request.employee_id', $data['id'])->delete();
            return 'added';
        } else {
            return 'wrong';
        }
    }

    public function common_activity($requestData)
    {
        $objChangeRequest = ChangeRequest::find($requestData['id']);
        $data = json_decode($objChangeRequest->data, true);
        if ($requestData['activity'] == 'delete-records') {
             $req = $objChangeRequest['request_type'];
             if($req === "1"){
                ChangeRequest::where('employee_id',$data['id'])->where('request_type',"1")->delete();
             } else if($req == "2"){
                ChangeRequest::where('employee_id',$data['id'])->where('request_type',"2")->delete();
             } else if($req === "3"){
                ChangeRequest::where('employee_id',$data['id'])->where('request_type',"3")->delete();
             }
            $event = 'D';
        } else if ($requestData['activity'] == 'change-request-update') {
            if ($objChangeRequest['request_type'] === "1") {

                $objEmployee = Employee::find($objChangeRequest['employee_id']);
                $objEmployee->first_name = $data['first_name'];
                $objEmployee->last_name = $data['last_name'];
                $objEmployee->branch = $data['branch'];
                $objEmployee->department = $data['department'];
                $objEmployee->designation = $data['designation'];
                $objEmployee->DOB = date('Y-m-d', strtotime($data['DOB']));
                $objEmployee->DOJ = date('Y-m-d', strtotime($data['DOJ']));
                $objEmployee->gmail = $data['gmail'];
                $objEmployee->gmail_password = $data['gmail_password'];
                $objEmployee->slack_password = $data['slack_password'];
                $objEmployee->personal_email = $data['personal_email'];

                if ($objEmployee->save()) {
                    $objChangeRequest->where('change_request.id', $objChangeRequest['id'])->delete();
                    return 'success';
                } else {
                    return 'wrong';
                }

            } else if ($objChangeRequest['request_type'] === "2") {

                $objEmployee = Employee::find($objChangeRequest['employee_id']);
                $objEmployee->bank_name = $data['bank_name'];
                $objEmployee->acc_holder_name = $data['acc_holder_name'];
                $objEmployee->account_number = $data['account_number'];
                $objEmployee->ifsc_number = $data['ifsc_number'];
                $objEmployee->pan_number = $data['pan_number'];
                $objEmployee->aadhar_card_number = $data['aadhar_card_number'];
                $objEmployee->google_pay_number = $data['google_pay_number'];

                if ($objEmployee->save()) {
                    $objChangeRequest->where('change_request.id', $objChangeRequest['id'])->delete();
                    return 'success';
                } else {
                    return 'wrong';
                }
            } else if ($objChangeRequest['request_type'] === "3") {
                $objEmployee = Employee::find($objChangeRequest['employee_id']);
                $objEmployee->parents_name  = $data['parents_name'];
                $objEmployee->personal_number  = $data['personal_number'];
                $objEmployee->emergency_number  = $data['emergency_number'];
                $objEmployee->address  = $data['address'];

                if ($objEmployee->save()) {
                    $objChangeRequest->where('change_request.id', $objChangeRequest['id'])->delete();
                    return 'success';
                } else {
                    return 'wrong';
                }
            }
            $event = 'U';
        }

        $objChangeRequest->updated_at = date("Y-m-d H:i:s");
        if ($objChangeRequest->save()) {
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'Change Request');
            return true;
        } else {
            return false;
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AdminLeaveRequest extends Model
{
    use HasFactory;

    protected $table = 'leave_request';

    public function getdatatable()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'leave_request.id',
            1 =>  DB::raw('DATE_FORMAT(leave_request.date, "%d-%b-%Y")'),
            2 => DB::raw('CONCAT(employee.first_name, " ", employee.last_name)'),
            3 => 'manager.manager_name',
            4 => DB::raw('(CASE WHEN leave_request.leave_type = "0" THEN "Present"
                    WHEN leave_request.leave_type = "1" THEN "Absent"
                    WHEN leave_request.leave_type = "2" THEN "Half Day"
                    ELSE "Sort Leave" END)'),
            5 => DB::raw('(CASE WHEN leave_request.leave_status = "P" THEN "Pending"
            WHEN leave_request.leave_status = "R" THEN "Rejected"
            ELSE "Approved" END)'),
            6 => 'leave_request.reason',
            7 => DB::raw('CONCAT(users.first_name, " ", users.last_name)'),
            8 => 'leave_request.reject_reason',
            9 => 'leave_request.approved_date',
        );
        $query = LeaveRequest::from('leave_request')
            ->join("employee", "employee.id", "=", "leave_request.employee_id")
            ->join("manager", "manager.id", "=", "leave_request.manager_id")
            ->join("users", "users.id", "=", "leave_request.approved_by");

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
            ->select('leave_request.id', 'leave_request.date', DB::raw('CONCAT(employee.first_name, " ", employee.last_name) as fullName'),DB::raw('CONCAT(users.first_name, " ", users.last_name) as UserFullName') ,'manager.manager_name', 'leave_request.leave_type', 'leave_request.leave_status', 'leave_request.reason', 'leave_request.reject_reason','leave_request.approved_date')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $actionhtml = '';
            if(($row['leave_status']  === "P")){
                $actionhtml .= '<a href=""data-toggle="modal" data-target="#admin-leave-request-view" data-id="' . $row['id'] . '" class="btn btn-icon admin-leave-request-view"><i class="fa fa-eye text-primary"> </i></a>';
                $actionhtml .= '<a href="#" data-toggle="modal" data-target="#leave-request-approved" class="btn btn-icon  leave-request-approved" data-id="' . $row["id"] . '" ><i class="fa fa-check text-success"> </i></a>';

                $actionhtml .= '<a href=""data-toggle="modal" data-target="#admin-leave-request-reject" data-id="' . $row['id'] . '" class="btn btn-icon admin-leave-request-reject"><i class="fa fa-times text-danger"> </i></a>';
            } else {
                $actionhtml .= '<a href=""data-toggle="modal" data-target="#admin-leave-request-view" data-id="' . $row['id'] . '" class="btn btn-icon admin-leave-request-view"><i class="fa fa-eye text-primary"> </i></a>';
            }

            if ($row['leave_type'] == '0') {
                $leave_type = '<span class="label label-lg label-light-success label-inline">Present</span>';
            } else if ($row['leave_type'] == '1') {
                $leave_type = '<span class="label label-lg label-light-danger label-inline">Absent</span>';
            } else if ($row['leave_type'] == '2') {
                $leave_type = '<span class="label label-lg label-light-warning label-inline">Half Day</span>';
            } else {
                $leave_type = '<span class="label label-lg label-light-info  label-inline">Sort Leave</span>';
            }

            if ($row['leave_status'] == 'P') {
                $leave_status = '<span class="label label-lg label-light-success label-inline">Pending</span>';
            } else if ($row['leave_status'] == 'R') {
                $leave_status = '<span class="label label-lg label-light-danger label-inline">Rejected</span>';
            } else {
                $leave_status = '<span class="label label-lg label-light-info  label-inline">Approved</span>';
            }


            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = date_formate($row['date']);
            $nestedData[] = $row['fullName'];
            $nestedData[] = $row['manager_name'];
            $nestedData[] = $leave_type;
            $nestedData[] = $leave_status;
            $nestedData[] = $row['reason'] ?? '-';
            $nestedData[] = $row['UserFullName'] ?? '-';
            $nestedData[] = $row['reject_reason'] ??'-';
            $nestedData[] = date_formate($row['approved_date']) ??'-';
            $nestedData[] = $actionhtml;
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

    public function get_Leave_request_details($id)
    {
        return LeaveRequest::from('leave_request')
            ->join("employee", "employee.id", "=", "leave_request.employee_id")
            ->join("manager", "manager.id", "=", "leave_request.manager_id")
            ->select('leave_request.id', 'leave_request.date', 'leave_request.employee_id', 'leave_request.manager_id', 'leave_request.reason', 'leave_request.leave_type', 'leave_request.leave_status', 'employee.first_name', 'employee.last_name', 'manager.manager_name')
            ->where('leave_request.id', $id)
            ->first();
    }

    public function rejectLeaveReq($requestData)
    {
        $objAdminLeaveRequest = AdminLeaveRequest::find($requestData['id']);
        $objAdminLeaveRequest->approved_by = Auth()->guard('admin')->user()->id;
        $objAdminLeaveRequest->approved_date = date('Y-m-d', strtotime(date('Y-m-d H:i:s')));
        $objAdminLeaveRequest->reject_reason = $requestData['reason'];
        $objAdminLeaveRequest->leave_status = 'R';
        $objAdminLeaveRequest->updated_at = date('Y-m-d H:i:s');
        if ($objAdminLeaveRequest->save()) {
            $inputData = $requestData->input();
            unset($inputData['_token']);
            $objAudittrails = new Audittrails();
            $objAudittrails->add_audit("I", $inputData, 'Leave Request');
            return 'added';
        } else {
            return 'wrong';
        }
    }

    public function common_activity($requestData){

        $objAdminLeaveRequest = AdminLeaveRequest::find($requestData['id']);

        if($requestData['activity'] == 'approved-leave-request'){
            $objAdminLeaveRequest->approved_by = Auth()->guard('admin')->user()->id;
            $objAdminLeaveRequest->approved_date = date('Y-m-d', strtotime(date('Y-m-d H:i:s')));
            $objAdminLeaveRequest->leave_status = "A";
            $event = 'A';
        }

        $objAdminLeaveRequest->updated_at = date("Y-m-d H:i:s");
        if($objAdminLeaveRequest->save()){
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'Leave Request');
            return true;
        }else{
            return false ;
        }
    }
}

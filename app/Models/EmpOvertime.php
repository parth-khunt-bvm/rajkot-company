<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Carbon;

class EmpOvertime extends Model
{
    use HasFactory;

    protected $table = 'emp_overtime';

    public function getdatatable()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'emp_overtime.id',
            1 => DB::raw('DATE_FORMAT(emp_overtime.date, "%d-%b-%Y")'),
            2 => DB::raw('CONCAT(employee.first_name, " ", employee.last_name)'),
            3 => 'emp_overtime.hours',
            4 => 'emp_overtime.note',
        );
        $query = EmpOvertime::from('emp_overtime')
            ->join("employee", "employee.id", "=", "emp_overtime.employee_id");

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
            ->select('emp_overtime.id', 'emp_overtime.date', DB::raw('CONCAT(employee.first_name, " ", employee.last_name) as EmpName'), 'emp_overtime.hours', 'emp_overtime.note')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $target = [];
            $target = [138, 139, 140];

            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);
            if (Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0) {
                $actionhtml = '';
            }

            if (Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(138, explode(',', $permission_array[0]['permission'])))
            $actionhtml .= '<a href=""data-toggle="modal" data-target="#emp-overtime-view" data-id="'.$row['id'].'" class="btn btn-icon emp-overtime-view"><i class="fa fa-eye text-primary"> </i></a>';

            if (Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(139, explode(',', $permission_array[0]['permission'])))
                $actionhtml .= '<a href="' . route('admin.emp-overtime.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

            if (Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(140, explode(',', $permission_array[0]['permission'])))
                $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['date'] != '' && $row['date'] != NULL ? date_formate($row['date']) : '-';
            $nestedData[] = $row['EmpName'];
            $nestedData[] = numberformat($row['hours'], 0);
            $nestedData[] = $row['note'] ?? '-';
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

    public function saveAdd($requestData)
    {
        $checkEmpOvertime = EmpOvertime::from('emp_overtime')
            ->where('emp_overtime.date', date('Y-m-d', strtotime($requestData['date'])))
            ->where('emp_overtime.employee_id', $requestData['employee'])
            ->count();

        if ($checkEmpOvertime == 0) {
            $objEmpOvertime = new EmpOvertime();
            $objEmpOvertime->date = date('Y-m-d', strtotime($requestData['date']));
            $objEmpOvertime->employee_id = $requestData['employee'];
            $objEmpOvertime->hours = $requestData['hours'];
            $objEmpOvertime->note = $requestData['note'];
            $objEmpOvertime->created_at = date('Y-m-d H:i:s');
            $objEmpOvertime->updated_at = date('Y-m-d H:i:s');
            if ($objEmpOvertime->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $inputData, 'EmpOvertime');
                return 'added';
            } else {
                return 'wrong';
            }
        }
        return 'emp_over_time_exists';
    }

    public function get_emp_overtime_details($empOverTimeId)
    {
        return EmpOvertime::from('emp_overtime')
            ->where("emp_overtime.id", $empOverTimeId)
            ->join("employee", "employee.id", "=", "emp_overtime.employee_id")
            ->select('emp_overtime.id', 'emp_overtime.date', 'emp_overtime.employee_id', 'emp_overtime.hours', 'emp_overtime.note','employee.first_name', 'employee.last_name')
            ->first();
    }

    public function saveEdit($requestData)
    {
        $checkEmpOvertime = EmpOvertime::from('emp_overtime')
            ->where('emp_overtime.date', date('Y-m-d', strtotime($requestData['date'])))
            ->where('emp_overtime.employee_id', $requestData['employee'])
            ->where('emp_overtime.id', '!=', $requestData['id'])
            ->count();

        if ($checkEmpOvertime == 0) {
            $objEmpOvertime = EmpOvertime::find($requestData['id']);
            $objEmpOvertime->date = date('Y-m-d', strtotime($requestData['date']));
            $objEmpOvertime->employee_id = $requestData['employee'];
            $objEmpOvertime->hours = $requestData['hours'];
            $objEmpOvertime->note = $requestData['note'];
            $objEmpOvertime->updated_at = date('Y-m-d H:i:s');
            if ($objEmpOvertime->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $inputData, 'Employee Overtime');
                return 'updated';
            } else {
                return 'wrong';
            }
        }
        return 'emp_over_time_exists';
    }

    public function common_activity($requestData)
    {
        $objEmpOvertime = EmpOvertime::find($requestData['id']);
        if ($requestData['activity'] == 'delete-records') {
            $objEmpOvertime->where('id',$requestData['id'])->delete();
            $event = 'D';
        } else if ($requestData['activity'] == 'delete-overtime-records') {
            $objEmpOvertime->where('id',$requestData['id'])->delete();
            $event = 'D';
        }

        $objEmpOvertime->updated_at = date("Y-m-d H:i:s");
        if ($objEmpOvertime->save()) {
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'Employee Overtime');
            return true;
        } else {
            return false;
        }
    }

    public function getOvertimeDatatable($fillterdata)
    {
        $dateObject = Carbon::createFromFormat('d-M-Y', $fillterdata['date']);
        $outputDate = $dateObject->format('Y-m-d');
        // dd($outputDate);

        $requestData = $_REQUEST;
        $columns = array(
            0 => 'emp_overtime.id',
            1 => DB::raw('DATE_FORMAT(emp_overtime.date, "%d-%b-%Y")'),
            2 => DB::raw('CONCAT(employee.first_name, " ", employee.last_name)'),
            3 => 'emp_overtime.hours',
            4 => 'emp_overtime.note',
        );
        $query = EmpOvertime::from('emp_overtime')
            ->join("employee", "employee.id", "=", "emp_overtime.employee_id")
            ->where("emp_overtime.date", "=", $outputDate);


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
            ->select('emp_overtime.id', 'emp_overtime.date', DB::raw('CONCAT(employee.first_name, " ", employee.last_name) as EmpName'), 'emp_overtime.hours', 'emp_overtime.note')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $target = [];
            $target = [138, 139, 140];

            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);
            if (Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0) {
                $actionhtml = '';
            }

            if (Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(138, explode(',', $permission_array[0]['permission'])))
            $actionhtml .= '<a href=""data-toggle="modal" data-target="#emp-overtime-view" data-id="'.$row['id'].'" class="btn btn-icon emp-overtime-view"><i class="fa fa-eye text-primary"> </i></a>';

            if (Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(139, explode(',', $permission_array[0]['permission'])))
                $actionhtml .= '<a href="' . route('admin.emp-overtime.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

            if (Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(140, explode(',', $permission_array[0]['permission'])))
                $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" data-attribute="emp_overtime" ><i class="fa fa-trash text-danger" ></i></a>';
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['date'] != '' && $row['date'] != NULL ? date_formate($row['date']) : '-';
            $nestedData[] = $row['EmpName'];
            $nestedData[] = numberformat($row['hours'], 0);
            $nestedData[] = $row['note'] ?? '-';
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




}

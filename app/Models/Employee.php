<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Route;
use File;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';

    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'employee.id',
            1 => DB::raw('CONCAT("Name :", first_name, " ", last_name, "<br>Technology : ", technology.technology_name, "<br>Gmail : ", employee.gmail, "<br>Designation : ", designation.designation_name , "<br>Emergency contact : ", employee.emergency_number , "<br>G pay : ", employee.google_pay_number )'),
            3 => 'employee.DOJ',
            4 => 'employee.experience',
            5 => DB::raw('(CASE WHEN employee.status = "W" THEN "Working" ELSE "Left" END)'),
        );
        $query = Employee::from('employee')
             ->join("technology", "technology.id", "=", "employee.department")
             ->join("branch", "branch.id", "=", "employee.branch")
             ->join("designation", "designation.id", "=", "employee.designation")
             ->where("employee.is_deleted", "=", "N");

        if($fillterdata['branch'] != null && $fillterdata['branch'] != ''){
          $query->where("branch.id", $fillterdata['branch']);
        }

        if($fillterdata['technology'] != null && $fillterdata['technology'] != ''){
            $query->where("technology.id", $fillterdata['technology']);
        }
        if($fillterdata['designation'] != null && $fillterdata['designation'] != ''){
            $query->where("designation.id", $fillterdata['designation']);
        }
        if($fillterdata['startDate'] != null && $fillterdata['startDate'] != ''){
            $query->whereDate('DOJ', '>=', date('Y-m-d', strtotime($fillterdata['startDate'])));
        }
        if($fillterdata['endDate'] != null && $fillterdata['endDate'] != ''){
            $query->whereDate('DOJ', '<=',  date('Y-m-d', strtotime($fillterdata['endDate'])));
        }

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
            ->select( 'employee.id', DB::raw('CONCAT("Name :", first_name, " ", last_name, "<br>Technology : ", technology.technology_name, "<br>Gmail : ", employee.gmail, "<br>Designation : ", designation.designation_name , "<br>Emergency contact : ", employee.emergency_number , "<br>G pay : ", employee.google_pay_number ) as full_name'), 'technology.technology_name', 'branch.branch_name','designation.designation_name','employee.DOJ', 'employee.experience', 'employee.status')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {

            $target = [];
            $target = [75, 76, 77, 78, 79, 80];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(75, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.employee.view', $row['id']) . '" class="btn btn-icon"><i class="fa fa-eye text-primary"> </i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(76, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.employee.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(78, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(79, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.employee.offer-letter', $row['id']) . '" class="btn btn-icon" data-toggle="tooltip" data-placement="top" title="offer letter pdf"><i class="far fa-file-pdf text-success"></i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(80, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.employee.cover-letter', $row['id']) . '" class="btn btn-icon" title="cover letter pdf"><i class="far fa-file-pdf text-info"></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['full_name'];
            $nestedData[] = $row['branch_name'];
            $nestedData[] = date_formate($row['DOJ']);
            $nestedData[] = numberformat($row['experience'], 0);
            $nestedData[] = $row['status'] == 'W' ? '<span class="label label-lg label-light-success label-inline">Working</span>' : '<span class="label label-lg label-light-danger  label-inline">Left</span>';
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

    public function getbirthdaydatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'employee.id',
            1 => DB::raw('CONCAT(first_name, " ", last_name)'),
            2 => 'employee.DOB',
            3 => 'technology.technology_name',
            4 => 'designation.designation_name',
        );

        $query = Employee::from('employee')
             ->join("technology", "technology.id", "=", "employee.department")
             ->join("designation", "designation.id", "=", "employee.designation")
             ->where("employee.is_deleted", "=", "N");

             if($fillterdata['bdayTime'] == 0){
                $query->where(DB::raw('DATE_FORMAT(employee.DOB, "%m-%d")'), '=', date("m-d", strtotime("yesterday")));
             }
             if($fillterdata['bdayTime'] == 1){
                $query->where(DB::raw('DATE_FORMAT(employee.DOB, "%m-%d")'), '=', now()->format('m-d'));
             }
             if($fillterdata['bdayTime'] == 2){
                $query->where(DB::raw('DATE_FORMAT(employee.DOB, "%m-%d")'), '=', date("m-d", strtotime('tomorrow')));
             }
             if($fillterdata['bdayTime'] == 3){
                $query->whereBetween(DB::raw('DATE_FORMAT(employee.DOB, "%m-%d")'), array(date("m-d",strtotime('monday this week')), date("m-d",strtotime("sunday this week"))));
             }
             if($fillterdata['bdayTime'] == 4){
                $query->whereBetween(DB::raw('DATE_FORMAT(employee.DOB, "%m-%d")'), array(date("m-d", strtotime( today()->startOfMonth())), date("m-d", strtotime( today()->endOfMonth()))));
             }

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
            ->select( 'employee.id', DB::raw('CONCAT(first_name, " ", last_name) as full_name'), 'technology.technology_name', 'designation.designation_name', 'employee.DOB')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = date_formate($row['DOB']);
            $nestedData[] = $row['full_name'];
            $nestedData[] = $row['technology_name'];
            $nestedData[] = $row['designation_name'];
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
    public function getbondlastdatedatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'employee.id',
            1 => DB::raw('CONCAT(first_name, " ", last_name)'),
            2 => 'employee.bond_last_date',
            3 => 'technology.technology_name',
            4 => 'designation.designation_name',
        );

        $query = Employee::from('employee')
             ->join("technology", "technology.id", "=", "employee.department")
             ->join("designation", "designation.id", "=", "employee.designation")
             ->where("employee.is_deleted", "=", "N");

             if($fillterdata['bondLastDateTime'] == 0){
                $query->where("employee.bond_last_date", '=', date("Y-m-d", strtotime("yesterday")));
             }
             if($fillterdata['bondLastDateTime'] == 1){
                $query->where("employee.bond_last_date", '=', now()->format('Y-m-d'));
             }
             if($fillterdata['bondLastDateTime'] == 2){
                $query->where("employee.bond_last_date", '=', date("Y-m-d", strtotime('tomorrow')));
             }
             if($fillterdata['bondLastDateTime'] == 3){
                $query->whereBetween("employee.bond_last_date", array(date("Y-m-d",strtotime('monday this week')), date("Y-m-d",strtotime("sunday this week"))));
             }
             if($fillterdata['bondLastDateTime'] == 4){
                $query->whereBetween("employee.bond_last_date", array(date("Y-m-d", strtotime( today()->startOfMonth())), date("Y-m-d", strtotime( today()->endOfMonth()))));
             }

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
            ->select( 'employee.id', DB::raw('CONCAT(first_name, " ", last_name) as full_name'), 'technology.technology_name', 'designation.designation_name', 'employee.bond_last_date')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = date_formate($row['bond_last_date']);
            $nestedData[] = $row['full_name'];
            $nestedData[] = $row['technology_name'];
            $nestedData[] = $row['designation_name'];
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
    public function saveAdd($requestData){
        $checkEmployee = Employee::from('employee')
                    ->where('employee.gmail', $requestData['gmail'])
                    ->orWhere('employee.personal_number', $requestData['personal_number'])
                    ->orWhere('employee.personal_email', $requestData['personal_email'])
                    ->Where('employee.is_deleted', 'N')
                    ->count();
        if($checkEmployee == 0){
            $objEmployee = new Employee();
            $objEmployee->first_name =ucfirst($requestData['first_name']);
            $objEmployee->last_name =ucfirst($requestData['last_name']);
            $objEmployee->department = $requestData['technology'];
            $objEmployee->branch = $requestData['branch'];
            $objEmployee->designation = $requestData['designation'];
            $objEmployee->DOJ = date('Y-m-d', strtotime($requestData['doj']));
            $objEmployee->gmail = $requestData['gmail'];
            $objEmployee->password = $requestData['gmail_password'];
            $objEmployee->slack_password = $requestData['slack_password'];
            $objEmployee->DOB = date('Y-m-d', strtotime($requestData['dob']));
            $objEmployee->bank_name = $requestData['bank_name'];
            $objEmployee->acc_holder_name = $requestData['acc_holder_name'];
            $objEmployee->account_number = $requestData['account_number'];
            $objEmployee->ifsc_number = $requestData['ifsc_code'];
            $objEmployee->personal_email = $requestData['personal_email'];
            $objEmployee->pan_number = $requestData['pan_number'];
            $objEmployee->aadhar_card_number = $requestData['aadhar_card_number'];
            $objEmployee->parents_name = $requestData['parent_name'];
            $objEmployee->personal_number = $requestData['personal_number'];
            $objEmployee->google_pay_number = $requestData['google_pay'];
            $objEmployee->emergency_number = $requestData['emergency_contact'];
            $objEmployee->address = $requestData['address'];
            $objEmployee->experience = $requestData['experience'];
            $objEmployee->hired_by = $requestData['hired_by'];
            $objEmployee->salary = $requestData['salary'];
            $objEmployee->stipend_from = date('Y-m-d', strtotime($requestData['stipend_from']));
            $objEmployee->bond_last_date = date('Y-m-d', strtotime($requestData['bond_last_date']));
            $objEmployee->resign_date = date('Y-m-d', strtotime($requestData['resign_date']));
            $objEmployee->last_date = date('Y-m-d', strtotime($requestData['last_date']));
            if($requestData->hasFile('cancel_cheque') && $requestData->file('cancel_cheque')->isValid()){
                $chequeImage = time().'.'.$requestData['cancel_cheque']->extension();
                $requestData['cancel_cheque']->move(public_path('employee/cheque'), $chequeImage);
            }
            if($requestData->hasFile('bond_file') && $requestData->file('bond_file')->isValid()){
            $bondImage = time().'.'.$requestData['bond_file']->extension();
            $requestData['bond_file']->move(public_path('employee/bond'), $chequeImage);
            }
            $objEmployee->cancel_cheque = $chequeImage ?? '-';
            $objEmployee->bond_file = $bondImage ?? '-';
            $objEmployee->trainee_performance = $requestData['trainee_performance'];
            $objEmployee->status = $requestData['status'];
            $objEmployee->is_deleted = 'N';
            $objEmployee->created_at = date('Y-m-d H:i:s');
            $objEmployee->updated_at = date('Y-m-d H:i:s');
            if($objEmployee->save()){
                $inputData = $requestData->input();
                unset($inputData['_token']);
                unset($inputData['slack_password']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $inputData, 'Employee');
                return 'added';
            }else{
                return 'wrong';
            }
        }
        return 'Employee_exists';
    }

    public function saveEdit($requestData)
    {
        $countEmployee = Employee::from('employee')
            ->where('employee.gmail', $requestData['gmail'])
            ->where('employee.is_deleted', 'N')
            ->where('employee.id', "!=", $requestData['employee_id'])
            ->count();
        if ($countEmployee == 0) {
            $objEmployee = Employee::find($requestData['employee_id']);
            $objEmployee->first_name = ucfirst($requestData['first_name']);
            $objEmployee->last_name = ucfirst($requestData['last_name']);
            $objEmployee->department = $requestData['technology'];
            $objEmployee->branch = $requestData['branch'];
            $objEmployee->designation = $requestData['designation'];
            $objEmployee->DOJ = date('Y-m-d', strtotime($requestData['doj']));
            $objEmployee->gmail = $requestData['gmail'];
            $objEmployee->password = $requestData['gmail_password'];
            $objEmployee->slack_password = $requestData['slack_password'];
            $objEmployee->DOB = date('Y-m-d', strtotime($requestData['dob']));
            $objEmployee->bank_name = $requestData['bank_name'];
            $objEmployee->acc_holder_name = $requestData['acc_holder_name'];
            $objEmployee->account_number = $requestData['account_number'];
            $objEmployee->ifsc_number = $requestData['ifsc_code'];
            $objEmployee->personal_email = $requestData['personal_email'];
            $objEmployee->pan_number = $requestData['pan_number'];
            $objEmployee->aadhar_card_number = $requestData['aadhar_card_number'];
            $objEmployee->parents_name = $requestData['parent_name'];
            $objEmployee->personal_number = $requestData['personal_number'];
            $objEmployee->google_pay_number = $requestData['google_pay'];
            $objEmployee->emergency_number = $requestData['emergency_contact'];
            $objEmployee->address = $requestData['address'];
            $objEmployee->experience = $requestData['experience'];
            $objEmployee->hired_by = $requestData['hired_by'];
            $objEmployee->salary = $requestData['salary'];
            $objEmployee->stipend_from = date('Y-m-d', strtotime($requestData['stipend_from']));
            $objEmployee->bond_last_date = date('Y-m-d', strtotime($requestData['bond_last_date']));
            $objEmployee->resign_date = date('Y-m-d', strtotime($requestData['resign_date']));
            $objEmployee->last_date = date('Y-m-d', strtotime($requestData['last_date']));

            $employeeCheque = public_path('employee/cheque/'.$objEmployee['cancel_cheque']);
            if(File::exists($employeeCheque)){
                unlink($employeeCheque);
            }
            if($requestData->hasFile('cancel_cheque') && $requestData->file('cancel_cheque')->isValid()){
                $chequeImage = time().'.'.$requestData['cancel_cheque']->extension();
                $requestData['cancel_cheque']->move(public_path('employee/cheque'), $chequeImage);
            }

            $employeeBond = public_path('employee/bond/'.$objEmployee['bond_file']);
            if(File::exists($employeeBond)){
                unlink($employeeBond);
            }
            if($requestData->hasFile('bond_file') && $requestData->file('bond_file')->isValid()){
            $bondImage = time().'.'.$requestData['bond_file']->extension();
            $requestData['bond_file']->move(public_path('employee/bond'), $chequeImage);
            }

            $objEmployee->cancel_cheque = $chequeImage ?? '-';
            $objEmployee->bond_file = $bondImage ?? '-';
            $objEmployee->trainee_performance = $requestData['trainee_performance'];
            $objEmployee->status = $requestData['status'];
            $objEmployee->updated_at = date('Y-m-d H:i:s');
            if ($objEmployee->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                unset($inputData['slack_password']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit('U', $inputData, 'Employee');
                return 'added';
            }
            return 'wrong';
        }
        return 'Employee_exists';
    }

    public function get_employee_details($employeeId)
    {
       return  Employee::from('employee')
             ->join("technology", "technology.id", "=", "employee.department")
             ->join("designation", "designation.id", "=", "employee.designation")
             ->select('employee.id','employee.first_name','employee.last_name', 'employee.department','employee.designation','employee.DOJ','employee.gmail','employee.department','employee.password', 'employee.slack_password', 'employee.DOB','employee.bank_name','employee.acc_holder_name','employee.account_number','employee.ifsc_number','employee.personal_email','employee.pan_number','employee.aadhar_card_number','employee.parents_name','employee.personal_number','employee.google_pay_number','employee.address','employee.hired_by','employee.salary','employee.stipend_from','employee.bond_last_date','employee.resign_date','employee.last_date','employee.cancel_cheque','employee.bond_file','employee.trainee_performance','technology.technology_name','employee.DOJ','employee.gmail','employee.emergency_number','employee.google_pay_number','employee.experience', 'employee.created_at','designation.designation_name', 'employee.branch', 'employee.status')
             ->where('employee.id', $employeeId)
             ->first();
    }

    public function common_activity($requestData)
    {

        $objExpense = Employee::find($requestData['id']);
        if ($requestData['activity'] == 'delete-records') {
            $objExpense->is_deleted = "Y";
            $event = 'Delete Records';
        }

        if ($requestData['activity'] == 'active-records') {
            $objExpense->status = "W";
            $event = 'Active Records';
        }

        if ($requestData['activity'] == 'deactive-records') {
            $objExpense->status = "L";
            $event = 'Deactive Records';
        }

        $objExpense->updated_at = date("Y-m-d H:i:s");

        if ($objExpense->save()) {
            $currentRoute = Route::current()->getName();
            unset($requestData['_token']);
            $objAudittrails = new Audittrails();
            // $res = $objAudittrails->add_audit($event, str_replace(".", "/", $currentRoute), json_encode($requestData), 'expense');
            $res = $objAudittrails->add_audit($event, $requestData, 'expense');

            return true;
        } else {
            return false;
        }
    }
    public function get_admin_employee_details($employeIdArray = null){
        $qurey = Employee::from('employee')->select('employee.id','employee.first_name','employee.last_name');
        if($employeIdArray != null){
           $qurey->whereNotIn('employee.id', $employeIdArray);
        }
        return $qurey->get();
    }

    public function get_admin_employee_details_view($employeIdArray = null){
        $qurey = Employee::from('employee')->select('employee.id','employee.first_name','employee.last_name');
        if($employeIdArray != null){
           $qurey->whereNotIn('employee.id', $employeIdArray);
        }
        return $qurey->get();
    }

    public function get_countsheet_detail_by_employee($employeeId, $month, $year){
        $month = $year.'-'.$month;
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();
        $period = CarbonPeriod::create($start, $end);
        $attendanceData = Attendance::from('attendance')
                ->join("employee", "employee.id", "=", "attendance.employee_id")
                ->join('technology', 'technology.id', '=', 'employee.department')
                ->select('attendance.date', 'attendance.attendance_type', 'attendance.reason','technology.technology_name',
                DB::raw('CONCAT(employee.first_name, " ", employee.last_name) as full_name'),
                DB::raw('COUNT(attendance_type) as totalDays'),
                DB::raw('SUM(CASE WHEN attendance_type="0" THEN 1 ELSE 0 END) as presentCount'),
                DB::raw('SUM(CASE WHEN attendance_type="1" THEN 1 ELSE 0 END) as absentcount'),
                DB::raw('SUM(CASE WHEN attendance_type="2" THEN 1 ELSE 0 END) as halfdaycount'),
                DB::raw('SUM(CASE WHEN attendance_type="3" THEN 1 ELSE 0 END) as sortleavecount'),
                DB::raw('CONCAT(
                    FLOOR((SUM(CASE WHEN attendance_type="0" THEN 1 ELSE 0 END)*8 + SUM(CASE WHEN attendance_type="2" THEN 1 ELSE 0 END)*4 + SUM(CASE WHEN attendance_type="3" THEN 1 ELSE 0 END)*6) / 8),
                    ".",
                    (SUM(CASE WHEN attendance_type="0" THEN 1 ELSE 0 END)*8 + SUM(CASE WHEN attendance_type="2" THEN 1 ELSE 0 END)*4 + SUM(CASE WHEN attendance_type="3" THEN 1 ELSE 0 END)*6) % 8,
                    ""
                ) as total'))
                ->where('attendance.employee_id', $employeeId)
                ->whereDate('date', '>=', date('Y-m-d', strtotime($start)))
                ->whereDate('date', '<=', date('Y-m-d', strtotime($end)))
                ->get()->toArray();

        $countsheetdata = [];
        foreach ($attendanceData as $key => $value) {
            $employeeName = $value['full_name'];
            $employeeName = $value['full_name'];
            $department = $value['technology_name'];
            $totalDays = $value['totalDays'];
            $presentCounts = $value['presentCount'];
            $absentcount = $value['absentcount'];
            $halfdaycount = $value['halfdaycount'];
            $sortleavecount = $value['sortleavecount'];
            $total = $value['total'];
        }
        $countsheetdata['employeeName'] = $employeeName;
        $countsheetdata['department'] = $department;
        $countsheetdata['totalDays'] = $totalDays;
        $countsheetdata['presentCounts'] = $presentCounts;
        $countsheetdata['absentcount'] = $absentcount;
        $countsheetdata['halfdaycount'] = $halfdaycount;
        $countsheetdata['sortleavecount'] = $sortleavecount;
        $countsheetdata['total'] = $total;

        return $countsheetdata;
    }

}

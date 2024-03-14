<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

use DB;
use Route;
use File;
use Hash;
use Str;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\SendMail;
class Employee extends Authenticatable
{
    use HasFactory;

    protected $table = 'employee';

    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'employee.id',
            1 => DB::raw('CONCAT("Name :", first_name, " ", last_name, "<br>Technology : ", technology.technology_name, "<br>Gmail : ", employee.gmail, "<br>Designation : ", designation.designation_name , "<br>Emergency contact : ", employee.emergency_number , "<br>G pay : ", employee.google_pay_number )'),
            2 => 'branch.branch_name',
            3 => DB::raw('DATE_FORMAT(employee.DOJ, "%d-%b-%Y")'),
            4 => 'employee.experience',
            5 => DB::raw('(CASE WHEN employee.status = "W" THEN "Working" ELSE "Left" END)'),
        );

        $query = Employee::from('employee')
             ->join("technology", "technology.id", "=", "employee.department")
             ->join("branch", "branch.id", "=", "employee.branch")
             ->join("designation", "designation.id", "=", "employee.designation")
             ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']] )
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

        if($fillterdata['status'] != null && $fillterdata['status'] != ''){
            if($fillterdata['status'] == 1){
                $query->where("employee.status", "W");
            } else {
                $query->where("employee.status", "L");
            }
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
            ->select( 'employee.id', DB::raw('CONCAT("Name :", first_name, " ", last_name) as full_name'), 'technology.technology_name', 'branch.branch_name','designation.designation_name','employee.DOJ', 'employee.experience', 'employee.status', 'employee.gmail','designation.designation_name','employee.emergency_number','employee.google_pay_number')
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

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(77, explode(',', $permission_array[0]['permission'])) ){
                if ($row['status'] == 'W') {
                    $actionhtml .= '<a href="#" data-toggle="modal" data-target="#leftModel" class="btn btn-icon  left-employee" data-id="' . $row["id"] . '" ><i class="fa fa-times text-primary" ></i></a>';
                } else {
                    $actionhtml .= '<a href="#" data-toggle="modal" data-target="#workingModel" class="btn btn-icon working-employee" data-id="' . $row["id"] . '" ><i class="fa fa-check text-primary" ></i></a>';
                }
             }
            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(78, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(79, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.employee.offer-letter', $row['id']) . '" class="btn btn-icon" data-toggle="tooltip" data-placement="top" title="offer letter pdf"><i class="far fa-file-pdf text-success"></i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(80, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.employee.cover-letter', $row['id']) . '" class="btn btn-icon" title="cover letter pdf"><i class="far fa-file-pdf text-info"></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['full_name']."<br>Technology Name : ". $row['technology_name']. "<br>Gmail : ". $row['gmail'] . "<br>Designation : ". $row['designation_name'] . "<br>Emergency contact : ". $row['emergency_number'] ."<br>G pay : ". $row['google_pay_number'];
            $nestedData[] = $row['branch_name'];
            $nestedData[] = $row['DOJ'] != '' && $row['DOJ'] != NULL ? date_formate($row['DOJ']) : '-';
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

    public function saveAdd($requestData){

        if($requestData['gmail'] != "" && $requestData['gmail'] != NULL){
            $checkEmployeegmail = Employee::from('employee')
                            ->where('is_deleted', 'N')
                            ->where('gmail', $requestData['gmail'])
                            ->where('gmail', '!=', NULL)
                            ->count();

            if($checkEmployeegmail != 0) { return 'company_email_exits'; }

        }
        if($requestData['personal_email'] != "" && $requestData['personal_email'] != NULL){
            $checkEmployeePersonalEmail = Employee::from('employee')
            ->where('is_deleted', 'N')
            ->where('personal_email', $requestData['personal_email'])
            ->where('personal_email', '!=', NULL)
            ->count();
            if($checkEmployeePersonalEmail != 0) return 'personal_email_exits';

        }
        if($requestData['pan_number'] != "" && $requestData['pan_number'] != NULL){
            $checkEmployeePanNo = Employee::from('employee')->where('is_deleted', 'N')
            ->where('pan_number', $requestData['pan_number'])
            ->where('pan_number', '!=', NULL)
            ->count();
            if($checkEmployeePanNo != 0) return 'pan_number_exits';

        }
        if($requestData['aadhar_card_number'] != "" && $requestData['aadhar_card_number'] != NULL){
            $checkEmployeeAadharCard = Employee::from('employee')->where('is_deleted', 'N')
            ->where('aadhar_card_number', $requestData['aadhar_card_number'])
            ->where('aadhar_card_number', '!=', NULL)
            ->count();
            if($checkEmployeeAadharCard != 0) return 'aadhar_card_number_exits';

        }
        if($requestData['personal_number'] != "" && $requestData['personal_number'] != NULL){
            $checkEmployeePrNo = Employee::from('employee')->where('is_deleted', 'N')
            ->where('personal_number', $requestData['personal_number'])
            ->where('personal_number', '!=', NULL)
            ->count();
            if($checkEmployeePrNo != 0) return 'personal_number_exits';
        }

            $password = Str::random(8);
            $objEmployee = new Employee();
            $objEmployee->first_name = ucfirst($requestData['first_name']);
            $objEmployee->last_name = ucfirst($requestData['last_name']);
            $objEmployee->department = $requestData['technology'];
            $objEmployee->branch = $requestData['branch'];
            $objEmployee->designation = $requestData['designation'];
            $objEmployee->DOJ = $requestData['doj'] != '' && $requestData['doj'] != NULL ? date('Y-m-d', strtotime($requestData['doj'])) : NULL;
            $objEmployee->gmail = $requestData['gmail'];
            $objEmployee->password = Hash::make($password);
            $objEmployee->gmail_password = $requestData['gmail_password'];
            $objEmployee->slack_password = $requestData['slack_password'];
            $objEmployee->DOB = $requestData['dob'] != '' && $requestData['dob'] != NULL ? date('Y-m-d', strtotime($requestData['dob'])) : NULL;
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
            $objEmployee->stipend_from = $requestData['stipend_from'] != '' && $requestData['stipend_from'] != NULL ?  date('Y-m-d', strtotime($requestData['stipend_from'])) : NULL;
            $objEmployee->bond_last_date = $requestData['bond_last_date'] != '' && $requestData['bond_last_date'] != NULL ?  date('Y-m-d', strtotime($requestData['bond_last_date'])) : NULL;
            $objEmployee->resign_date = $requestData['resign_date'] != '' && $requestData['resign_date'] != NULL ?  date('Y-m-d', strtotime($requestData['resign_date'])) : NULL;
            $objEmployee->last_date = $requestData['last_date'] != '' && $requestData['last_date'] != NULL ?  date('Y-m-d', strtotime($requestData['last_date'])) : NULL;
            if($requestData->hasFile('cancel_cheque') && $requestData->file('cancel_cheque')->isValid()){
                $chequeImage = time().'.'.$requestData['cancel_cheque']->extension();
                $requestData['cancel_cheque']->move(public_path('employee/cheque'), $chequeImage);
            }
            if($requestData->hasFile('bond_file') && $requestData->file('bond_file')->isValid()){
            $bondImage = time().'.'.$requestData['bond_file']->extension();
            $requestData['bond_file']->move(public_path('employee/bond'), $bondImage);
            }
            $objEmployee->cancel_cheque = $chequeImage ?? '-';
            $objEmployee->bond_file = $bondImage ?? '-';
            $objEmployee->trainee_performance = $requestData['trainee_performance'];
            $objEmployee->status = $requestData['status'];
            $objEmployee->is_deleted = 'N';
            $objEmployee->created_at = date('Y-m-d H:i:s');
            $objEmployee->updated_at = date('Y-m-d H:i:s');
            if($objEmployee->save()){

                $mailData['data']=[];
                $mailData['data']['first_name'] = $requestData['first_name'];
                $mailData['data']['last_name'] = $requestData['last_name'];
                $mailData['data']['gmail'] = $requestData['gmail'];
                $mailData['data']['password'] = $password;
                $mailData['subject'] = 'Rajkot Company - Add Employee';
                $mailData['data']['company'] = 'BVM Infotech';
                $mailData['attachment'] = array(
                    'image_path' => public_path('upload/company_image/logo.png'),
                );
                $mailData['template'] ="backend.pages.employee.mail";
                $mailData['mailto'] = $requestData['gmail'];
                $sendMail = new SendMail();
                $sendMail->sendSMTPMail($mailData);


                $inputData = $requestData->input();
                unset($inputData['_token']);
                unset($inputData['slack_password']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $inputData, 'Employee');
                return 'added';
            }else{
                return 'wrong';
            }


        // return 'Employee_exists';
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
            $objEmployee->DOJ = $requestData['doj'] != '' && $requestData['doj'] != NULL ? date('Y-m-d', strtotime($requestData['doj'])) : NULL;
            $objEmployee->gmail = $requestData['gmail'] ?? Null;
            $objEmployee->gmail_password = $requestData['gmail_password'] ?? Null;
            $objEmployee->slack_password = $requestData['slack_password'];
            $objEmployee->DOB = $requestData['dob'] != '' && $requestData['dob'] != NULL ? date('Y-m-d', strtotime($requestData['dob'])) : NULL;
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
            $objEmployee->stipend_from = $requestData['stipend_from'] != '' && $requestData['stipend_from'] != NULL ?  date('Y-m-d', strtotime($requestData['stipend_from'])) : NULL;
            $objEmployee->bond_last_date = $requestData['bond_last_date'] != '' && $requestData['bond_last_date'] != NULL ?  date('Y-m-d', strtotime($requestData['bond_last_date'])) : NULL;
            $objEmployee->resign_date = $requestData['resign_date'] != '' && $requestData['resign_date'] != NULL ?  date('Y-m-d', strtotime($requestData['resign_date'])) : NULL;
            $objEmployee->last_date = $requestData['last_date'] != '' && $requestData['last_date'] != NULL ?  date('Y-m-d', strtotime($requestData['last_date'])) : NULL;

            $employeeCheque = public_path('employee/cheque/'.$objEmployee['cancel_cheque']);

            if($requestData->hasFile('cancel_cheque') && $requestData->file('cancel_cheque')->isValid()){
                if(file_exists($employeeCheque)){
                    unlink($employeeCheque);
                }
                $chequeImage = time().'.'.$requestData['cancel_cheque']->extension();
                $requestData['cancel_cheque']->move(public_path('employee/cheque'), $chequeImage);
            }

            $employeeBond = public_path('employee/bond/'.$objEmployee['bond_file']);

            if($requestData->hasFile('bond_file') && $requestData->file('bond_file')->isValid()){
                if(file_exists($employeeBond)){
                    unlink($employeeBond);
                }
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
             ->select('employee.id','employee.first_name','employee.last_name', 'employee.department','employee.designation','employee.DOJ','employee.gmail','employee.department','employee.password', 'employee.slack_password', 'employee.DOB','employee.bank_name','employee.acc_holder_name','employee.account_number','employee.ifsc_number','employee.personal_email','employee.pan_number','employee.aadhar_card_number','employee.parents_name','employee.personal_number','employee.google_pay_number','employee.address','employee.hired_by','employee.salary','employee.stipend_from','employee.bond_last_date','employee.resign_date','employee.last_date','employee.cancel_cheque','employee.bond_file','employee.trainee_performance','technology.technology_name','employee.DOJ','employee.gmail','employee.emergency_number','employee.google_pay_number','employee.experience', 'employee.created_at','designation.designation_name', 'employee.branch', 'employee.status', 'employee.gmail_password')
             ->where('employee.id', $employeeId)
             ->first();
    }

    public function common_activity($requestData)
    {
        $objEmployee = Employee::find($requestData['id']);
        if ($requestData['activity'] == 'delete-records') {
            $objEmployee->is_deleted = "Y";
            $event = 'Delete Records';
        }

        if ($requestData['activity'] == 'left-employee') {
            $objEmployee->status = "L";
            $event = 'Left Employee';
        }

        if ($requestData['activity'] == 'working-employee') {
            $objEmployee->status = "W";
            $event = 'Working Employee';
        }

        $objEmployee->updated_at = date("Y-m-d H:i:s");

        if ($objEmployee->save()) {
            $currentRoute = Route::current()->getName();
            unset($requestData['_token']);
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'employee');

            return true;
        } else {
            return false;
        }
    }
    public function get_admin_employee_details($employeIdArray = null){
        $qurey = Employee::from('employee')->select('employee.id','employee.first_name','employee.last_name')
                ->join("branch", "branch.id", "=", "employee.branch")
                ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']] )
                ->where("employee.status", "=", "W")
                ->where("employee.is_deleted", "=", "N");
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


    public function get_employee_salary_slip_detail($departmentId, $designationId){
        return  Employee::from('employee')
             ->join("technology", "technology.id", "=", "employee.department")
             ->join("designation", "designation.id", "=", "employee.designation")
             ->select('employee.id','employee.first_name','employee.last_name','employee.salary')
             ->where('employee.department', $departmentId)
             ->where('employee.designation', $designationId)
             ->get();
    }

    public function getEmployeeBasicSalary($data){

        return Employee::select('salary')->where("id",$data['employee'])->get();

    }


    public function updateProfile($request){
        $countEmployee = Employee::where("gmail",$request->input('email'))
                        ->where("id",'!=',$request->input('edit_id'))
                        ->count();

        if($countEmployee == 0){
            $objEmployee = Employee::find($request->input('edit_id'));
            $objEmployee->first_name = $request->input('first_name');
            $objEmployee->last_name = $request->input('last_name');
            $objEmployee->gmail = $request->input('email');
            if($request->file('userimage')){
                $image = $request->file('userimage');
                $imagename = 'userimage'.time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/upload/userprofile/');
                $image->move($destinationPath, $imagename);
                $objEmployee->userimage  = $imagename ;
            }
            if($objEmployee->save()){
                $currentRoute = Route::current()->getName();
                $inputData = $request->input();
                unset($inputData['_token']);
                unset($inputData['profile_avatar_remove']);
                unset($inputData['userimage']);
                if($request->file('userimage')){
                    $inputData['userimage'] = $imagename;
                }
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $inputData, 'Update Profile');
                return true;
            }else{
                return "false";
            }
        }else{
            return "email_exist";
        }
    }

    // public function changepassword($request)
    // {
    //     if (Hash::check($request->input('old_password'), $request->input('user_old_password'))) {
    //         $countUser = Users::where("id",'=',$request->input('editid'))->count();
    //         if($countUser == 1){
    //             $objUsers = Users::find($request->input('editid'));
    //             $objUsers->password =  Hash::make($request->input('new_password'));
    //             $objUsers->updated_at = date('Y-m-d H:i:s');
    //             if($objUsers->save()){
    //                 $currentRoute = Route::current()->getName();
    //                 $inputData = $request->input();
    //                 unset($inputData['_token']);
    //                 unset($inputData['user_old_password']);
    //                 unset($inputData['old_password']);
    //                 unset($inputData['new_password']);
    //                 unset($inputData['new_confirm_password']);
    //                 $objAudittrails = new Audittrails();
    //                 $objAudittrails->add_audit("U", $inputData, 'Change Password');
    //                 return true;
    //             }else{
    //                 return 'false';
    //             }
    //         }else{
    //             return "false";
    //         }
    //     }else{
    //         return "password_not_match";
    //     }
    // }


}

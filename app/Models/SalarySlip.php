<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Carbon;

class SalarySlip extends Model
{
    use HasFactory;

    protected $table = 'salary_slip';

    public function getdatatable($fillterdata)
    {

        $requestData = $_REQUEST;
        $columns = array(
            0 => 'salary_slip.id',
            1 => DB::raw("CONCAT(employee.first_name,' ',employee.last_name)"),
            2 => 'branch.technology_name',
            3 => 'designation.designation_name',
            4 =>  DB::raw('CONCAT(MONTHNAME(CONCAT("2023-", salary_slip.month, "-01")), "-", year)'),
        );

        $query = SalarySlip::from('salary_slip')
            ->join("employee", "employee.id", "=", "salary_slip.employee")
            ->join("designation", "designation.id", "=", "salary_slip.designation")
            ->join("technology", "technology.id", "=", "salary_slip.department")
            ->where("salary_slip.is_deleted", "=", "N");


        if ($fillterdata['employee'] != null && $fillterdata['employee'] != '') {
            $query->where("employee.id", $fillterdata['employee']);
        }

        if ($fillterdata['month'] != null && $fillterdata['month'] != '') {
            $query->where("salary_slip.month", $fillterdata['month']);
        }

        if ($fillterdata['year'] != null && $fillterdata['year'] != '') {
            $query->where("salary_slip.year", $fillterdata['year']);
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
            ->select('salary_slip.id', DB::raw("CONCAT(employee.first_name,' ',employee.last_name) as full_name"), 'designation.designation_name', 'technology.technology_name', DB::raw('CONCAT(MONTHNAME(CONCAT("2023-", salary_slip.month, "-01")), "-", year) as monthYear'))
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {

            $target = [];
            $target = [128, 129, 130, 131];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if (Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0) {
                $actionhtml = '';
            }
            if (Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(128, explode(',', $permission_array[0]['permission'])))
                $actionhtml .= '<a href="' . route('admin.employee-salaryslip.view', $row['id']) . '" class="btn btn-icon"><i class="fa fa-eye text-primary"> </i></a>';

            if (Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(129, explode(',', $permission_array[0]['permission'])))
                $actionhtml .= '<a href="' . route('admin.employee-salaryslip.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

            if (Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(130, explode(',', $permission_array[0]['permission'])))
                $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            if (Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(131, explode(',', $permission_array[0]['permission'])))
                $actionhtml .= '<a href="' . route('admin.employee-salaryslip.pdf', $row['id']) . '" class="btn btn-icon" data-toggle="tooltip" data-placement="top" title="salary slip pdf"><i class="far fa-file-pdf text-success"></i></a>';


            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['full_name'];
            $nestedData[] = $row['technology_name'];
            $nestedData[] = $row['designation_name'];
            $monthName = $row['monthYear'];
            $nestedData[] = $monthName;
            if (Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0) {
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

        $checkSalarySlip = SalarySlip::from('salary_slip')
            ->where("month", $requestData->input('month'))
            ->where("year", $requestData->input('year'))
            ->where("employee", $requestData->input('employee'))
            ->where('salary_slip.is_deleted', 'N')
            ->count();

        if ($checkSalarySlip == 0) {
            $objSalaryslip = new Salaryslip();
            $objSalaryslip->department = $requestData['empDepartment'];
            $objSalaryslip->designation = $requestData['empDesignation'];
            $objSalaryslip->employee = $requestData['employee'];
            $objSalaryslip->month = $requestData['month'];
            $objSalaryslip->year = $requestData['year'];
            $objSalaryslip->pay_salary_date = $requestData['pay_salary'] != '' && $requestData['pay_salary'] != NULL ? date('Y-m-d', strtotime($requestData['pay_salary'])) : NULL;
            $objSalaryslip->basic_salary = $requestData['basic'];
            $objSalaryslip->working_day = $requestData['wd'];
            $objSalaryslip->loss_of_pay = $requestData['lop'];
            $objSalaryslip->house_rent_allow_pr = $requestData['hra_pr'];
            $objSalaryslip->house_rent_allow = $requestData['hra'];
            $objSalaryslip->income_tax_pr = $requestData['income_tax_pr'];
            $objSalaryslip->income_tax = $requestData['income_tax'];
            $objSalaryslip->pf_pr = $requestData['pf_pr'];
            $objSalaryslip->pf = $requestData['pf'];
            $objSalaryslip->pt_pr = $requestData['pro_tax_pr'];
            $objSalaryslip->pt = $requestData['pro_tax'];
            $objSalaryslip->is_deleted = 'N';
            $objSalaryslip->created_at = date("Y-m-d h:i:s");
            $objSalaryslip->updated_at = date("Y-m-d h:i:s");
            if ($objSalaryslip->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $res = $objAudittrails->add_audit('I', $inputData, 'Salary Slip');
                return 'added';
            }
            return 'wrong';
        }
        return 'salary_slip_exists';
    }

    public function saveEdit($requestData)
    {

        $checkSalarySlip = SalarySlip::from('salary_slip')
            ->where("month", $requestData->input('month'))
            ->where("year", $requestData->input('year'))
            ->where("employee", $requestData->input('employee'))
            ->where('salary_slip.is_deleted', 'N')
            ->where('salary_slip.id', "!=", $requestData['salary_slip_id'])
            ->count();

        if ($checkSalarySlip == 0) {
            $objSalaryslip = SalarySlip::find($requestData['salary_slip_id']);
            $objSalaryslip->department = $requestData['empDepartment'];
            $objSalaryslip->designation = $requestData['empDesignation'];
            $objSalaryslip->employee = $requestData['employee'];
            $objSalaryslip->month = $requestData['month'];
            $objSalaryslip->year = $requestData['year'];
            $objSalaryslip->pay_salary_date = $requestData['pay_salary'] != '' && $requestData['pay_salary'] != NULL ? date('Y-m-d', strtotime($requestData['pay_salary'])) : NULL;
            $objSalaryslip->basic_salary = $requestData['basic'];
            $objSalaryslip->working_day = $requestData['wd'];
            $objSalaryslip->loss_of_pay = $requestData['lop'];
            $objSalaryslip->house_rent_allow_pr = $requestData['hra_pr'];
            $objSalaryslip->house_rent_allow = $requestData['hra'];
            $objSalaryslip->income_tax_pr = $requestData['income_tax_pr'];
            $objSalaryslip->income_tax = $requestData['income_tax'];
            $objSalaryslip->pf_pr = $requestData['pf_pr'];
            $objSalaryslip->pf = $requestData['pf'];
            $objSalaryslip->pt_pr = $requestData['pro_tax_pr'];
            $objSalaryslip->pt = $requestData['pro_tax'];
            $objSalaryslip->updated_at = date('Y-m-d H:i:s');
            if ($objSalaryslip->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit('U', $inputData, 'Salary Slip');
                return 'added';
            }
            return 'wrong';
        }
        return 'salary_slip_exists';
    }

    public function get_salary_slip_details($employeeId)
    {
        return SalarySlip::from('salary_slip')
            ->join("employee", "employee.id", "=", "salary_slip.employee")
            ->join("designation", "designation.id", "=", "salary_slip.designation")
            ->join("technology", "technology.id", "=", "salary_slip.department")
            ->select('salary_slip.id', 'salary_slip.department', 'salary_slip.designation', 'salary_slip.employee', 'salary_slip.month', 'salary_slip.year', 'salary_slip.pay_salary_date', 'salary_slip.basic_salary', 'salary_slip.working_day', 'salary_slip.loss_of_pay', 'salary_slip.house_rent_allow_pr', 'salary_slip.house_rent_allow', 'salary_slip.income_tax_pr', 'salary_slip.income_tax', 'salary_slip.pf_pr', 'salary_slip.pf', 'salary_slip.pt_pr', 'salary_slip.pt', 'employee.first_name', 'employee.last_name')
            ->where('salary_slip.id', $employeeId)
            ->where("salary_slip.is_deleted", "=", "N")
            ->first();
    }

    public function common_activity($requestData)
    {
        if ($requestData['activity'] == 'delete-records') {
            $objSalarySlip = SalarySlip::find($requestData['id']);
            $objSalarySlip->is_deleted = "Y";
            $event = 'Delete Records';
        }

        if ($requestData['activity'] == 'generate-salary-slip') {
            $branchs = Branch::from('branch')
                ->where("branch.is_deleted", "=", "N")
                ->pluck('branch.branch_name', 'branch.id')->toArray();

            $date = today()->startOfMonth();
            $previousMonthDate = $date->subMonth();
            $daysInPreviousMonth = $date->daysInMonth;
            $previousMonth = $previousMonthDate->format('m');
            $previousYear = $previousMonthDate->format('Y');

            foreach ($branchs as $branchKey => $branchValue) {
                $employees = Employee::from('employee')
                    ->where("employee.is_deleted", "=", "N")
                    ->where("employee.branch", "=", $branchKey)
                    ->select('employee.*')->get()->toArray();

                foreach ($employees as $employeeKey => $employeeValue) {
                    $checkSalarySlip = SalarySlip::from('salary_slip')
                        ->where("month", $previousMonth)
                        ->where("year", $previousYear)
                        ->where("employee", $employeeValue['id'])
                        ->where('salary_slip.is_deleted', 'N')
                        ->count();

                    if ($checkSalarySlip == 0) {
                        $objSalaryslip = new Salaryslip();
                        $objSalaryslip->department = $employeeValue['department'];
                        $objSalaryslip->designation = $employeeValue['designation'];
                        $objSalaryslip->employee = $employeeValue['id'];
                        $objSalaryslip->month = $previousMonth;
                        $objSalaryslip->year = $previousYear;
                        $objSalaryslip->pay_salary_date = date("Y-m-d h:i:s");
                        $objSalaryslip->basic_salary = $employeeValue['salary'];
                        $objSalaryslip->working_day = $daysInPreviousMonth;
                        $objSalaryslip->loss_of_pay = 0;
                        $objSalaryslip->house_rent_allow_pr = 0;
                        $objSalaryslip->house_rent_allow = 0;
                        $objSalaryslip->income_tax_pr = 0;
                        $objSalaryslip->income_tax = 0;
                        $objSalaryslip->pf_pr = 0;
                        $objSalaryslip->pf = 0;
                        $objSalaryslip->pt_pr = 0;
                        $objSalaryslip->pt = 0;
                        $objSalaryslip->is_deleted = 'N';
                        $objSalaryslip->created_at = date("Y-m-d h:i:s");
                        $objSalaryslip->updated_at = date("Y-m-d h:i:s");
                        if ($objSalaryslip->save()) {
                            $objAudittrails = new Audittrails();
                            $res = $objAudittrails->add_audit('add', $requestData, 'Salary Slip');
                        }
                    } else {
                        return true;
                    }
                }
                return true;
            }
            $event = 'generate salary slip';
        }

        $objSalarySlip->updated_at = date("Y-m-d H:i:s");

        if ($objSalarySlip->save()) {
            unset($requestData['_token']);
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'Salary Slip');

            return true;
        } else {
            return false;
        }
    }

    public function salarySlipSaveAdd($requestData)
    {
        $employees =   Employee::from('employee')
            ->join("branch", "branch.id", "=", "employee.branch")
            ->select('employee.*')
            ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']] )
            ->get()->toArray();
        foreach ($employees as $employeeKey => $employeeValue) {
            $checkSalarySlip = SalarySlip::from('salary_slip')
                ->where("month", $requestData['month'])
                ->where("year", $requestData['year'])
                ->where("employee", $employeeValue['id'])
                ->where('salary_slip.is_deleted', 'N')
                ->count();

            if ($checkSalarySlip == 0) {
                $objSalaryslip = new Salaryslip();
                $objSalaryslip->department = $employeeValue['department'];
                $objSalaryslip->designation = $employeeValue['designation'];
                $objSalaryslip->employee = $employeeValue['id'];
                $objSalaryslip->month = $requestData['month'];
                $objSalaryslip->year = $requestData['year'];
                $objSalaryslip->pay_salary_date = date('Y-m-d', strtotime($requestData['pay_salary']));
                $objSalaryslip->basic_salary = $employeeValue['salary'];
                $objSalaryslip->working_day = $requestData['wd'];
                $objSalaryslip->loss_of_pay = 0;
                $objSalaryslip->house_rent_allow_pr = 0;
                $objSalaryslip->house_rent_allow = 0;
                $objSalaryslip->income_tax_pr = 0;
                $objSalaryslip->income_tax = 0;
                $objSalaryslip->pf_pr = 0;
                $objSalaryslip->pf = 0;
                $objSalaryslip->pt_pr = 0;
                $objSalaryslip->pt = 0;
                $objSalaryslip->is_deleted = 'N';
                $objSalaryslip->created_at = date("Y-m-d h:i:s");
                $objSalaryslip->updated_at = date("Y-m-d h:i:s");
                if ($objSalaryslip->save()) {
                    $objAudittrails = new Audittrails();
                    $res = $objAudittrails->add_audit('add', $requestData, 'Salary Slip');
                }
            } else {
                return true;
            }
        }
        return true;
    }

    public function salarySlipCreate($requestData)
    {
        $days = array();
        $month = $requestData['month'];
        $year =  $requestData['year'];

        salaryCount($month ,$year, $requestData['employee']);


        $firstDate = $year . '-' . $month . '-01';
        $lastDate = date('t', strtotime($firstDate));
        for ($d = 1; $d <= $lastDate; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('D', $time) != "Sat" && date('D', $time) != "Sun") {
                // echo date('D', $time) . "<br>"; // Echo day name
                $days[] = date('Y-m-d H:i:s', $time); // Store dates in array if not Saturday or Sunday
            }
        }

        $numberOfDays = count($days);
        $holidayCount = PublicHoliday::whereYear('public_holiday.date', $year)->whereMonth('public_holiday.date', $month)->count();
        $working_day = $numberOfDays - $holidayCount;

        if($requestData['employee'] === "all"){

            $employeeIds = Employee::from('employee')
            ->join("technology", "technology.id", "=", "employee.department")
            ->join("branch", "branch.id", "=", "employee.branch")
            ->join("designation", "designation.id", "=", "employee.designation")
            ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']] )
            ->where("employee.is_deleted", "=", "N")
            ->where("employee.status", "=", "W")
            ->pluck('employee.id')
            ->toArray();

            $attendanceCounts = [];

            foreach ($employeeIds as $key =>$employeeId) {
                $query = Attendance::from('attendance')
                    ->join("employee", "employee.id", "=", "attendance.employee_id")
                    ->join("technology", "technology.id", "=", "employee.department")
                    ->join("designation", "designation.id", "=", "employee.designation")
                    ->join("branch", "branch.id", "=", "employee.branch")
                    ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
                    ->whereYear('attendance.date', $requestData['year'])
                    ->whereMonth('attendance.date', $requestData['month'])
                    ->where("attendance.employee_id", $employeeId);

                $presentQuery = clone $query;
                $attendanceCounts[$key]['present'] = $presentQuery->where("attendance.attendance_type", "0")->count();

                $absentQuery = clone $query;
                $attendanceCounts[$key]['absent'] = $absentQuery->where("attendance.attendance_type", "1")->count();

                $halfDayQuery = clone $query;
                $attendanceCounts[$key]['half_day'] = $halfDayQuery->where("attendance.attendance_type", "2")->count();

                $sortLeaveQuery = clone $query;
                $attendanceCounts[$key]['sort_leave'] = $sortLeaveQuery->where("attendance.attendance_type", "3")->count();

                $attendanceCounts[$key]['working_day'] =  $working_day;

                $employeeQuery = clone $query;
                $employee = $employeeQuery->select('employee.id','employee.first_name','employee.last_name','technology.technology_name','designation.designation_name','branch.branch_name','employee.salary')->first();

                // dd($employee);

                if ($employee !== null) {
                    $attendanceCounts[$key]['employee'] = $employee->toArray();
                } else {
                    // Handle the case where the employee attendance does not exist
                    $attendanceCounts[$key]['employee'] = null; // Or any other appropriate action
                }

                if($attendanceCounts[$key]['present'] >= 15){
                    // $working_day /
                }
            }
            ccd($attendanceCounts);
            return $attendanceCounts;

        }else {

            $query = Attendance::from('attendance')
            ->join("employee", "employee.id", "=", "attendance.employee_id")
            ->join("technology", "technology.id", "=", "employee.department")
            ->join("designation", "designation.id", "=", "employee.designation")
            ->join("branch", "branch.id", "=", "employee.branch")
            ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
            ->whereYear('attendance.date', $requestData['year'])
            ->whereMonth('attendance.date', $requestData['month'])
            ->where("attendance.employee_id", $requestData['employee']);

          $attendanceCounts = [];

          $presentQuery = clone $query;
          $attendanceCounts['present_query'] = $presentQuery->where("attendance.attendance_type", "0")
                          ->count();

          $absentQuery = clone $query;
          $attendanceCounts['absent_query'] = $absentQuery->where("attendance.attendance_type", "1")
                          ->count();

          $halfDayQuery = clone $query;
          $attendanceCounts['half_day_query'] = $halfDayQuery->where("attendance.attendance_type", "2")
                          ->count();

          $sortLeaveQuery = clone $query;
          $attendanceCounts['sort_leave_query'] = $sortLeaveQuery->where("attendance.attendance_type", "3")
                          ->count();

          $attendanceCounts['working_day'] =  $working_day;

                $employeeQuery = clone $query;
                $employee = $employeeQuery->select('employee.id','employee.first_name','employee.last_name','technology.technology_name','designation.designation_name','branch.branch_name','employee.salary')->first();

                if ($employee !== null) {
                    $attendanceCounts['employee'] = $employee->toArray();
                } else {
                    // Handle the case where the employee attendance does not exist
                    $attendanceCounts['employee'] = null; // Or any other appropriate action
                }

          ccd($attendanceCounts);
          return $attendanceCounts;
        }

    }
}

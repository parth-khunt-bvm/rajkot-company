<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Route;
use Session;
use Illuminate\Support\Carbon;
use App\Models\Audittrails;

class Salary extends Model
{
    use HasFactory;

    protected $table = 'salary';

    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'salary.id',
            1 => DB::raw('DATE_FORMAT(salary.date, "%d-%b-%Y")'),
            2 => 'manager.manager_name',
            3 => 'branch.branch_name',
            4 => 'technology.technology_name',
            5 => DB::raw('CONCAT(MONTHNAME(CONCAT("2023-", salary.month_of, "-01")), "-", year)'),
            6 => 'salary.amount',
            7 => 'salary.remarks',
        );

        $query = Salary::from('salary')
            ->join("manager", "manager.id", "=", "salary.manager_id")
            ->join("branch", "branch.id", "=", "salary.branch_id")
            ->join("technology", "technology.id", "=", "salary.technology_id")
            ->whereIn('salary.branch_id', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']] )
            ->where("salary.is_deleted", "=", "N");

        if($fillterdata['manager'] != null && $fillterdata['manager'] != ''){
            $query->where("manager.id", $fillterdata['manager']);
        }

        if($fillterdata['branch'] != null && $fillterdata['branch'] != ''){
            $query->where("branch.id", $fillterdata['branch']);
        }

        if($fillterdata['technology'] != null && $fillterdata['technology'] != ''){
            $query->where("technology.id", $fillterdata['technology']);
        }

        if($fillterdata['monthOf'] != null && $fillterdata['monthOf'] != ''){
            $query->where("salary.month_of", $fillterdata['monthOf']);
        }

        if($fillterdata['year'] != null && $fillterdata['year'] != ''){
            $query->where("salary.year", $fillterdata['year']);
        }

        if($fillterdata['monthOf'] != null && $fillterdata['monthOf'] != '' && $fillterdata['year'] != null && $fillterdata['year'] != ''){
            $query->where(DB::raw('CONCAT(month_of, "-", year)'), $fillterdata['monthOf'] . "-" . $fillterdata['year']);
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
            ->select('salary.id', 'manager.manager_name', 'branch.branch_name', 'technology.technology_name','salary.date', 'salary.month_of', DB::raw('MONTHNAME(CONCAT("2023-", salary.month_of, "-01")) as month_name'), 'salary.amount','salary.remarks', DB::raw('CONCAT(MONTHNAME(CONCAT("2023-", salary.month_of, "-01")), "-", year) as montYear'))
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {

            $target = [];
            $target = [45, 46, 47];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }
            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(45, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.salary.view', $row['id']) . '" class="btn btn-icon"><i class="fa fa-eye text-primary"> </i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(46, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.salary.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(47, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = date_formate($row['date']);
            $nestedData[] = $row['manager_name'];
            $nestedData[] = $row['branch_name'];
            $nestedData[] = $row['technology_name'];
            $monthName = $row['montYear'];
            $nestedData[] = $monthName;
            $nestedData[] = numberformat($row['amount']);
            if (strlen($row['remarks']) > $max_length) {
                $nestedData[] = substr($row['remarks'], 0, $max_length) . '...';
            }else {
                $nestedData[] = $row['remarks']; // If it's not longer than max_length, keep it as is
            }
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

    public function getSalaryDatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'salary.id',
            1 => DB::raw('DATE_FORMAT(salary.date, "%d-%b-%Y")'),
            2 => 'manager.manager_name',
            3 => 'branch.branch_name',
            4 => 'technology.technology_name',
            5 => DB::raw('CONCAT(MONTHNAME(CONCAT("2023-", salary.month_of, "-01")), "-", year)'),
            6 => 'salary.amount',
            7 => 'salary.remarks',
        );

        $query = Salary::from('salary')
            ->join("manager", "manager.id", "=", "salary.manager_id")
            ->join("branch", "branch.id", "=", "salary.branch_id")
            ->join("technology", "technology.id", "=", "salary.technology_id")
            ->whereIn('salary.branch_id', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']] )
            ->where("salary.is_deleted", "=", "Y");

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
            ->select('salary.id', 'manager.manager_name', 'branch.branch_name', 'technology.technology_name','salary.date', 'salary.month_of', DB::raw('MONTHNAME(CONCAT("2023-", salary.month_of, "-01")) as month_name'), 'salary.amount','salary.remarks', DB::raw('CONCAT(MONTHNAME(CONCAT("2023-", salary.month_of, "-01")), "-", year) as montYear'))
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {

            $target = [];
            $target = [45, 46, 47];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }


            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = date_formate($row['date']);
            $nestedData[] = $row['manager_name'];
            $nestedData[] = $row['branch_name'];
            $nestedData[] = $row['technology_name'];
            $monthName = $row['montYear'];
            $nestedData[] = $monthName;
            $nestedData[] = numberformat($row['amount']);
            if (strlen($row['remarks']) > $max_length) {
                $nestedData[] = substr($row['remarks'], 0, $max_length) . '...';
            }else {
                $nestedData[] = $row['remarks']; // If it's not longer than max_length, keep it as is
            }
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
        $countSalary = Salary::from('salary')
            ->where('salary.manager_id', $requestData['manager_id'])
            ->where('salary.branch_id', $requestData['branch_id'])
            ->where('salary.technology_id', $requestData['technology_id'])
            ->where('salary.month_of', $requestData['month_of'])
            ->where('salary.is_deleted', 'N')
            ->count();

        if ($countSalary == 0) {
            $objSalary = new Salary();
            $objSalary->manager_id = $requestData['manager_id'];
            $objSalary->branch_id = $requestData['branch_id'];
            $objSalary->technology_id = $requestData['technology_id'];
            $objSalary->date = date('Y-m-d', strtotime($requestData['date']));
            $objSalary->month_of = $requestData['month_of'];
            $objSalary->year = $requestData['year'];
            $objSalary->remarks = $requestData['remarks'] ?? '-';
            $objSalary->amount = $requestData['amount'];
            $objSalary->is_deleted = 'N';
            $objSalary->created_at = date('Y-m-d H:i:s');
            $objSalary->updated_at = date('Y-m-d H:i:s');
            if ($objSalary->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                unset($requestData['_token']);
                $objAudittrails = new Audittrails();
                $res = $objAudittrails->add_audit('I', $inputData, 'Salary');
                return 'added';
            }
            return 'wrong';
        }
        return 'salary_name_exists';
    }

    public function saveEdit($requestData)
    {
        $countSalary = Salary::from('salary')
            ->where('salary.manager_id', $requestData['manager_id'])
            ->where('salary.branch_id', $requestData['branch_id'])
            ->where('salary.technology_id', $requestData['technology_id'])
            ->where('salary.month_of', $requestData['month_of'])
            ->where('salary.is_deleted', 'N')
            ->where('salary.id', "!=", $requestData['editId'])
            ->count();
        if ($countSalary == 0) {
            $objSalary = Salary::find($requestData['editId']);
            $objSalary->manager_id = $requestData['manager_id'];
            $objSalary->branch_id = $requestData['branch_id'];
            $objSalary->technology_id = $requestData['technology_id'];
            $objSalary->date = date('Y-m-d', strtotime($requestData['date']));
            $objSalary->month_of = $requestData['month_of'];
            $objSalary->year = $requestData['year'];
            $objSalary->remarks = $requestData['remarks'] ?? '-';
            $objSalary->amount = $requestData['amount'];
            $objSalary->updated_at = date('Y-m-d H:i:s');
            if ($objSalary->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                //unset($requestData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit('U', $inputData, 'Salary');
                return 'added';
            }
            return 'wrong';
        }
        return 'salary_name_exists';
    }

    public function get_salary_details($salaryId)
    {
        return Salary::from('salary')
            ->join("manager", "manager.id", "=", "salary.manager_id")
            ->join("branch", "branch.id", "=", "salary.branch_id")
            ->join("technology", "technology.id", "=", "salary.technology_id")
            ->select('salary.id', 'salary.manager_id', 'salary.branch_id', 'salary.technology_id','manager.manager_name', 'branch.branch_name', 'technology.technology_name', 'salary.date', 'salary.month_of', 'salary.remarks', 'salary.amount', 'salary.year')
            ->where('salary.id', $salaryId)
            ->first();
    }
    public function common_activity($requestData)
    {

        $objSalary = Salary::find($requestData['id']);
        if ($requestData['activity'] == 'delete-records') {
            $objSalary->is_deleted = "Y";
            $event = 'D';
        }

        if ($requestData['activity'] == 'restore-records') {
            $objSalary->is_deleted = "N";
            $event = 'R';
        }

        if ($requestData['activity'] == 'active-records') {
            $objSalary->status = "A";
            $event = 'Active Records';
        }

        if ($requestData['activity'] == 'deactive-records') {
            $objSalary->status = "I";
            $event = 'Deactive Records';
        }

        $objSalary->updated_at = date("Y-m-d H:i:s");

        if ($objSalary->save()) {
            $currentRoute = Route::current()->getName();
            unset($requestData['_token']);
            $objAudittrails = new Audittrails();
            // $res = $objAudittrails->add_audit($event, str_replace(".", "/", $currentRoute), json_encode($requestData), 'Salary');
            $res = $objAudittrails->add_audit($event, $requestData, 'Salary');

            return true;
        } else {
            return false;
        }
    }

    public function get_admin_salary_details($manager,$branch,$technology)
    {
        return Salary::from('salary')
            ->select('salary.id', 'salary.date', 'salary.month_of', 'salary.remarks', 'salary.amount')
            ->where('salary.manager_id', $manager)
            ->where('salary.branch_id', $branch)
            ->where('salary.technology_id', $technology)
            ->where('salary.is_deleted', 'N')
            ->get()->toArray();
    }

    public function getExpenseReportsData($fillterdata){
        $data = collect(range(11, 0));
        $month_array = [];
        $amount_array = [];
        foreach($data as $key => $value){

        $dt = today()->startOfMonth()->subMonth($value);

        $month_name = $dt->shortMonthName."-".$dt->format('Y');
        array_push($month_array, $month_name);

        $month =  date("Y-m-", strtotime($month_name));

            $query = Expense::from('expense')
            ->where('date','LIKE',$month.'%')
            ->where('is_deleted', 'N');

            if($fillterdata['manager'] != null && $fillterdata['manager'] != ''){
                $query->where("manager_id", $fillterdata['manager']);
            }

            if($fillterdata['branch'] != null && $fillterdata['branch'] != ''){
                $query->where("branch_id", $fillterdata['branch']);
            }

            if($fillterdata['type'] != null && $fillterdata['type'] != ''){
                $query->where("type_id", $fillterdata['type']);
            }

            if($fillterdata['startDate'] != null && $fillterdata['startDate'] != ''){
                $query->whereDate('date', '>=', date('Y-m-d', strtotime($fillterdata['startDate'])));
            }
            if($fillterdata['endDate'] != null && $fillterdata['endDate'] != ''){
                $query->whereDate('date', '<=',  date('Y-m-d', strtotime($fillterdata['endDate'])));
            }
            $res = $query->select(DB::raw("SUM(amount) as amount"))->get();

        array_push($amount_array, check_value($res[0]->amount));
    }
    $details['month'] = $month_array;
    $details['amount'] = $amount_array;
    return $details;
    }
    public function getRevenueReportsData($fillterdata){
        $data = collect(range(11, 0));
        $month_array = [];
        $amount_array = [];
        foreach($data as $key => $value){

            $dt = today()->startOfMonth()->subMonth($value);

            $month_name = $dt->shortMonthName."-".$dt->format('Y');
            array_push($month_array, $month_name);

            $month =  date("Y-m-", strtotime($month_name));

                $query = Revenue::from('revenue')
                ->where('date','LIKE',$month.'%')
                ->where('is_deleted', 'N');

                if($fillterdata['manager'] != null && $fillterdata['manager'] != ''){
                    $query->where("manager_id", $fillterdata['manager']);
                }

                if($fillterdata['technology'] != null && $fillterdata['technology'] != ''){
                    $query->where("technology_id", $fillterdata['technology']);
                }
                $res = $query->select(DB::raw("SUM(amount) as amount"))->get();

            array_push($amount_array, check_value($res[0]->amount));
        }
        $details['month'] = $month_array;
        $details['amount'] = $amount_array;
        return $details;
    }

    public function getSalaryReportsData($fillterdata){
        if($fillterdata['time'] == 'monthly'){
            $data = collect(range(1, 12));
            $details['month'] =  [ 'January'.$fillterdata['year'], 'February'.$fillterdata['year'], 'March'.$fillterdata['year'], 'April'.$fillterdata['year'], 'May'.$fillterdata['year'], 'June'.$fillterdata['year'], 'July'.$fillterdata['year'], 'August'.$fillterdata['year'], 'September'.$fillterdata['year'], 'October'.$fillterdata['year'], 'November'.$fillterdata['year'], 'December'.$fillterdata['year']];
        } elseif($fillterdata['time'] == 'quarterly'){
            $data = collect(range(1, 4));
            $details['month'] =  [ 'Jan-March'.$fillterdata['year'], 'Apr-Jun'.$fillterdata['year'], 'July-Sep'.$fillterdata['year'], 'Oct-Dec'.$fillterdata['year']];
        } elseif($fillterdata['time'] == 'semiannually'){
            $data = collect(range(1, 2));
            $details['month'] =  [ 'Jan-June'.$fillterdata['year'], 'July-Dec'.$fillterdata['year']];
        } else {
            $data = collect(range(1, 1));
            $details['month'] = [ 'Jan-Dec'.$fillterdata['year']];
        }
        $amount_array = [];
        foreach($data as $key => $value){

            $query = Salary::from('salary')
            ->join("branch", "branch.id", "=", "salary.branch_id")
            ->whereIn('salary.branch_id', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']] );
                if($fillterdata['time'] == 'monthly'){
                    $query->where('month_of', $value);
                } elseif($fillterdata['time'] == 'quarterly'){
                    if($value == 1){
                        $query->where('month_of', '>=', 1);
                        $query->where('month_of', '<=', 3);
                    } elseif($value == 2){
                        $query->where('month_of', '>=', 4);
                        $query->where('month_of', '<=', 6);
                    } elseif($value == 3){
                        $query->where('month_of', '>=', 7);
                        $query->where('month_of', '<=', 9);
                    } else {
                        $query->where('month_of', '>=', 10);
                        $query->where('month_of', '<=', 12);
                    }

                } elseif($fillterdata['time'] == 'semiannually'){
                    if($value == 1){
                        $query->where('month_of', '>=', 1);
                        $query->where('month_of', '<=', 6);
                    } else {
                        $query->where('month_of', '>=', 7);
                        $query->where('month_of', '<=', 12);
                    }
                }

                $query->where('year', $fillterdata['year'])->where('salary.is_deleted', 'N');


                if($fillterdata['manager'] != null && $fillterdata['manager'] != ''){
                    $query->where("manager_id", $fillterdata['manager']);
                }

                if($fillterdata['technology'] != null && $fillterdata['technology'] != ''){
                    $query->where("technology_id", $fillterdata['technology']);
                }
                $res = $query->select(DB::raw("SUM(amount) as amount"))->get();

            array_push($amount_array, check_value($res[0]->amount));
        }
        $details['amount'] = $amount_array;
        return $details;
    }

    public function getProfitLossReportsData($fillterdata){
        if($fillterdata['time'] == 'monthly'){
            $data = collect(range(1, 12));
            $details['month'] =  [ 'January'.$fillterdata['year'], 'February'.$fillterdata['year'], 'March'.$fillterdata['year'], 'April'.$fillterdata['year'], 'May'.$fillterdata['year'], 'June'.$fillterdata['year'], 'July'.$fillterdata['year'], 'August'.$fillterdata['year'], 'September'.$fillterdata['year'], 'October'.$fillterdata['year'], 'November'.$fillterdata['year'], 'December'.$fillterdata['year']];
        } elseif($fillterdata['time'] == 'quarterly'){
            $data = collect(range(1, 4));
            $details['month'] =  [ 'Jan-March'.$fillterdata['year'], 'Apr-Jun'.$fillterdata['year'], 'July-Sep'.$fillterdata['year'], 'Oct-Dec'.$fillterdata['year']];
        } elseif($fillterdata['time'] == 'semiannually'){
            $data = collect(range(1, 2));
            $details['month'] =  [ 'Jan-June'.$fillterdata['year'], 'July-Dec'.$fillterdata['year']];
        } else {
            $data = collect(range(1, 1));
            $details['month'] = [ 'Jan-Dec'.$fillterdata['year']];
        }
        $salary_array = [];
        $expense_array = [];
        $revenue_array = [];
        foreach($data as $key => $value){

            $salaryQuery = Salary::from('salary')
            ->join("branch", "branch.id", "=", "salary.branch_id")
            ->whereIn('salary.branch_id', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']] );;
            if($fillterdata['time'] == 'monthly'){
                $salaryQuery->where('month_of', $value);
            } elseif($fillterdata['time'] == 'quarterly'){
                if($value == 1){
                    $salaryQuery->where('month_of', '>=', 1);
                    $salaryQuery->where('month_of', '<=', 3);
                } elseif($value == 2){
                    $salaryQuery->where('month_of', '>=', 4);
                    $salaryQuery->where('month_of', '<=', 6);
                } elseif($value == 3){
                    $salaryQuery->where('month_of', '>=', 7);
                    $salaryQuery->where('month_of', '<=', 9);
                } else {
                    $salaryQuery->where('month_of', '>=', 10);
                    $salaryQuery->where('month_of', '<=', 12);
                }

            } elseif($fillterdata['time'] == 'semiannually'){
                if($value == 1){
                    $salaryQuery->where('month_of', '>=', 1);
                    $salaryQuery->where('month_of', '<=', 6);
                } else {
                    $salaryQuery->where('month_of', '>=', 7);
                    $salaryQuery->where('month_of', '<=', 12);
                }
            }

            $salaryQuery->where('year', $fillterdata['year'])->where('salary.is_deleted', 'N');

                if($fillterdata['technology'] != null && $fillterdata['technology'] != ''){
                    $salaryQuery->where("technology_id", $fillterdata['technology']);
                }
                if($fillterdata['branch'] != null && $fillterdata['branch'] != ''){
                    $salaryQuery->where("branch_id", $fillterdata['branch']);
                }
                if($fillterdata['month'] != null && $fillterdata['month'] != ''){
                    $salaryQuery->where("month_of", $fillterdata['month']);
                }

                $salary = $salaryQuery->select(DB::raw("SUM(amount) as amount"))->get();
                array_push($salary_array, check_value($salary[0]->amount));

            $expenseQuery = Expense::from('expense')->join("branch", "branch.id", "=", "expense.branch_id")
            ->whereIn('expense.branch_id', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']] );;
            if($fillterdata['time'] == 'monthly'){
                $expenseQuery->where('month', $value);
            } elseif($fillterdata['time'] == 'quarterly'){
                if($value == 1){
                    $expenseQuery->where('month', '>=', 1);
                    $expenseQuery->where('month', '<=', 3);
                } elseif($value == 2){
                    $expenseQuery->where('month', '>=', 4);
                    $expenseQuery->where('month', '<=', 6);
                } elseif($value == 3){
                    $expenseQuery->where('month', '>=', 7);
                    $expenseQuery->where('month', '<=', 9);
                } else {
                    $expenseQuery->where('month', '>=', 10);
                    $expenseQuery->where('month', '<=', 12);
                }

            } elseif($fillterdata['time'] == 'semiannually'){
                if($value == 1){
                    $expenseQuery->where('month', '>=', 1);
                    $expenseQuery->where('month', '<=', 6);
                } else {
                    $expenseQuery->where('month', '>=', 7);
                    $expenseQuery->where('month', '<=', 12);
                }
            }

            $expenseQuery->where('year', $fillterdata['year'])->where('expense.is_deleted', 'N');

            if($fillterdata['branch'] != null && $fillterdata['branch'] != ''){
                $expenseQuery->where("branch_id", $fillterdata['branch']);
            }
            if($fillterdata['month'] != null && $fillterdata['month'] != ''){
                $expenseQuery->where("month", $fillterdata['month']);
            }

            $expense = $expenseQuery->select(DB::raw("SUM(amount) as amount"))->get();
            array_push($expense_array, check_value($expense[0]->amount));

            $revenueQuery = Revenue::from('revenue');
            if($fillterdata['time'] == 'monthly'){
                $revenueQuery->where('month_of', $value);
            } elseif($fillterdata['time'] == 'quarterly'){
                if($value == 1){
                    $revenueQuery->where('month_of', '>=', 1);
                    $revenueQuery->where('month_of', '<=', 3);
                } elseif($value == 2){
                    $revenueQuery->where('month_of', '>=', 4);
                    $revenueQuery->where('month_of', '<=', 6);
                } elseif($value == 3){
                    $revenueQuery->where('month_of', '>=', 7);
                    $revenueQuery->where('month_of', '<=', 9);
                } else {
                    $revenueQuery->where('month_of', '>=', 10);
                    $revenueQuery->where('month_of', '<=', 12);
                }

            } elseif($fillterdata['time'] == 'semiannually'){
                if($value == 1){
                    $revenueQuery->where('month_of', '>=', 1);
                    $revenueQuery->where('month_of', '<=', 6);
                } else {
                    $revenueQuery->where('month_of', '>=', 7);
                    $revenueQuery->where('month_of', '<=', 12);
                }
            }

            $revenueQuery->where('year', $fillterdata['year'])->where('is_deleted', 'N');

            if($fillterdata['technology'] != null && $fillterdata['technology'] != ''){
                $revenueQuery->where("technology_id", $fillterdata['technology']);
            }

            if($fillterdata['month'] != null && $fillterdata['month'] != ''){
                $revenueQuery->where("month_of", $fillterdata['month']);
            }

            $revenue = $revenueQuery->select(DB::raw("SUM(amount) as amount"))->get();
            array_push($revenue_array, check_value($revenue[0]->amount));
        }

        $details['amount'] = ['salary' => $salary_array, 'expense' => $expense_array, 'revenue' => $revenue_array];
        return $details;
    }

    public function getProfitLossByTimeReportsData($fillterdata){

        $details = [];
        $month_names =[];

        for ($i = 0; $i < 12; $i++) {
            $month = today()->addMonths($i)->format('M-Y');
            $month_names[] = $month;

            if($fillterdata['time'] == 'monthly'){
                $currentMonth = today()->format('M-Y');
                $month_names[] = $currentMonth;

                $salaryQuery = Salary::from('salary')
                ->where('month_of', date("n", strtotime($currentMonth)))
                ->where('year', date("Y", strtotime($currentMonth)))
                ->where('is_deleted', 'N');

                $expenseQuery = Expense::from('expense')
                ->where('month', date("n", strtotime($currentMonth)))
                ->where('year', date("Y", strtotime($currentMonth)))
                ->where('is_deleted', 'N');

                $revenueQuery = Revenue::from('revenue')
                ->where('month_of', date("n", strtotime($currentMonth)))
                ->where('year', date("Y", strtotime($currentMonth)))
                ->where('is_deleted', 'N');


            } elseif($fillterdata['time'] == 'quarterly'){

            } elseif($fillterdata['time'] == 'semiannually'){

            } else {
            }


            $salary = $salaryQuery->sum('amount');
            $details['salary'] = round($salary);

            $Expense = $expenseQuery->sum('amount');
            $details['expense'] = round($Expense);

            $revenue = $revenueQuery->sum('amount');
            $details['revenue'] = round($revenue);
        }
        return $details;
    }
    public function getProfitLossByTimeReportsDataMonthly($fillterdata){
        $details = [];
        $month_names =[];

        for ($i = 0; $i < 12; $i++) {
            $month = today()->addMonths($i)->format('M-Y');
            $month_names[] = $month;

            $currentMonth = today()->format('M-Y');
            $month_names[] = $currentMonth;

            $salaryQuery = Salary::from('salary')
            ->where('month_of', date("n", strtotime($currentMonth)))
            ->whereYear('date', date("Y", strtotime($currentMonth)))
            ->where('is_deleted', 'N');

            $salary = $salaryQuery->sum('amount');

            $details['salary'] = round($salary);
            $expenseQuery = Expense::from('expense')
            ->where('month', date("n", strtotime($currentMonth)))
            ->whereYear('date', date("Y", strtotime($currentMonth)))
            ->where('is_deleted', 'N');

            $Expense = $expenseQuery->sum('amount');
            $details['expense'] = round($Expense);

            $revenueQuery = Revenue::from('revenue')
            ->where('month_of', date("n", strtotime($currentMonth)))
            ->whereYear('date', date("Y", strtotime($currentMonth)))
            ->where('is_deleted', 'N');

            $revenue = $revenueQuery->sum('amount');
            $details['revenue'] = round($revenue);
        }
        return $details;
    }
    public function getProfitLossByTimeReportsDataAnnually($fillterdata){
        $details = [];

        $start_date = today();
        $end_date = today()->subMonth(12);

        $salaryQuery = Salary::where('is_deleted', 'N')
        ->whereBetween('date', [date("Y", strtotime($end_date)),date("Y", strtotime($start_date))])
        ->orWhereBetween('month_of', [date("n", strtotime($end_date)),date("n", strtotime($start_date))])
        ->sum('amount');

        $details['salary'] = round($salaryQuery);

        $expenseQuery = Expense::where('is_deleted', 'N')
        ->whereBetween('date', [date("Y", strtotime($end_date)),date("Y", strtotime($start_date))])
        ->orWhereBetween('month', [date("n", strtotime($end_date)),date("n", strtotime($start_date))])
        ->sum('amount');

        $details['expense'] = round($expenseQuery);

        $revenueQuery = Revenue::where('is_deleted', 'N')
        ->whereBetween('date', [date("Y", strtotime($end_date)),date("Y", strtotime($start_date))])
        ->orWhereBetween('month_of', [date("n", strtotime($end_date)),date("n", strtotime($start_date))])
        ->sum('amount');

        $details['revenue'] = round($revenueQuery);

        return $details;
    }
    public function getProfitLossByTimeReportsDataSemiAnnually($fillterdata){
        $details = [];

        $start_date = today();
        $end_date = today()->subMonth(6);

        $salaryQuery = Salary::where('is_deleted', 'N')
        ->whereBetween('date', [date("Y", strtotime($end_date)),date("Y", strtotime($start_date))])
        ->orWhereBetween('month_of', [date("n", strtotime($end_date)),date("n", strtotime($start_date))])
        ->sum('amount');

        $details['salary'] = round($salaryQuery);

        $expenseQuery = Expense::where('is_deleted', 'N')
        ->whereBetween('date', [date("Y", strtotime($end_date)),date("Y", strtotime($start_date))])
        ->orWhereBetween('month', [date("n", strtotime($end_date)),date("n", strtotime($start_date))])
        ->sum('amount');

        $details['expense'] = round($expenseQuery);

        $revenueQuery = Revenue::where('is_deleted', 'N')
        ->whereBetween('date', [date("Y", strtotime($end_date)),date("Y", strtotime($start_date))])
        ->orWhereBetween('month_of', [date("n", strtotime($end_date)),date("n", strtotime($start_date))])
        ->sum('amount');

        $details['revenue'] = round($revenueQuery);

        return $details;
    }
    public function getProfitLossByTimeReportsDataQuarterly($fillterdata){
        $details = [];

        $start_date = today();
        $end_date = today()->subMonth(3);

        $salaryQuery = Salary::where('is_deleted', 'N')
        ->whereBetween('date', [date("Y", strtotime($end_date)),date("Y", strtotime($start_date))])
        ->orWhereBetween('month_of', [date("n", strtotime($end_date)),date("n", strtotime($start_date))])
        ->sum('amount');

        $details['salary'] = round($salaryQuery);

        $expenseQuery = Expense::where('is_deleted', 'N')
        ->whereBetween('date', [date("Y", strtotime($end_date)),date("Y", strtotime($start_date))])
        ->orWhereBetween('month', [date("n", strtotime($end_date)),date("n", strtotime($start_date))])
        ->sum('amount');

        $details['expense'] = round($expenseQuery);

        $revenueQuery = Revenue::where('is_deleted', 'N')
        ->whereBetween('date', [date("Y", strtotime($end_date)),date("Y", strtotime($start_date))])
        ->orWhereBetween('month_of', [date("n", strtotime($end_date)),date("n", strtotime($start_date))])
        ->sum('amount');

        $details['revenue'] = round($revenueQuery);

        return $details;
    }

}

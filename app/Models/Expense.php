<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Carbon;
use Route;

class Expense extends Model
{
    use HasFactory;

    protected $table = "expense";


    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'expense.id',
            1 =>  DB::raw('DATE_FORMAT(expense.date, "%d-%b-%Y")'),
            2 => 'manager.manager_name',
            3 => 'branch.branch_name',
            4 => 'type.type_name',
            5 => DB::raw('CONCAT(MONTHNAME(CONCAT("2023-", expense.month, "-01")), "-", year)'),
            6 => 'expense.amount',
            7 => 'expense.remarks',
        );

        $query = Expense::from('expense')
            ->join("manager", "manager.id", "=", "expense.manager_id")
            ->join("branch", "branch.id", "=", "expense.branch_id")
            ->join("type", "type.id", "=", "expense.type_id")
            ->whereIn('expense.branch_id', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
            ->where("expense.is_deleted", "=", "N");

        if ($fillterdata['manager'] != null && $fillterdata['manager'] != '') {
            $query->where("manager.id", $fillterdata['manager']);
        }

        if ($fillterdata['branch'] != null && $fillterdata['branch'] != '') {
            $query->where("branch.id", $fillterdata['branch']);
        }

        if ($fillterdata['type'] != null && $fillterdata['type'] != '') {
            $query->where("type.id", $fillterdata['type']);
        }

        if ($fillterdata['month'] != null && $fillterdata['month'] != '') {
            $query->where("expense.month", $fillterdata['month']);
        }

        if ($fillterdata['year'] != null && $fillterdata['year'] != '') {
            $query->where("expense.year", $fillterdata['year']);
        }

        if ($fillterdata['month'] != null && $fillterdata['month'] != '' && $fillterdata['year'] != null && $fillterdata['year'] != '') {
            $query->where(DB::raw('CONCAT(month, "-", year)'), $fillterdata['month'] . "-" . $fillterdata['year']);
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
            ->select('expense.id', 'manager.manager_name', 'branch.branch_name', 'type.type_name', 'expense.date', 'expense.month', DB::raw('CONCAT(MONTHNAME(CONCAT("2023-", expense.month, "-01")), "-", year) as fullYear'), 'expense.amount', 'expense.remarks')
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {

            $target = [];
            $target = [51, 52, 53];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if (Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0) {
                $actionhtml = '';
            }
            if (Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(51, explode(',', $permission_array[0]['permission'])))
                $actionhtml .= '<a href="' . route('admin.expense.view', $row['id']) . '" class="btn btn-icon"><i class="fa fa-eye text-primary"> </i></a>';

            if (Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(52, explode(',', $permission_array[0]['permission'])))
                $actionhtml .= '<a href="' . route('admin.expense.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

            if (Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(53, explode(',', $permission_array[0]['permission'])))
                $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = date_formate($row['date']);
            $nestedData[] = $row['manager_name'];
            $nestedData[] = $row['branch_name'];
            $nestedData[] = $row['type_name'];
            $monthName = $row['fullYear'];
            $nestedData[] = $monthName;
            $nestedData[] = numberformat($row['amount']);
            if (strlen($row['remarks']) > $max_length) {
                $nestedData[] = substr($row['remarks'], 0, $max_length) . '...';
            } else {
                $nestedData[] = $row['remarks']; // If it's not longer than max_length, keep it as is
            }
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
        $countExpenses = Expense::from('expense')
            ->where('expense.manager_id', $requestData['manager_id'])
            ->where('expense.branch_id', $requestData['branch_id'])
            ->where('expense.type_id', $requestData['type_id'])
            ->where('expense.month', $requestData['month'])
            ->where('expense.is_deleted', 'N')
            ->count();

        if ($countExpenses == 0) {
            $objExpense = new Expense();
            $objExpense->manager_id = $requestData['manager_id'];
            $objExpense->branch_id = $requestData['branch_id'];
            $objExpense->type_id = $requestData['type_id'];
            $objExpense->date = date('Y-m-d', strtotime($requestData['date']));
            $objExpense->month = $requestData['month'];
            $objExpense->year = $requestData['year'];
            $objExpense->remarks = $requestData['remarks'] ?? '-';
            $objExpense->amount = $requestData['amount'];
            $objExpense->is_deleted = 'N';
            $objExpense->created_at = date('Y-m-d H:i:s');
            $objExpense->updated_at = date('Y-m-d H:i:s');
            if ($objExpense->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                // unset($requestData['_token']);
                $objAudittrails = new Audittrails();
                $res = $objAudittrails->add_audit('A', $inputData, 'Expense');
                return 'added';
            }
            return 'wrong';
        }
        return 'expense_name_exists';
    }

    public function saveEdit($requestData)
    {
        $countExpense = Expense::from('expense')
            ->where('expense.manager_id', $requestData['manager_id'])
            ->where('expense.branch_id', $requestData['branch_id'])
            ->where('expense.type_id', $requestData['type_id'])
            ->where('expense.month', $requestData['month'])
            ->where('expense.is_deleted', 'N')
            ->where('expense.id', "!=", $requestData['editId'])
            ->count();
        if ($countExpense == 0) {
            $objExpense = Expense::find($requestData['editId']);
            $objExpense->manager_id = $requestData['manager_id'];
            $objExpense->branch_id = $requestData['branch_id'];
            $objExpense->type_id = $requestData['type_id'];
            $objExpense->date = date('Y-m-d', strtotime($requestData['date']));
            $objExpense->month = $requestData['month'];
            $objExpense->year = $requestData['year'];
            $objExpense->remarks = $requestData['remarks'] ?? '-';
            $objExpense->amount = $requestData['amount'];
            $objExpense->updated_at = date('Y-m-d H:i:s');
            if ($objExpense->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                //unset($requestData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit('U', $inputData, 'Expense');
                return 'added';
            }
            return 'wrong';
        }
        return 'expense_name_exists';
    }

    public function get_expense_details($expenseId)
    {
        return Expense::from('expense')
            ->join("manager", "manager.id", "=", "expense.manager_id")
            ->join("branch", "branch.id", "=", "expense.branch_id")
            ->join("type", "type.id", "=", "expense.type_id")
            ->select('expense.id', 'expense.manager_id', 'expense.branch_id', 'expense.type_id', 'manager.manager_name', 'branch.branch_name', 'type.type_name', 'expense.date', 'expense.month', 'expense.year', 'expense.remarks', 'expense.amount')
            ->where('expense.id', $expenseId)
            ->first();
    }

    public function common_activity($requestData)
    {

        $objExpense = Expense::find($requestData['id']);
        if ($requestData['activity'] == 'delete-records') {
            $objExpense->is_deleted = "Y";
            $event = 'Delete Records';
        }

        if ($requestData['activity'] == 'active-records') {
            $objExpense->status = "A";
            $event = 'Active Records';
        }

        if ($requestData['activity'] == 'deactive-records') {
            $objExpense->status = "I";
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

    public function get_admin_expense_details($manager, $branch, $type)
    {
        return Expense::from('expense')
            ->select('expense.id', 'expense.date', 'expense.month', 'expense.remarks', 'expense.amount')
            ->where('expense.manager_id', $manager)
            ->where('expense.branch_id', $branch)
            ->where('expense.type', $type)
            ->where('expense.is_deleted', 'N')
            ->get()->toArray();
    }

    public function getExpenseReportsData($fillterdata)
    {
        $details = [];
        if ($fillterdata['time'] == 'monthly') {
            $data = collect(range(1, 12));
            $details['month'] =  ['Jan - ' . $fillterdata['year'], 'Feb - ' . $fillterdata['year'], 'Mar - ' . $fillterdata['year'], 'Apr - ' . $fillterdata['year'], 'May - ' . $fillterdata['year'], 'Jun - ' . $fillterdata['year'], 'Jul - ' . $fillterdata['year'], 'Aug - ' . $fillterdata['year'], 'Sep - ' . $fillterdata['year'], 'Oct - ' . $fillterdata['year'], 'Nov - ' . $fillterdata['year'], 'Dec - ' . $fillterdata['year']];
        } elseif ($fillterdata['time'] == 'quarterly') {
            $data = collect(range(1, 4));
            $details['month'] =  ['Jan-March' . $fillterdata['year'], 'Apr-Jun' . $fillterdata['year'], 'July-Sep' . $fillterdata['year'], 'Oct-Dec' . $fillterdata['year']];
        } elseif ($fillterdata['time'] == 'semiannually') {
            $data = collect(range(1, 2));
            $details['month'] =  ['Jan-June' . $fillterdata['year'], 'July-Dec' . $fillterdata['year']];
        } else {
            $data = collect(range(1, 1));
            $details['month'] = ['Jan-Dec' . $fillterdata['year']];
        }

        $userBranch = $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']];
        $details['amount'] = [];
        foreach ($data as $key => $value) {
            foreach($userBranch as $ub_key => $ub_value){
                $qurey = Branch::from('branch')
                ->leftjoin("expense", "expense.branch_id", "=", "branch.id")
                ->where('branch.id', $ub_value);
                if ($fillterdata['time'] == 'monthly') {
                    $qurey->where('month', $value);
                } else if ($fillterdata['time'] == 'quarterly') {
                    if ($value == 1) {
                        $qurey->where('expense.month', '>=', 1);
                        $qurey->where('expense.month', '<=', 3);
                    } elseif ($value == 2) {
                        $qurey->where('expense.month', '>=', 4);
                        $qurey->where('expense.month', '<=', 6);
                    } elseif ($value == 3) {
                        $qurey->where('expense.month', '>=', 7);
                        $qurey->where('expense.month', '<=', 9);
                    } else {
                        $qurey->where('expense.month', '>=', 10);
                        $qurey->where('expense.month', '<=', 12);
                    }
                } elseif ($fillterdata['time'] == 'semiannually') {
                    if ($value == 1) {
                        $qurey->where('expense.month', '>=', 1);
                        $qurey->where('expense.month', '<=', 6);
                    } else {
                        $qurey->where('expense.month', '>=', 7);
                        $qurey->where('expense.month', '<=', 12);
                    }
                }

                $qurey->where('expense.year', $fillterdata['year'])
                    ->where('expense.is_deleted', 'N');

                if ($fillterdata['type'] != null && $fillterdata['type'] != '') {
                    $qurey->where("type_id", $fillterdata['type']);
                }

                if ($fillterdata['manager'] != null && $fillterdata['manager'] != '') {
                    $qurey->where("manager_id", $fillterdata['manager']);
                }
                $result = $qurey->select(DB::raw("COALESCE(SUM(expense.amount), 0) as amount"), 'branch.branch_name')->get();
                $branchName = $result[0]['branch_name'];
                if (!isset($details['amount'][$branchName])) {
                    $details['amount'][$branchName] = [];
                }
                // Push the amount value into the correct array
                array_push($details['amount'][$branchName], $result[0]['amount']);
            }
        }
        return $details;
    }


}

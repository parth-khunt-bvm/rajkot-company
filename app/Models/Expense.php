<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
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
            1 => 'manager.manager_name',
            2 => 'branch.branch_name',
            3 => 'type.type_name',
            4 => 'expense.date',
            5 => DB::raw('MONTHNAME(CONCAT("2023-", expense.month, "-01"))'),
            6 => 'expense.amount',
            7 => 'expense.remarks',
        );

        $query = Expense::from('expense')
            ->join("manager", "manager.id", "=", "expense.manager_id")
            ->join("branch", "branch.id", "=", "expense.branch_id")
            ->join("type", "type.id", "=", "expense.type_id")
            ->where("expense.is_deleted", "=", "N");

            if($fillterdata['manager'] != null && $fillterdata['manager'] != ''){
                $query->where("manager.id", $fillterdata['manager']);
            }

            if($fillterdata['branch'] != null && $fillterdata['branch'] != ''){
                $query->where("branch.id", $fillterdata['branch']);
            }

            if($fillterdata['type'] != null && $fillterdata['type'] != ''){
                $query->where("type.id", $fillterdata['type']);
            }

            if($fillterdata['month'] != null && $fillterdata['month'] != ''){
                $query->where("expense.month", $fillterdata['month']);
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
            ->select('expense.id', 'manager.manager_name', 'branch.branch_name', 'type.type_name','expense.date', 'expense.month', DB::raw('MONTHNAME(CONCAT("2023-", expense.month, "-01")) as month_name'), 'expense.amount','expense.remarks')
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {

            $actionhtml = '';
            $actionhtml .= '<a href="' . route('admin.expense.view', $row['id']) . '" class="btn btn-icon"><i class="fa fa-eye text-primary"> </i></a>';
            $actionhtml .= '<a href="' . route('admin.expense.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['manager_name'];
            $nestedData[] = $row['branch_name'];
            $nestedData[] = $row['type_name'];
            $nestedData[] = date_formate($row['date']);
            $monthName = $row['month_name'];
            $nestedData[] = $monthName;
            $nestedData[] = numberformat($row['amount']);
            if (strlen($row['remarks']) > $max_length) {
                $nestedData[] = substr($row['remarks'], 0, $max_length) . '...';
            }else {
                $nestedData[] = $row['remarks']; // If it's not longer than max_length, keep it as is
            }
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
            $objExpense->remarks = $requestData['remarks'] ?? '-';
            $objExpense->amount = $requestData['amount'];
            $objExpense->is_deleted = 'N';
            $objExpense->created_at = date('Y-m-d H:i:s');
            $objExpense->updated_at = date('Y-m-d H:i:s');
            if ($objExpense->save()) {
                unset($requestData['_token']);
                $objAudittrails = new Audittrails();
                $res = $objAudittrails->add_audit('A', $requestData, 'Expense');
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
            $objExpense->remarks = $requestData['remarks'] ?? '-';
            $objExpense->amount = $requestData['amount'];
            $objExpense->updated_at = date('Y-m-d H:i:s');
            if ($objExpense->save()) {
                unset($requestData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit('U', $requestData, 'Expense');
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
            ->select('expense.id', 'expense.manager_id', 'expense.branch_id', 'expense.type_id','manager.manager_name', 'branch.branch_name', 'type.type_name', 'expense.date', 'expense.month', 'expense.remarks', 'expense.amount')
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

    public function get_admin_expense_details($manager,$branch,$type)
    {
        return Expense::from('expense')
            ->select('expense.id', 'expense.date', 'expense.month', 'expense.remarks', 'expense.amount')
            ->where('expense.manager_id', $manager)
            ->where('expense.branch_id', $branch)
            ->where('expense.type', $type)
            ->where('expense.is_deleted', 'N')
            ->get()->toArray();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Route;

class HrExpense extends Model
{
    use HasFactory;

    protected $table = 'hr_expense';

    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'hr_expense.id',
            1 => DB::raw('DATE_FORMAT(hr_expense.date, "%d-%b-%Y")'),
            2 => DB::raw('MONTHNAME(CONCAT("2023-", hr_expense.month, "-01"))'),
            3 => 'hr_expense.amount',
            4 => 'hr_expense.remarks',
        );

        $query = HrExpense::from('hr_expense')
            ->where("hr_expense.is_deleted", "=", "N");

            if($fillterdata['month'] != null && $fillterdata['month'] != ''){
                $query->where("hr_expense.month", $fillterdata['month']);
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
            ->select('hr_expense.id','hr_expense.date', DB::raw('MONTHNAME(CONCAT("2023-", hr_expense.month, "-01")) as month_name'), 'hr_expense.amount','hr_expense.remarks')
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;

        foreach ($resultArr as $row) {
            $target = [];
            $target = [69, 70, 71];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }
            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(69, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.hr.expense.view', $row['id']) . '" class="btn btn-icon"><i class="fa fa-eye text-primary"> </i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(70, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.hr.expense.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(71, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = date_formate($row['date']);
            $nestedData[] = $row['month_name'];
            $nestedData[] = numberformat($row['amount'],2);
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
        $countHrExpense = HrExpense::from('hr_expense')
            ->where('hr_expense.date',date('Y-m-d', strtotime($requestData['date'])))
            ->where('hr_expense.month', $requestData['month'])
            ->where("hr_expense.is_deleted", "=", "N")
            ->count();

        if ($countHrExpense == 0) {
            $objHrHrExpense = new HrExpense();
            $objHrHrExpense->date = date('Y-m-d', strtotime($requestData['date']));
            $objHrHrExpense->month = $requestData['month'];
            $objHrHrExpense->remarks = $requestData['remarks'] ?? '-';
            $objHrHrExpense->amount = $requestData['amount'];
            $objHrHrExpense->is_deleted = 'N';
            $objHrHrExpense->created_at = date('Y-m-d H:i:s');
            $objHrHrExpense->updated_at = date('Y-m-d H:i:s');
            if ($objHrHrExpense->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $res = $objAudittrails->add_audit('I', $inputData, 'HrExpense');
                return 'added';
            }
            return 'wrong';
        }
        return 'hr_expense_exists';
    }

    public function saveEdit($requestData)
    {
            $countHrExpense = HrExpense::from('hr_expense')
            ->where('hr_expense.date',date('Y-m-d', strtotime($requestData['date'])))
            ->where('hr_expense.month', $requestData['month'])
            ->where("hr_expense.is_deleted", "=", "N")
            ->where('hr_expense.id', "!=", $requestData['editId'])
            ->count();

        if ($countHrExpense == 0) {
            $objHrExpense = HrExpense::find($requestData['editId']);
            $objHrExpense->date = date('Y-m-d', strtotime($requestData['date'])) ?? "-";
            $objHrExpense->month = $requestData['month'];
            $objHrExpense->remarks = $requestData['remarks'] ?? '-';
            $objHrExpense->amount = $requestData['amount'];
            $objHrExpense->updated_at = date('Y-m-d H:i:s');
            if ($objHrExpense->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit('U', $inputData, 'HrExpense');
                return 'added';
            }
            return 'wrong';
        }
        return 'hr_expense_exists';
    }

    public function get_hr_expense_details($HrExpenseid)
    {
        return HrExpense::from('hr_expense')
            ->select('hr_expense.id','hr_expense.date', 'hr_expense.month', 'hr_expense.remarks', 'hr_expense.amount')
            ->where('hr_expense.id', $HrExpenseid)
            ->first();
    }

    public function common_activity($requestData)
    {

        $objHrExpense = HrExpense::find($requestData['id']);

        if ($requestData['activity'] == 'delete-records') {
            $objHrExpense->is_deleted = "Y";
            $event = 'Delete Records';
        }

        $objHrExpense->updated_at = date("Y-m-d H:i:s");

        if ($objHrExpense->save()) {
            $currentRoute = Route::current()->getName();
            unset($requestData['_token']);
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'HrExpense');
            return true;
        } else {
            return false;
        }
    }
}

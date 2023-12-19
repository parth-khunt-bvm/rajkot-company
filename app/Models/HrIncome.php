<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Route;

class HrIncome extends Model
{
    use HasFactory;
    protected $table = 'hr_income';

    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'hr_income.id',
            1 => 'hr_income.date',
            2 => 'manager.manager_name',
            3 => DB::raw('(CASE WHEN hr_income.payment_mode = "1" THEN "Cash" ELSE "Bank Transfer" END)'),
            4 => DB::raw('CONCAT(MONTHNAME(CONCAT("2023-", hr_income.month_of, "-01")), "-", year)'),
            5 => 'hr_income.amount',
            6 => 'hr_income.remarks',
        );

        $query = HrIncome::from('hr_income')
            ->join("manager", "manager.id", "=", "hr_income.manager_id")
            ->where("hr_income.is_deleted", "=", "N");

            if($fillterdata['manager'] != null && $fillterdata['manager'] != ''){
                $query->where("manager.id", $fillterdata['manager']);
            }

            if($fillterdata['monthOf'] != null && $fillterdata['monthOf'] != ''){
                $query->where("hr_income.month_of", $fillterdata['monthOf']);
            }

            if($fillterdata['year'] != null && $fillterdata['year'] != ''){
                $query->where("hr_income.year", $fillterdata['year']);
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
            ->select('hr_income.id', 'manager.manager_name', 'hr_income.payment_mode','hr_income.date', DB::raw('CONCAT(MONTHNAME(CONCAT("2023-", hr_income.month_of, "-01")), "-", year) as month_name'), 'hr_income.amount','hr_income.remarks')
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;

        foreach ($resultArr as $row) {

            $target = [];
            $target = [63, 64, 65];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }
            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(63, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.hr.income.view', $row['id']) . '" class="btn btn-icon"><i class="fa fa-eye text-primary"> </i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(64, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.hr.income.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

            if ($row['payment_mode'] == '1') {
                $payment_mode = '<span>Cash</span>';
            } else {
                $payment_mode = '<span>Bank Transfer</span>';
            }

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(65, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = date_formate($row['date']);
            $nestedData[] = $row['manager_name'];
            $nestedData[] = $payment_mode;
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
        $countHrIncome = HrIncome::from('hr_income')
            ->where('hr_income.manager_id', $requestData['manager_id'])
            ->where('hr_income.month_of', $requestData['month_of'])
            ->where("hr_income.is_deleted", "=", "N")
            ->count();

        if ($countHrIncome == 0) {
            $objHrIncome = new HrIncome();
            $objHrIncome->manager_id = $requestData['manager_id'];
            $objHrIncome->payment_mode	 = $requestData['payment_mode'];
            $objHrIncome->date = date('Y-m-d', strtotime($requestData['date']));
            $objHrIncome->month_of = $requestData['month_of'];
            $objHrIncome->year = $requestData['year'];
            $objHrIncome->remarks = $requestData['remarks'] ?? '-';
            $objHrIncome->amount = $requestData['amount'];
            $objHrIncome->is_deleted = 'N';
            $objHrIncome->created_at = date('Y-m-d H:i:s');
            $objHrIncome->updated_at = date('Y-m-d H:i:s');
            if ($objHrIncome->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $res = $objAudittrails->add_audit('I', $inputData, 'HrIncome');
                return 'added';
            }
            return 'wrong';
        }
        return 'hr_income_exists';
    }

    public function saveEdit($requestData)
    {

            $countHrIncome = HrIncome::from('hr_income')
            ->where('hr_income.manager_id', $requestData['manager_id'])
            ->where('hr_income.month_of', $requestData['month_of'])
            ->where("hr_income.is_deleted", "=", "N")
            ->where('hr_income.id', "!=", $requestData['editId'])
            ->count();

        if ($countHrIncome == 0) {
            $objHrIncome = HrIncome::find($requestData['editId']);
            $objHrIncome->manager_id = $requestData['manager_id'];
            $objHrIncome->payment_mode = $requestData['payment_mode'];
            $objHrIncome->date = date('Y-m-d', strtotime($requestData['date']));
            $objHrIncome->month_of = $requestData['month_of'];
            $objHrIncome->year = $requestData['year'];
            $objHrIncome->remarks = $requestData['remarks'] ?? '-';
            $objHrIncome->amount = $requestData['amount'];
            $objHrIncome->updated_at = date('Y-m-d H:i:s');
            if ($objHrIncome->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit('U', $inputData, 'HrIncome');
                return 'added';
            }
            return 'wrong';
        }
        return 'hr_income_exists';
    }

    public function get_hr_income_details($hrIncomeid)
    {
        return HrIncome::from('hr_income')
            ->join("manager", "manager.id", "=", "hr_income.manager_id")
            ->select('hr_income.id', 'hr_income.manager_id','manager.manager_name','hr_income.payment_mode', 'hr_income.date', 'hr_income.month_of', 'hr_income.year', 'hr_income.remarks', 'hr_income.amount')
            ->where('hr_income.id', $hrIncomeid)
            ->first();
    }

    public function common_activity($requestData)
    {

        $objHrIncome = HrIncome::find($requestData['id']);

        if ($requestData['activity'] == 'delete-records') {
            $objHrIncome->is_deleted = "Y";
            $event = 'Delete Records';
        }

        $objHrIncome->updated_at = date("Y-m-d H:i:s");

        if ($objHrIncome->save()) {
            $currentRoute = Route::current()->getName();
            unset($requestData['_token']);
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'HrIncome');
            return true;
        } else {
            return false;
        }
    }
}

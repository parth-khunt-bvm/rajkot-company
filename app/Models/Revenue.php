<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Route;

class Revenue extends Model
{
    use HasFactory;

    protected $table = 'revenue';

    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'revenue.id',
            1 => 'manager.manager_name',
            2 => 'technology.technology_name',
            3 => 'revenue.date',
            4 => DB::raw('MONTHNAME(CONCAT("2023-", revenue.month_of, "-01"))'),
            5 => DB::raw('MONTHNAME(CONCAT("2023-", revenue.received_month, "-01"))'),
            6 => 'revenue.amount',
            7 => 'revenue.bank_name',
            8 => 'revenue.holder_name',
        );

        $query = Revenue::from('revenue')
            ->join("manager", "manager.id", "=", "revenue.manager_id")
            ->join("technology", "technology.id", "=", "revenue.technology_id")
            ->where("revenue.is_deleted", "=", "N");


            if($fillterdata['manager'] != null && $fillterdata['manager'] != ''){
                $query->where("manager.id", $fillterdata['manager']);
            }

            if($fillterdata['technology'] != null && $fillterdata['technology'] != ''){
                $query->where("technology.id", $fillterdata['technology']);
            }

            if($fillterdata['receivedMonth'] != null && $fillterdata['receivedMonth'] != ''){
                $query->where("revenue.received_month", $fillterdata['receivedMonth']);
            }

            if($fillterdata['monthOf'] != null && $fillterdata['monthOf'] != ''){
                $query->where("revenue.month_of", $fillterdata['monthOf']);
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
            ->select('revenue.id', 'manager.manager_name', 'technology.technology_name','revenue.date', DB::raw('MONTHNAME(CONCAT("2023-", revenue.received_month, "-01")) as received_month'), DB::raw('MONTHNAME(CONCAT("2023-", revenue.month_of, "-01")) as month_name'), 'revenue.amount', 'revenue.bank_name','revenue.holder_name')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {

            $actionhtml = '';
            $actionhtml .= '<a href="' . route('admin.revenue.view', $row['id']) . '" class="btn btn-icon"><i class="fa fa-eye text-primary"> </i></a>';
            $actionhtml .= '<a href="' . route('admin.revenue.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['manager_name'];
            $nestedData[] = $row['technology_name'];
            $nestedData[] = date_formate($row['date']);
            $nestedData[] = $row['received_month'];
            $nestedData[] = $row['month_name'];
            $nestedData[] = numberformat($row['amount']);
            $nestedData[] = $row['bank_name'];
            $nestedData[] = $row['holder_name'];
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
        $countRevenue = Revenue::from('revenue')
            ->where('revenue.manager_id', $requestData['manager_id'])
            ->where('revenue.technology_id', $requestData['technology_id'])
            ->where('revenue.received_month', $requestData['received_month'])
            ->where('revenue.month_of', $requestData['month_of'])
            ->where('revenue.is_deleted', 'N')
            ->count();

        if ($countRevenue == 0) {
            $objRevenue = new Revenue();
            $objRevenue->manager_id = $requestData['manager_id'];
            $objRevenue->technology_id = $requestData['technology_id'];
            $objRevenue->date = date('Y-m-d', strtotime($requestData['date']));
            $objRevenue->received_month = $requestData['received_month'];
            $objRevenue->month_of = $requestData['month_of'];
            $objRevenue->remarks = $requestData['remarks'] ?? '-';
            $objRevenue->amount = $requestData['amount'];
            $objRevenue->bank_name = $requestData['bank_name'];
            $objRevenue->holder_name = $requestData['holder_name'];
            $objRevenue->is_deleted = 'N';
            $objRevenue->created_at = date('Y-m-d H:i:s');
            $objRevenue->updated_at = date('Y-m-d H:i:s');
            if ($objRevenue->save()) {
                unset($requestData['_token']);
                $objAudittrails = new Audittrails();
                $res = $objAudittrails->add_audit('I', $requestData, 'Revenue');
                return 'added';
            }
            return 'wrong';
        }
        return 'revenue_exists';
    }

    public function saveEdit($requestData)
    {
            $countRevenue = Revenue::from('revenue')
            ->where('revenue.manager_id', $requestData['manager_id'])
            ->where('revenue.technology_id', $requestData['technology_id'])
            ->where('revenue.received_month', $requestData['received_month'])
            ->where('revenue.month_of', $requestData['month_of'])
            ->where('revenue.is_deleted', 'N')
            ->where('revenue.id', "!=", $requestData['editId'])
            ->count();
        if ($countRevenue == 0) {
            $objRevenue = Revenue::find($requestData['editId']);
            $objRevenue->manager_id = $requestData['manager_id'];
            $objRevenue->technology_id = $requestData['technology_id'];
            $objRevenue->date = date('Y-m-d', strtotime($requestData['date']));
            $objRevenue->received_month = $requestData['received_month'];
            $objRevenue->month_of = $requestData['month_of'];
            $objRevenue->remarks = $requestData['remarks'] ?? '-';
            $objRevenue->amount = $requestData['amount'];
            $objRevenue->bank_name = $requestData['bank_name'];
            $objRevenue->holder_name = $requestData['holder_name'];
            $objRevenue->updated_at = date('Y-m-d H:i:s');
            if ($objRevenue->save()) {
                unset($requestData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit('U', $requestData, 'Revenue');
                return 'added';
            }
            return 'wrong';
        }
        return 'revenue_exists';
    }

    public function get_revenue_details($revenueid)
    {
        return Revenue::from('revenue')
            ->join("manager", "manager.id", "=", "revenue.manager_id")
            ->join("technology", "technology.id", "=", "revenue.technology_id")
            ->select('revenue.id', 'revenue.manager_id', 'revenue.technology_id','manager.manager_name', 'technology.technology_name', 'revenue.date', 'revenue.month_of','revenue.received_month', 'revenue.remarks', 'revenue.amount', 'revenue.bank_name', 'revenue.holder_name')
            ->where('revenue.id', $revenueid)
            ->first();
    }

    public function common_activity($requestData)
    {

        $objRevenue = Revenue::find($requestData['id']);
        if ($requestData['activity'] == 'delete-records') {
            $objRevenue->is_deleted = "Y";
            $event = 'Delete Records';
        }

        if ($requestData['activity'] == 'active-records') {
            $objRevenue->status = "A";
            $event = 'Active Records';
        }

        if ($requestData['activity'] == 'deactive-records') {
            $objRevenue->status = "I";
            $event = 'Deactive Records';
        }

        $objRevenue->updated_at = date("Y-m-d H:i:s");

        if ($objRevenue->save()) {
            $currentRoute = Route::current()->getName();
            unset($requestData['_token']);
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'Revenue');
            return true;
        } else {
            return false;
        }
    }

}

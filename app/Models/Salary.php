<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Route;
use Session;
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
            1 => 'manager.manager_name',
            2 => 'branch.branch_name',
            3 => 'technology.technology_name',
            4 => 'salary.date',
            5 => DB::raw('MONTHNAME(CONCAT("2023-", salary.month_of, "-01"))'),
            6 => 'salary.amount',
            7 => 'salary.remarks',
        );

        $query = Salary::from('salary')
            ->join("manager", "manager.id", "=", "salary.manager_id")
            ->join("branch", "branch.id", "=", "salary.branch_id")
            ->join("technology", "technology.id", "=", "salary.technology_id")
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
            ->select('salary.id', 'manager.manager_name', 'branch.branch_name', 'technology.technology_name','salary.date', 'salary.month_of', DB::raw('MONTHNAME(CONCAT("2023-", salary.month_of, "-01")) as month_name'), 'salary.amount','salary.remarks')
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {

            $actionhtml = '';
            $actionhtml .= '<a href="' . route('admin.salary.view', $row['id']) . '" class="btn btn-icon"><i class="fa fa-eye text-primary"> </i></a>';
            $actionhtml .= '<a href="' . route('admin.salary.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['manager_name'];
            $nestedData[] = $row['branch_name'];
            $nestedData[] = $row['technology_name'];
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
            $objSalary->remarks = $requestData['remarks'] ?? '-';
            $objSalary->amount = $requestData['amount'];
            $objSalary->is_deleted = 'N';
            $objSalary->created_at = date('Y-m-d H:i:s');
            $objSalary->updated_at = date('Y-m-d H:i:s');
            if ($objSalary->save()) {
                unset($requestData['_token']);
                $objAudittrails = new Audittrails();
                $res = $objAudittrails->add_audit('I', $requestData, 'Salary');
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
            $objSalary->remarks = $requestData['remarks'] ?? '-';
            $objSalary->amount = $requestData['amount'];
            $objSalary->updated_at = date('Y-m-d H:i:s');
            if ($objSalary->save()) {
                unset($requestData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit('U', $requestData, 'Salary');
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
            ->select('salary.id', 'salary.manager_id', 'salary.branch_id', 'salary.technology_id','manager.manager_name', 'branch.branch_name', 'technology.technology_name', 'salary.date', 'salary.month_of', 'salary.remarks', 'salary.amount')
            ->where('salary.id', $salaryId)
            ->first();
    }

    public function common_activity($requestData)
    {

        $objSalary = Salary::find($requestData['id']);
        if ($requestData['activity'] == 'delete-records') {
            $objSalary->is_deleted = "Y";
            $event = 'Delete Records';
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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Route;
use Session;

class Salary extends Model
{
    use HasFactory;

    protected $table = 'salary';

    public function getdatatable()
    {
        // ccd($employee_list);
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'salary.id',
            1 => 'manager.manager_id',
            2 => 'manager.branch_id',
            3 => 'manager.technology_id',
            4 => 'salary.date',
            5 => 'salary.month_of',
            6 => 'salary.remarks',
            7 => 'salary.amount',
            8 => DB::raw('(CASE WHEN salary.status = "A" THEN "Actived" ELSE "Deactived" END)'),

        );
        $query = Salary::from('salary')
            ->join("manager", "manager.id", "=", "salary.manager_id")
            ->join("branch", "branch.id", "=", "salary.branch_id")
            ->join("technology", "technology.id", "=", "salary.technology_id")
            ->where("salary.is_deleted", "=", "N");

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
            ->select('salary.id', 'manager.manager_id', 'branch.branch_id', 'technology.technology_id','salary.date', 'salary.month_of', 'salary.remarks', 'salary.amount', 'salary.status')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {

            $actionhtml = '';
            $actionhtml .= '<a href="' . route('salary.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';
            if ($row['status'] == 'A') {
                $status = '<span class="label label-lg label-light-success label-inline">Active</span>';
                $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deactiveModel" class="btn btn-icon  deactive-records" data-id="' . $row["id"] . '" ><i class="fa fa-times text-primary" ></i></a>';
            } else {
                $status = '<span class="label label-lg label-light-danger  label-inline">Deactive</span>';
                $actionhtml .= '<a href="#" data-toggle="modal" data-target="#activeModel" class="btn btn-icon  active-records" data-id="' . $row["id"] . '" ><i class="fa fa-check text-primary" ></i></a>';
            }
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['manager_id'];
            $nestedData[] = $row['branch_id'];
            $nestedData[] = $row['technology_id'];
            $nestedData[] = $row['date'];
            $nestedData[] = $row['month_of'];
            $nestedData[] = $row['remarks'];
            $nestedData[] = $row['amount'];
            $nestedData[] = $status;
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
            ->where('salary.date', $requestData['date'])
            ->where('salary.month_of', $requestData['month_of'])
            ->where('salary.remarks', $requestData['remarks'])
            ->where('salary.amount', $requestData['amount'])
            ->where('salary.is_deleted', 'N')
            ->count();
        if ($countSalary == 0) {
            $objSalary = new Salary();
            $objSalary->manager_id = $requestData['manager_id'];
            $objSalary->branch_id = $requestData['branch_id'];
            $objSalary->technology_id = $requestData['technology_id'];
            $objSalary->date = $requestData['date'];
            $objSalary->month_of = $requestData['month_of'];
            $objSalary->remarks = $requestData['remarks'];
            $objSalary->amount = $requestData['amount'];
            $objSalary->status = $requestData['status'];
            $objSalary->is_deleted = 'N';
            $objSalary->created_at = date('Y-m-d H:i:s');
            $objSalary->updated_at = date('Y-m-d H:i:s');
            if ($objSalary->save()) {
                $currentRoute = Route::current()->getName();
                unset($requestData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit('Insert', str_replace(".", "/", $currentRoute), json_encode($requestData->input()), 'Salary');
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
            ->where('salary.date', $requestData['date'])
            ->where('salary.month_of', $requestData['month_of'])
            ->where('salary.remarks', $requestData['remarks'])
            ->where('salary.amount', $requestData['amount'])
            ->where('salary.is_deleted', 'N')
            ->count();
        if ($countSalary == 0) {
            $objSalary = Salary::find($requestData['editId']);
            $objSalary->manager_id = $requestData['manager_id'];
            $objSalary->branch_id = $requestData['branch_id'];
            $objSalary->technology_id = $requestData['technology_id'];
            $objSalary->date = $requestData['date'];
            $objSalary->month_of = $requestData['month_of'];
            $objSalary->remarks = $requestData['remarks'];
            $objSalary->amount = $requestData['amount'];
            $objSalary->status = $requestData['status'];
            $objSalary->updated_at = date('Y-m-d H:i:s');
            if ($objSalary->save()) {
                $currentRoute = Route::current()->getName();
                unset($requestData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit('Update', str_replace(".", "/", $currentRoute), json_encode($requestData->input()), 'Salary');
                return 'added';
            }
            return 'wrong';
        }
        return 'salary_name_exists';
    }

    public function get_salary_details($salaryId)
    {
        return Salary::from('salary')
            ->select('salary.id', 'salary.manager_id', 'salary.branch_id', 'salary.technology_id', 'salary.date', 'salary.month_of', 'salary.remarks', 'salary.amount', 'salary.status')
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
            $res = $objAudittrails->add_audit($event, str_replace(".", "/", $currentRoute), json_encode($requestData), 'Salary');
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
            ->where('salary.status', 'A')
            ->get()->toArray();
    }
}

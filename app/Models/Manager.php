<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Route;
use Session;
use Hash;

class Manager extends Model
{
    use HasFactory;

    protected $table = "manager";

    public function getdatatable()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'manager.id',
            1 => 'manager.manager_name',
            2 => DB::raw('(CASE WHEN manager.status = "A" THEN "Actived" ELSE "Deactived" END)'),
        );
        $query = Manager::from('manager')
            ->where("manager.is_deleted", "=", "N");

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
            ->select('manager.id', 'manager.manager_name','manager.status')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $actionhtml = '';
            $actionhtml .= '<a href="' . route('admin.manager.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';
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
            // $nestedData[] = $row['id'];
            $nestedData[] = $row['manager_name'];
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
        $checkManagerName = Manager::from('manager')
            ->where('manager.manager_name', $requestData['manager_name'])
            ->where('manager.is_deleted', 'N')
            ->count();

        if ($checkManagerName == 0) {
            $objManager = new Manager();
            $objManager->manager_name = $requestData['manager_name'];
            $objManager->status = $requestData['status'];
            $objManager->is_deleted = 'N';
            $objManager->created_at = date('Y-m-d H:i:s');
            $objManager->updated_at = date('Y-m-d H:i:s');
            if ($objManager->save()) {
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $requestData, 'Manager');
                return 'added';
            } else {
                return 'wrong';
            }
        }
        return 'manager_name_exists';
    }

    public function saveEdit($requestData){
        $checkManagerName = Manager::from('manager')
            ->where('manager.manager_name', $requestData['manager_name'])
            ->where('manager.is_deleted', 'N')
            ->where('manager.id', '!=', $requestData['manager_Id'])
            ->count();

        if($checkManagerName == 0) {
            $objManager = Manager::find($requestData['manager_Id']);
            $objManager->manager_name = $requestData['manager_name'];
            $objManager->status = $requestData['status'];
            $objManager->updated_at = date('Y-m-d H:i:s');
            if ($objManager->save()) {
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $requestData, 'Manager');
                return 'updated';
            } else {
                return 'wrong';
            }
        }
        return 'manager_name_exists';
    }

    public function get_manager_details($managerId){
        return Manager::from('manager')
            ->where("manager.id", $managerId)
            ->select('manager.id', 'manager.manager_name', 'manager.status')
            ->first();
    }

    public function common_activity($requestData){
        $objBranch = Manager::find($requestData['id']);
        if($requestData['activity'] == 'delete-records'){
            $objBranch->is_deleted = "Y";
            $event = 'D';
        }

        if($requestData['activity'] == 'active-records'){
            $objBranch->status = "A";
            $event = 'A';
        }

        if($requestData['activity'] == 'deactive-records'){
            $objBranch->status = "I";
            $event = 'DA';
        }

        $objBranch->updated_at = date("Y-m-d H:i:s");
        if($objBranch->save()){
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'Manager');
            return true;
        }else{
            return false ;
        }
    }
}

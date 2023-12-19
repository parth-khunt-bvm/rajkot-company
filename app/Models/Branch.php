<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Audittrails;

class Branch extends Model
{
    use HasFactory;
    protected $table= "branch";

    public function getdatatable()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'branch.id',
            1 => 'branch.branch_name',
            2 => DB::raw('(CASE WHEN branch.status = "A" THEN "Actived" ELSE "Deactived" END)'),

        );
        $query = Branch::from('branch')
            ->where("branch.is_deleted", "=", "N");

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
            ->select( 'branch.id', 'branch.branch_name', 'branch.status')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {

            $target = [];
            $target = [20, 21, 22, 23];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(21, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.branch.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(22, explode(',', $permission_array[0]['permission'])) ){
                if ($row['status'] == 'A') {
                    $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deactiveModel" class="btn btn-icon  deactive-records" data-id="' . $row["id"] . '" ><i class="fa fa-times text-primary" ></i></a>';
                } else {
                    $actionhtml .= '<a href="#" data-toggle="modal" data-target="#activeModel" class="btn btn-icon  active-records" data-id="' . $row["id"] . '" ><i class="fa fa-check text-primary" ></i></a>';
                }
            }
          if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(23, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['branch_name'];
            $nestedData[] = $row['status'] == 'A' ? '<span class="label label-lg label-light-success label-inline">Active</span>' : '<span class="label label-lg label-light-danger  label-inline">Deactive</span>';
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

    public function saveAdd($requestData){
        $checkBranchName = Branch::from('branch')
                    ->where('branch.branch_name', $requestData['branch_name'])
                    ->where('branch.is_deleted', 'N')
                    ->count();

        if($checkBranchName == 0){
            $objBranch = new Branch();
            $objBranch->branch_name = $requestData['branch_name'];
            $objBranch->status = $requestData['status'];
            $objBranch->is_deleted = 'N';
            $objBranch->created_at = date('Y-m-d H:i:s');
            $objBranch->updated_at = date('Y-m-d H:i:s');
            if($objBranch->save()){
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $requestData, 'Branch');
                return 'added';
            }else{
                return 'wrong';
            }
        }
        return 'branch_name_exists';
    }

    public function get_branch_details($branchId){
        return Branch::from('branch')
                ->where("branch.id", $branchId)
                ->select('branch.id', 'branch.branch_name', 'branch.status')
                ->first();
    }

    public function saveEdit($requestData){
        $checkBranchName = Branch::from('branch')
                    ->where('branch.branch_name', $requestData['branch_name'])
                    ->where('branch.is_deleted', 'N')
                    ->where('branch.id', '!=', $requestData['branch_Id'])
                    ->count();

        if($checkBranchName == 0){
            $objBranch = Branch::find($requestData['branch_Id']);
            $objBranch->branch_name = $requestData['branch_name'];
            $objBranch->status = $requestData['status'];
            $objBranch->updated_at = date('Y-m-d H:i:s');
            if($objBranch->save()){
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $requestData, 'Branch');
                return 'updated';
            }else{
                return 'wrong';
            }
        }
        return 'branch_name_exists';
    }

    public function common_activity($requestData){

        $objBranch = Branch::find($requestData['id']);
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
            $res = $objAudittrails->add_audit($event, $requestData, 'Branch');
            return true;
        }else{
            return false ;
        }
    }


    public function get_admin_branch_details(){
        return Branch::from('branch')
            ->select('branch.id','branch.branch_name','branch.status')
            ->get();
    }
}

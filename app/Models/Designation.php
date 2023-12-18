<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;


class Designation extends Model
{
    use HasFactory;

    protected $table = "designation";

    public function getdatatable()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'designation.id',
            1 => 'designation.designation_name',
            2 => DB::raw('(CASE WHEN designation.status = "A" THEN "Actived" ELSE "Deactived" END)'),
        );
        $query = Designation::from('designation')
            ->where("designation.is_deleted", "=", "N");

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
            ->select('designation.id', 'designation.designation_name', 'designation.status')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $target = [];
            $target = [39, 40, 41];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(39, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.designation.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(40, explode(',', $permission_array[0]['permission'])) ){
                if ($row['status'] == 'A') {
                    $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deactiveModel" class="btn btn-icon  deactive-records" data-id="' . $row["id"] . '" ><i class="fa fa-times text-primary" ></i></a>';
                } else {
                    $actionhtml .= '<a href="#" data-toggle="modal" data-target="#activeModel" class="btn btn-icon  active-records" data-id="' . $row["id"] . '" ><i class="fa fa-check text-primary" ></i></a>';
                }
            }
            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(41, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['designation_name'];
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

    public function saveAdd($requestData)
    {
        $checkManagerName = Designation::from('designation')
            ->where('designation.designation_name', $requestData['designation_name'])
            ->where('designation.is_deleted', 'N')
            ->count();

        if ($checkManagerName == 0) {
            $objDesignation = new Designation();
            $objDesignation->designation_name = $requestData['designation_name'];
            $objDesignation->status = $requestData['status'];
            $objDesignation->is_deleted = 'N';
            $objDesignation->created_at = date('Y-m-d H:i:s');
            $objDesignation->updated_at = date('Y-m-d H:i:s');
            if ($objDesignation->save()) {
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $requestData, 'Designation');
                return 'added';
            } else {
                return 'wrong';
            }
        }
        return 'designation_name_exists';
    }

    public function saveEdit($requestData)
    {
        $checkManagerName = Designation::from('designation')
        ->where('designation.designation_name', $requestData['designation_name'])
        ->where('designation.is_deleted', 'N')
        ->where('designation.id', '!=', $requestData['designationId'])
        ->count();

        if($checkManagerName == 0) {
            $objDesignation = Designation::find($requestData['designationId']);
            $objDesignation->designation_name = $requestData['designation_name'];
            $objDesignation->status = $requestData['status'];
            $objDesignation->updated_at = date('Y-m-d H:i:s');
            if ($objDesignation->save()) {
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $requestData, 'Designation');
                return 'updated';
            } else {
                return 'wrong';
            }
        }
        return 'designation_name_exists';
    }

    public function get_designation_details($designationId)
    {
        return Designation::from('designation')
            ->select('designation.id', 'designation.designation_name', 'designation.status')
            ->where('designation.id', $designationId)
            ->first();
    }

    public function common_activity($requestData){
        $objBranch = Designation::find($requestData['id']);
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
            $res = $objAudittrails->add_audit($event, $requestData, 'Designation');
            return true;
        }else{
            return false ;
        }
    }

        public function get_admin_designation_details(){
        return Designation::from('designation')
            ->select('designation.id','designation.designation_name','designation.status')
            ->get();
      }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Route;
class UserRole extends Model
{
    use HasFactory;

    protected $table = 'user_role';

    public function getdatatable()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'user_role.id',
            1 => 'user_role.user_role',
            2 => DB::raw('(CASE WHEN user_role.status = "A" THEN "Actived" ELSE "Deactived" END)'),
        );
        $query = UserRole::from('user_role')
            ->where("user_role.is_deleted", "=", "N");

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
            ->select('user_role.id', 'user_role.user_role', 'user_role.status','user_role.permission')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {

            $actionhtml  = '';
            // $actionhtml .= '<a href="' . route('admin.user-role.view', $row['id']) . '" class="btn btn-icon"><i class="fa fa-eye text-primary"> </i></a>';
            $actionhtml =  '<a href="' . route('admin.user-role.view', $row['id']) . '" class="btn btn-icon" title="Permission" ><i class="fa fa-lock text-success"> </i></a>';

            $actionhtml .= '<a href="' . route('admin.user-role.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';
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
            $nestedData[] = $row['user_role'];
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
        $checkUserRoleName = UserRole::from('user_role')
            ->where('user_role.user_role', $requestData['user_role_name'])
            ->where('user_role.is_deleted', 'N')
            ->count();

        if ($checkUserRoleName == 0) {
                    $objUserRole = new UserRole();
                    $objUserRole->user_role = $requestData['user_role_name'];
                    $objUserRole->status = $requestData['status'];
                    $objUserRole->is_deleted = 'N';
                    $objUserRole->created_at = date('Y-m-d H:i:s');
                    $objUserRole->updated_at = date('Y-m-d H:i:s');

                    if ( $objUserRole->save()) {
                        $objAudittrails = new Audittrails();
                        $objAudittrails->add_audit("I", $requestData, 'user_role');
                        return "added";
                    } else {
                        return 'wrong';
                    }
        }
        return 'user_role_name_exists';
    }

    public function saveEdit($requestData)
    {
        $checkUserRoleName = UserRole::from('user_role')
        ->where('user_role.user_role', $requestData['user_role_name'])
        ->where('user_role.is_deleted', 'N')
        ->where('user_role.id', '!=', $requestData['user_role_Id'])
        ->count();

        if ($checkUserRoleName == 0) {
            $objUserRole = UserRole::find($requestData['user_role_Id']);
            $objUserRole->user_role = $requestData['user_role_name'];
            $objUserRole->status = $requestData['status'];
            $objUserRole->updated_at = date('Y-m-d H:i:s');
            if ($objUserRole->save()) {
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $requestData, 'user_role');
                return 'updated';
            } else {
                return 'wrong';
            }
        }
        return 'user_role_name_exists';
    }

    public function common_activity($requestData)
    {

        $objUserRole = UserRole::find($requestData['id']);
        if ($requestData['activity'] == 'delete-records') {
            $objUserRole->is_deleted = "Y";
            $event = 'D';
        }

        if ($requestData['activity'] == 'active-records') {
            $objUserRole->status = "A";
            $event = 'A';
        }

        if ($requestData['activity'] == 'deactive-records') {
            $objUserRole->status = "I";
            $event = 'DA';
        }

        $objUserRole->updated_at = date("Y-m-d H:i:s");
        if ($objUserRole->save()) {
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'user_role');
            return true;
        } else {
            return false;
        }
    }

    public function get_user_role_details($userRoleId){
        return UserRole::from('user_role')
        ->where("user_role.id", $userRoleId)
        ->select('user_role.id', 'user_role.user_role', 'user_role.status','user_role.permission')
        ->first();
    }

    public function get_user_permission_details($userId){
        return  UserRole::from('user_role')
                         ->where('user_role.id', $userId)
                         ->select('user_role.permission')
                         ->get()
                         ->toArray();
    }


    public function save_user_roles_permissions($requestData){

        $objUserRole =  UserRole::find($requestData->input('editId'));

        if($requestData->input('permission')){
            $objUserRole->permission = implode(",",$requestData->input('permission'));
        }else{
            $objUserRole->permission = null;
        }

        $objUserRole->updated_at = date("Y-m-d H:i:s");

        if ($objUserRole->save()) {
            $objAudittrails = new Audittrails();
            $objAudittrails->add_audit("U", $requestData, 'user_role');
            return true;
        } else {
            return false;
        }
    }


}

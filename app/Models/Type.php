<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Audittrails;

class Type extends Model
{
    use HasFactory;
    protected $table= "type";

    public function getdatatable()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'type.id',
            1 => 'type.type_name',
            2 => DB::raw('(CASE WHEN type.status = "A" THEN "Actived" ELSE "Deactived" END)'),
        );
        $query = Type::from('type')
            ->where("type.is_deleted", "=", "N");

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
            ->select( 'type.id', 'type.type_name', 'type.status')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {

            $actionhtml  = '';
            $actionhtml .= '<a href="' . route('admin.type.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';
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
            $nestedData[] = $row['type_name'];
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

    public function saveAdd($requestData){
        $checktypeName = Type::from('type')
                    ->where('type.type_name', $requestData['type_name'])
                    ->where('type.is_deleted', 'N')
                    ->count();

        if($checktypeName == 0){
            $objtype = new Type();
            $objtype->type_name = $requestData['type_name'];
            $objtype->status = $requestData['status'];
            $objtype->is_deleted = 'N';
            $objtype->created_at = date('Y-m-d H:i:s');
            $objtype->updated_at = date('Y-m-d H:i:s');
            if($objtype->save()){
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $requestData, 'type');
                return 'added';
            }else{
                return 'wrong';
            }
        }
        return 'type_name_exists';
    }

    public function get_type_details($typeId){
        return Type::from('type')
                ->where("type.id", $typeId)
                ->select('type.id', 'type.type_name', 'type.status')
                ->first();
    }

    public function saveEdit($requestData){
        $checktypeName = type::from('type')
                    ->where('type.type_name', $requestData['type_name'])
                    ->where('type.is_deleted', 'N')
                    ->where('type.id', '!=', $requestData['type_Id'])
                    ->count();

        if($checktypeName == 0){
            $objtype = Type::find($requestData['type_Id']);
            $objtype->type_name = $requestData['type_name'];
            $objtype->status = $requestData['status'];
            $objtype->updated_at = date('Y-m-d H:i:s');
            if($objtype->save()){
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $requestData, 'type');
                return 'updated';
            }else{
                return 'wrong';
            }
        }
        return 'type_name_exists';
    }

    public function common_activity($requestData){

        $objtype = Type::find($requestData['id']);
        if($requestData['activity'] == 'delete-records'){
            $objtype->is_deleted = "Y";
            $event = 'D';
        }

        if($requestData['activity'] == 'active-records'){
            $objtype->status = "A";
            $event = 'A';
        }

        if($requestData['activity'] == 'deactive-records'){
            $objtype->status = "I";
            $event = 'DA';
        }

        $objtype->updated_at = date("Y-m-d H:i:s");
        if($objtype->save()){
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'type');
            return true;
        }else{
            return false ;
        }
    }

    public function get_admin_type_details(){
        return Type::from('type')
            ->select('type.id', 'type.type_name','type.status')
            ->get();
    }
}

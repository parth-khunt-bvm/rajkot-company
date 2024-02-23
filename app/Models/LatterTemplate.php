<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class LatterTemplate extends Model
{
    use HasFactory;
    protected $table = 'latter_template';

    public function getdatatable()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'latter_template.id',
            0 => 'latter_template.template_name',
            0 => 'latter_template.template',
            2 => DB::raw('(CASE WHEN latter_template.status = "A" THEN "Actived" ELSE "Deactived" END)'),
        );

        $query = LatterTemplate::where("latter_template.is_deleted", "=", "N");

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
            ->select('latter_template.id','latter_template.template_name','latter_template.template','latter_template.status',)
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $actionhtml = '';
            $actionhtml .= '<a href="latter-templates/'.$row["id"].'/edit" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

            if ($row['status'] == 'A') {
                $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deactiveModel" class="btn btn-icon  deactive-records" data-id="' . $row["id"] . '" ><i class="fa fa-times text-primary" ></i></a>';
            } else {
                $actionhtml .= '<a href="#" data-toggle="modal" data-target="#activeModel" class="btn btn-icon  active-records" data-id="' . $row["id"] . '" ><i class="fa fa-check text-primary" ></i></a>';
            }

            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['template_name'];
            $nestedData[] = $row['template'];
            $nestedData[] = $row['status'] == 'A' ? '<span class="label label-lg label-light-success label-inline">Active</span>' : '<span class="label label-lg label-light-danger  label-inline">Deactive</span>';
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

    public function store($requestData)
    {
        $objLatterTemplate = new LatterTemplate();
        $objLatterTemplate->template_name = $requestData['template_name'];
        $objLatterTemplate->template = $requestData['template'] ?? '-';
        $objLatterTemplate->status = $requestData['status'];
        $objLatterTemplate->created_at = date('Y-m-d H:i:s');
        $objLatterTemplate->updated_at = date('Y-m-d H:i:s');
        if ($objLatterTemplate->save()) {
            $inputData = $requestData->input();
            unset($inputData['_token']);
            $objAudittrails = new Audittrails();
            $objAudittrails->add_audit("I", $inputData, 'Latter Template');
            return 'added';
        } else {
            return 'wrong';
        }
    }

    public function saveEdit($requestData){
            $objLatterTemplate = LatterTemplate::find($requestData['editId']);
            $objLatterTemplate->template_name = $requestData['template_name'];
            $objLatterTemplate->template = $requestData['template'] ?? '-';
            $objLatterTemplate->status = $requestData['status'];
            $objLatterTemplate->updated_at = date('Y-m-d H:i:s');
            if($objLatterTemplate->save()){
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $inputData, 'LatterTemplate');
                return 'updated';
            }else{
                return 'wrong';
            }

    }

    public function common_activity($requestData){

        $objLatterTemplate = LatterTemplate::find($requestData['id']);
        if($requestData['activity'] == 'delete-records'){
            $objLatterTemplate->is_deleted = "Y";
            $event = 'D';
        }

        if($requestData['activity'] == 'active-records'){
            $objLatterTemplate->status = "A";
            $event = 'A';
        }

        if($requestData['activity'] == 'deactive-records'){
            $objLatterTemplate->status = "I";
            $event = 'DA';
        }

        $objLatterTemplate->updated_at = date("Y-m-d H:i:s");
        if($objLatterTemplate->save()){
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'Latter Template');
            return true;
        }else{
            return false ;
        }
    }

    public function get_latter_template_details($id)
    {
        return LatterTemplate::where('latter_template.id', $id)->first();

    }
}

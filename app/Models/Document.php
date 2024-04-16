<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Document extends Model
{
    use HasFactory;
    protected $table= "document";

    public function getdatatable()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'document.id',
            1 => DB::raw('CONCAT(first_name, " ", last_name)'),
            1 => 'document_type.document_name',
            2 => DB::raw('(CASE WHEN document.status = "A" THEN "Actived" ELSE "Deactived" END)'),

        );
        $query = Document::from('document')
            ->join("employee", "employee.id", "=", "document.employee_id")
            ->join("document_type", "document_type.id", "=", "document.document_type")
            ->where("document.is_deleted", "=", "N");

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
            ->select( 'document.id',DB::raw('CONCAT(first_name, " ", last_name) as FullName'),'document_type.document_name', 'document.status')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {

            $target = [];
            $target = [162, 163, 164];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(162, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.document.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(163, explode(',', $permission_array[0]['permission'])) ){
                if ($row['status'] == 'A') {
                    $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deactiveModel" class="btn btn-icon  deactive-records" data-id="' . $row["id"] . '" ><i class="fa fa-times text-primary" ></i></a>';
                } else {
                    $actionhtml .= '<a href="#" data-toggle="modal" data-target="#activeModel" class="btn btn-icon  active-records" data-id="' . $row["id"] . '" ><i class="fa fa-check text-primary" ></i></a>';
                }
            }
          if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(164, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['FullName'];
            $nestedData[] = $row['document_name'];
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

        $countDocument = Document::from('document')
                    ->where('document.employee_id', $requestData['employee_id'])
                    ->where('document.document_type', $requestData['document_type_id'])
                    ->where('document.is_deleted', 'N')
                    ->count();

        if($countDocument == 0){
            $objDocument = new Document();
            $objDocument->employee_id = $requestData['employee_id'];
            $objDocument->document_type = $requestData['document_type_id'];

            if ($requestData->hasFile('attachment')) {
                $attachments = [];
                foreach ($requestData->file('attachment') as $index => $image) {
                    $increment = $index + 1;
                    $imagename = 'att' . time() . '_' . $increment . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/upload/document/');
                    $image->move($destinationPath, $imagename);
                    $attachments[] = $imagename;
                }
                $attachmentString = implode(', ', $attachments);
                $objDocument->attachement = $attachmentString;
                // $objDocument->save(); // Save the document model after updating the attachment column
            }

            $objDocument->status = $requestData['status'];
            $objDocument->is_deleted = 'N';
            $objDocument->created_at = date('Y-m-d H:i:s');
            $objDocument->updated_at = date('Y-m-d H:i:s');
            if($objDocument->save()){
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $inputData, 'Document');
                return 'added';
            }else{
                return 'wrong';
            }
        }
        return 'document_exists';
    }

    public function saveEdit($requestData){


        $countDocument = Document::from('document')
        ->where('document.employee_id', $requestData['employee_id'])
        ->where('document.document_type', $requestData['document_type_id'])
        ->where('document.is_deleted', 'N')
        ->where('document.id', '!=', $requestData['editId'])
        ->count();


        if($countDocument == 0){
            $objDocument = Document::find($requestData['editId']);
            $objDocument->employee_id = $requestData['employee_id'];
            $objDocument->document_type = $requestData['document_type_id'];

            if ($requestData->hasFile('attachment')) {

                $currentAttachments = explode(', ', $objDocument->attachement);

                foreach ($currentAttachments as $attachment) {
                    $path = public_path('/upload/document/') . $attachment;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }

                $attachments = [];
                foreach ($requestData->file('attachment') as $index => $image) {
                    $increment = $index + 1;
                    $imagename = 'att' . time() . '_' . $increment . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/upload/document/');
                    $image->move($destinationPath, $imagename);
                    $attachments[] = $imagename;
                }
                $attachmentString = implode(', ', $attachments);
                $objDocument->attachement = $attachmentString;
                // $objDocument->save(); // Save the document model after updating the attachment column
            }

            $objDocument->status = $requestData['status'];
            $objDocument->updated_at = date('Y-m-d H:i:s');
            if($objDocument->save()){
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $inputData, 'Document Type');
                return 'updated';
            }else{
                return 'wrong';
            }
        }
        return 'document_exists';
    }


    public function common_activity($requestData){

        $objDocument = Document::find($requestData['id']);
        if($requestData['activity'] == 'delete-records'){

            $currentAttachments = explode(', ', $objDocument->attachement);

            foreach ($currentAttachments as $attachment) {
                $path = public_path('/upload/document/') . $attachment;
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $objDocument->is_deleted = "Y";
            $event = 'D';
        }

        if($requestData['activity'] == 'active-records'){
            $objDocument->status = "A";
            $event = 'A';
        }

        if($requestData['activity'] == 'deactive-records'){
            $objDocument->status = "I";
            $event = 'DA';
        }

        $objDocument->updated_at = date("Y-m-d H:i:s");
        if($objDocument->save()){
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'Document');
            return true;
        }else{
            return false ;
        }
    }

    public function get_document_details($documentId){
        return Document::from('document')
                ->where("document.id", $documentId)
                ->select('document.id', 'document.employee_id', 'document.document_type', 'document.status', 'document.attachement' )
                ->first();
    }
}




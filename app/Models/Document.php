<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $table= "document";

    public function saveAdd($requestData){
        $countDocument = Document::from('document')
                    ->where('document.employee_id', $requestData['employee_id'])
                    ->where('document.employee_id', $requestData['document_type'])
                    ->where('document.is_deleted', 'N')
                    ->count();

        if($countDocument == 0){
            $objDocument = new Document();
            $objDocument->employee_id = $requestData['employee_id'];
            $objDocument->document_type = $requestData['document_type_id'];

            if($requestData->file('attachement')){
                $image = $requestData->file('attachement');
                $imagename = 'att'.time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/upload/document/');
                $image->move($destinationPath, $imagename);
                $objDocument->attachement  = $imagename ;
            }

            // if($requestData->hasFile('cancel_cheque') && $requestData->file('cancel_cheque')->isValid()){
            //     $chequeImage = time().'.'.$requestData['cancel_cheque']->extension();
            //     $requestData['cancel_cheque']->move(public_path('employee/cheque'), $chequeImage);
            // }

            // $objEmployee->cancel_cheque = $chequeImage ?? '-';

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
}




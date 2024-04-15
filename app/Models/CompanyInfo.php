<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Route;

class CompanyInfo extends Model
{
    use HasFactory;
    protected $table= "company_info";

    public function updateSystemSetting($requestData){
        $data = Auth()->guard('admin')->user();
        $result = CompanyInfo::select('id')->where('id',1)->get()->toArray();
        if(!empty($result)){
            $objCompanyinfo = CompanyInfo::find($data['id']);
        }else{
            $objCompanyinfo = new CompanyInfo();
        }

        if($requestData->file('logo')){
            $image = $requestData->file('logo');
            $imagename = 'logo'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/upload/company_info/');
            $image->move($destinationPath, $imagename);
            $objCompanyinfo->logo  = $imagename ;
        }
        if($requestData->file('favicon')){
            $image = $requestData->file('favicon');
            $imagename = 'favicon'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/upload/company_info/');
            $image->move($destinationPath, $imagename);
            $objCompanyinfo->favicon  = $imagename ;
        }
        if($requestData->file('signature')){
            $image = $requestData->file('signature');
            $imagename = 'signature'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/upload/company_info/');
            $image->move($destinationPath, $imagename);
            $objCompanyinfo->signature  = $imagename ;
        }
        $objCompanyinfo->updated_at = date("Y-m-d H:i:s");
        if($objCompanyinfo->save()){

            $objAudittrails = new Audittrails();
            $objAudittrails->add_audit("U", $requestData->all(), 'System Setting');
            return 'success';
        }else{
            return false;
        }
    }

    public function get_system_details($id){
        $result = CompanyInfo::select('logo', 'favicon', 'signature')
                            ->where('id',$id)
                            ->get()->toArray();

        if(empty($result)){
            $result[0]['logo'] = '';
            $result[0]['favicon'] = '';
            $result[0]['signature'] = '';
        }
        return $result;
    }

}

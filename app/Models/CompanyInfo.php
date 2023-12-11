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
        $objCompanyinfo = CompanyInfo::find($data['id']);
        // $objCompanyinfo = new CompanyInfo();
        $objCompanyinfo->theme_color_code = $requestData->input('theme_color_code');
        $objCompanyinfo->sidebar_color = $requestData->input('sidebar_color');
        $objCompanyinfo->sidebar_menu_font_color = $requestData->input('sidebar_menu_font_color');

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
                $objAudittrails->add_audit("u", $requestData, 'Employee');
                return 'success';
        }else{
            return false;
        }
    }

    public function get_system_details($id){
        return CompanyInfo::select('theme_color_code', 'sidebar_color', 'sidebar_menu_font_color','logo', 'favicon', 'signature')
                            ->where('id',$id)
                            ->get();
    }

}

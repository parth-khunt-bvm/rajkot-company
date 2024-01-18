<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Route;
use Hash;

class Employees extends Model
{
    use HasFactory;

    protected $table = 'employee';

    public function saveProfile($request){
        // dd($request);
        $countEmployee = Employees::where("gmail",$request->input('email'))
                        ->where("id",'!=',$request->input('edit_id'))
                        ->count();

        if($countEmployee == 0){
            $objEmployees = Employees::find($request->input('edit_id'));
            $objEmployees->first_name = $request->input('first_name');
            $objEmployees->last_name = $request->input('last_name');
            $objEmployees->gmail = $request->input('email');
            if($request->file('employee_image')){
                $image = $request->file('employee_image');
                $imagename = 'employee_image'.time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/upload/userprofile/');
                $image->move($destinationPath, $imagename);
                $objEmployees->employee_image  = $imagename ;
            }
            if($objEmployees->save()){
                $currentRoute = Route::current()->getName();
                $inputData = $request->input();
                unset($inputData['_token']);
                unset($inputData['profile_avatar_remove']);
                unset($inputData['employee_image']);
                if($request->file('employee_image')){
                    $inputData['employee_image'] = $imagename;
                }
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $inputData, 'Update Profile');
                return true;
            }else{
                return "false";
            }
        }else{
            return "email_exist";
        }
    }

    public function changepassword($request)
    {
        if (Hash::check($request->input('old_password'), $request->input('user_old_password'))) {
            $countEmployee = Employees::where("id",'=',$request->input('editid'))->count();
            if($countEmployee == 1){
                $objEmployee = Employees::find($request->input('editid'));
                $objEmployee->password =  Hash::make($request->input('new_password'));
                $objEmployee->updated_at = date('Y-m-d H:i:s');
                if($objEmployee->save()){
                    $currentRoute = Route::current()->getName();
                    $inputData = $request->input();
                    unset($inputData['_token']);
                    unset($inputData['user_old_password']);
                    unset($inputData['old_password']);
                    unset($inputData['new_password']);
                    unset($inputData['new_confirm_password']);
                    $objAudittrails = new Audittrails();
                    $objAudittrails->add_audit("U", $inputData, 'Change Password');
                    return true;
                }else{
                    return 'false';
                }
            }else{
                return "false";
            }
        }else{
            return "password_not_match";
        }
    }
}

<?php

namespace App\Imports;

use App\Models\Audittrails;
use App\Models\Branch;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Employeer;
use App\Models\Manager;
use App\Models\Technology;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Hash;
use Str;
use App\Models\Sendmail;

class EmployeeImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public $branch;
    public function __construct($branch)
    {
        $this->branch = $branch;
    }
    public function model(array $row)

    {
        if (Employee::where('branch', $this->branch)->where('gmail', $row[6])->where('personal_number', $row[18])->where('is_deleted', 'N')->count() == 0) {
            $password = Str::random(8);
            $objEmployee = new Employee();
            $objEmployee->first_name = $row[1] ;
            $objEmployee->last_name = $row[2]  ;
            $technology_name = $row[3];
            $departmentID = Technology::where('technology_name', $technology_name)->value('id');

            if($departmentID == NULL){
                $objTechnology = new Technology();
                $objTechnology->technology_name = $technology_name;
                $objTechnology->status = "A";
                $objTechnology->is_deleted = 'N';
                $objTechnology->created_at = date('Y-m-d H:i:s');
                $objTechnology->updated_at = date('Y-m-d H:i:s');
                $objTechnology->save();
                $departmentID = $objTechnology->id;
            }
            $objEmployee->department =  $departmentID;
            $objEmployee->designation = 1;
            $objEmployee->branch = $this->branch;
            $objEmployee->DOJ = $row[4] != null && $row[4] != '' ? $this->transformDate($row[4]) : NULL;
            $status = $row[5] ?? NULL;
            if ($status = "working") {
                $objEmployee->status = 'W';
            } else {
                $objEmployee->status = 'L';
            }
            $objEmployee->gmail = $row[6]  ?? NULL;
            $objEmployee->password = Hash::make($password);
            $objEmployee->gmail_password = $row[7]  ?? NULL;
            $objEmployee->slack_password = $row[8]  ?? NULL;
            $objEmployee->DOB = $row[9] != null && $row[9] != '' ? $this->transformDate($row[9]) : NULL;
            $objEmployee->bank_name = $row[10]  ?? NULL;
            $objEmployee->acc_holder_name = $row[11]  ?? NULL;
            $objEmployee->account_number = $row[12] ?? NULL;
            $objEmployee->ifsc_number = $row[13] ?? NULL;
            $objEmployee->personal_email = $row[14]  ?? NULL;
            $objEmployee->pan_number = $row[15]  ?? NULL;
            $objEmployee->aadhar_card_number = $row[16]  ?? NULL;
            $objEmployee->parents_name = $row[17]  ?? NULL;
            $objEmployee->personal_number = $row[18]  ?? NULL;
            $objEmployee->google_pay_number = $row[19]  ?? NULL;
            $objEmployee->emergency_number = $row[20]  ?? NULL;
            $objEmployee->address = $row[21]  ?? NULL;
            $objEmployee->experience = $row[22]  ?? NULL;
            $managerName = $row[23];
            $managerID = Manager::where('manager_name', $managerName)->value('id');
            if($managerID == NULL){
                $objManager = new Manager();
                $objManager->manager_name = $managerName;
                $objManager->status = "A";
                $objManager->is_deleted = 'N';
                $objManager->created_at = date('Y-m-d H:i:s');
                $objManager->updated_at = date('Y-m-d H:i:s');
                $objManager->save();
                $managerID = $objManager->id;
            }
            $objEmployee->hired_by = $managerID;
            $objEmployee->salary = $row[24]  ?? NULL;
            $objEmployee->stipend_from = $row[25] != null && $row[25] != '' ? $this->transformDate($row[25])  : NULL;
            $objEmployee->bond_last_date = $row[26] != null && $row[26] != '' ? $this->transformDate($row[26])  : NULL;
            $objEmployee->resign_date = $row[27] != null && $row[27] != '' ?  $this->transformDate($row[27]) : NULL;
            $objEmployee->last_date = $row[28] != null && $row[28] != '' ?  $this->transformDate($row[28]) : NULL;
            $objEmployee->trainee_performance = NULL;
            $objEmployee->is_deleted = 'N';
            $objEmployee->created_at = date('Y-m-d H:i:s');
            $objEmployee->updated_at = date('Y-m-d H:i:s');
            if($objEmployee->save()){

                $mailData['data']=[];
                $mailData['data']['first_name'] = $row[1];
                $mailData['data']['last_name'] = $row[2];
                $mailData['data']['gmail'] =  $row[6];
                $mailData['data']['password'] = $password;
                $mailData['subject'] = 'Rajkot Company - Add Employee';
                $mailData['data']['company'] = 'BVM Infotech';
                $mailData['attachment'] = array(
                    'image_path' => public_path('upload/company_image/logo.png'),
                );
                $mailData['template'] ="backend.pages.employee.mail";
                $mailData['mailto'] =  $row[6];
                $sendMail = new Sendmail();
                $sendMail->sendSMTPMail($mailData);
            }
        }
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
    public function startRow(): int
    {
        return 2;
    }
}

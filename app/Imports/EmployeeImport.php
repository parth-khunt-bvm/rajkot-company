<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Employeer;
use App\Models\Technology;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class EmployeeImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)

    {
        if (Employee::where('gmail', $row[4])->where('personal_number', $row[16])->where('is_deleted', 'N')->count() == 0) {
        $objEmployee = new Employee();
        $objEmployee->first_name = $row[0] ?? '-';
        $objEmployee->last_name = $row[1]  ?? '-';
        $departmentID = Technology::where('technology_name', $row[2])->value('id');
        $objEmployee->department =  $departmentID;
        $objEmployee->DOJ = date('Y-m-d', strtotime($row[3]))  ?? '-';
        $objEmployee->gmail = $row[4]  ?? rand().'gmail.com';
        $objEmployee->password = $row[5]  ?? '-';
        $objEmployee->slack_password = $row[6]  ?? '-';
        $objEmployee->DOB = date('Y-m-d', strtotime($row[7]))  ?? '-';
        $objEmployee->bank_name = $row[8]  ?? '-';
        $objEmployee->acc_holder_name = $row[9]  ?? '-';
        $objEmployee->account_number = $row[10] ?? '-' ;
        $objEmployee->ifsc_number = $row[11] ?? '-';
        $objEmployee->personal_email = $row[12]  ?? '-';
        $objEmployee->pan_number = $row[13]  ?? '-';
        $objEmployee->aadhar_card_number = $row[14]  ?? '-';
        $objEmployee->parents_name = $row[15]  ?? '-';
        $objEmployee->personal_number = $row[16]  ?? '-';
        $objEmployee->google_pay_number = $row[17]  ?? '-';
        $objEmployee->emergency_number = $row[18]  ?? '-';
        $objEmployee->address = $row[19]  ?? '-';
        $objEmployee->experience = $row[20]  ?? '-';
        $objEmployee->hired_by = $row[21]  ?? '-';
        $objEmployee->salary = $row[22]  ?? '-';
        $objEmployee->stipend_from = date('Y-m-d', strtotime($row[23]))  ?? '-';
        $objEmployee->bond_last_date = date('Y-m-d', strtotime($row[24]))  ?? '-';
        $objEmployee->resign_date = date('Y-m-d', strtotime($row[25]))  ?? '-';
        $objEmployee->last_date = date('Y-m-d', strtotime($row[26]))  ?? '-';
        $objEmployee->cancel_cheque = $row[27] ?? '-';
        $objEmployee->bond_file = $row[28] ?? '-';
        $objEmployee->trainee_performance = $row[29]  ?? '-';
        $objEmployee->status = 'A';
        $objEmployee->is_deleted = 'N';
        $objEmployee->created_at = date('Y-m-d H:i:s');
        $objEmployee->updated_at = date('Y-m-d H:i:s');
        $objEmployee->save();
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}

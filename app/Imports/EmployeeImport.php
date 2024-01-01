<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Designation;
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

    public $branch;
    public function __construct($branch)
    {
        $this->branch = $branch;
    }
    public function model(array $row)

    {
        if (Employee::where('branch', $this->branch)->where('gmail', $row[6])->where('personal_number', $row[18])->where('is_deleted', 'N')->count() == 0) {
            $objEmployee = new Employee();
            $objEmployee->first_name = $row[0] ?? '-';
            $objEmployee->last_name = $row[1]  ?? '-';
            $departmentID = Technology::where('technology_name', $row[2])->value('id');
            $objEmployee->department =  $departmentID;
            $designationID = Designation::where('designation_name', $row[3])->value('id');
            $objEmployee->designation = $designationID ?? "-";
            $objEmployee->branch = $this->branch;
            $objEmployee->DOJ = $this->transformDate($row[4]) ?? '-';
            $status = $row[5] ?? '-';
            if ($status = "working") {
                $objEmployee->status = 'W';
            } else {
                $objEmployee->status = 'L';
            }
            $objEmployee->gmail = $row[6]  ?? rand() . 'gmail.com';
            $objEmployee->password = $row[7]  ?? '-';
            $objEmployee->slack_password = $row[8]  ?? '-';
            $objEmployee->DOB = $this->transformDate($row[9]) ?? '-';
            $objEmployee->bank_name = $row[10]  ?? '-';
            $objEmployee->acc_holder_name = $row[11]  ?? '-';
            $objEmployee->account_number = $row[12] ?? '-';
            $objEmployee->ifsc_number = $row[13] ?? '-';
            $objEmployee->personal_email = $row[14]  ?? '-';
            $objEmployee->pan_number = $row[15]  ?? '-';
            $objEmployee->aadhar_card_number = $row[16]  ?? '-';
            $objEmployee->parents_name = $row[17]  ?? '-';
            $objEmployee->personal_number = $row[18]  ?? '-';
            $objEmployee->google_pay_number = $row[19]  ?? '-';
            $objEmployee->emergency_number = $row[20]  ?? '-';
            $objEmployee->address = $row[21]  ?? '-';
            $objEmployee->experience = $row[22]  ?? '-';
            $objEmployee->hired_by = $row[23]  ?? '-';
            $objEmployee->salary = $row[24]  ?? '-';
            $objEmployee->stipend_from = $this->transformDate($row[25])  ?? '-';
            $objEmployee->bond_last_date = $this->transformDate($row[26])  ?? '-';
            $objEmployee->resign_date = isset($row[27]) ? $this->transformDate($row[27]) : Null;
            $objEmployee->last_date = isset($row[28])  ? $this->transformDate($row[28]) : Null;
            $objEmployee->trainee_performance = $row[29]  ?? '-';
            $objEmployee->is_deleted = 'N';
            $objEmployee->created_at = date('Y-m-d H:i:s');
            $objEmployee->updated_at = date('Y-m-d H:i:s');
            $objEmployee->save();
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

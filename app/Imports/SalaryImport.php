<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Manager;
use App\Models\Salary;
use App\Models\Technology;
use DateTime;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Carbon;

class SalaryImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        if (Salary::where('manager_id', $row[0])->where('branch_id', $row[1])->where('technology_id', $row[2])->where('month_of', $row[4])->where('is_deleted', 'N')->count() == 0) {
            $objSalary = new Salary();
            $managerId = Manager::where('manager_name', $row[0])->value('id');
            $objSalary->manager_id = $managerId;
            $branchId = Branch::where('branch_name', $row[1])->value('id');
            $objSalary->branch_id = $branchId;
            $departmentID = Technology::where('technology_name', $row[2])->value('id');
            $objSalary->technology_id = $departmentID;
            $objSalary->date = $this->transformDate($row[3]);
            $objSalary->month_of = $row[4];
            $objSalary->remarks = $row[5];
            $objSalary->amount = $row[6];
            $objSalary->is_deleted = 'N';
            $objSalary->created_at = date('Y-m-d H:i:s');
            $objSalary->updated_at = date('Y-m-d H:i:s');
            $objSalary->save();
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

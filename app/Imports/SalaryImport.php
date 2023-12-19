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
        $managerId = Manager::where('manager_name', $row[0])->value('id');
        $branchId = Branch::where('branch_name', $row[1])->value('id');
        $departmentID = Technology::where('technology_name', $row[2])->value('id');

        if (Salary::where('manager_id', $managerId)->where('branch_id', $branchId)->where('technology_id', $departmentID)->where('month_of', $row[4])->where('is_deleted', 'N')->count() == 0) {
            $objSalary = new Salary();
            $objSalary->manager_id = $managerId;
            $objSalary->branch_id = $branchId;
            $objSalary->technology_id = $departmentID;
            $objSalary->date = $this->transformDate($row[3]);
            $objSalary->month_of = $row[4];
            $objSalary->year = $row[5];
            $objSalary->remarks = $row[6];
            $objSalary->amount = $row[7];
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

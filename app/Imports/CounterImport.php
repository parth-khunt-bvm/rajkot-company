<?php

namespace App\Imports;

use App\Models\Counter;
use App\Models\Employee;
use App\Models\Technology;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use DB;

class CounterImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public $month;
    public $year;

    public function __construct($month, $year)
        {
            $this->month = $month;
            $this->year = $year;
        }
    public function model(array $row)
    {
        if (Counter::where('month', $this->month)->where('year', $this->year)->where('technology_id', Technology::where('technology_name', $row[2])->value('id'))->where('employee_id', Employee::where(DB::raw('CONCAT(first_name, " ", last_name)'),$row[1] )->value('id'))->where('is_deleted', 'N')->count() == 0) {
        $objCounter = new Counter();
        $objCounter->month = $this->month;
        $objCounter->year = $this->year;
        $employeeId = Employee::where(DB::raw('CONCAT(first_name, " ", last_name)'),$row[1] )->value('id');
        $objCounter->employee_id = $employeeId;
        $departmentID = Technology::where('technology_name', $row[2])->value('id');
        $objCounter->technology_id = $departmentID;
        $objCounter->present_days = $row[3];
        $objCounter->half_leaves = $row[4];
        $objCounter->full_leaves = $row[5];
        $objCounter->paid_leaves_details = $row[6];
        $objCounter->total_days = $row[7] ?? 0;
        if ($row[8] == 'YES') {
            $modifiedValue = 'Y';
        } else {
            $modifiedValue = $row[8];
        }
        $objCounter->salary_counted = $modifiedValue ;
        $objCounter->paid_date = $this->transformDate(10-03-2023);
        $objCounter->salary_status = $row[10]?? '-';
        $objCounter->note = $row[11]?? '-';
        $objCounter->is_deleted = 'N';
        $objCounter->created_at = date('Y-m-d H:i:s');
        $objCounter->updated_at = date('Y-m-d H:i:s');
        $objCounter->save();
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
        return 4;
    }

}

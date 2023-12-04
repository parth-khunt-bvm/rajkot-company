<?php

namespace App\Imports;

use App\Models\Manager;
use App\Models\Revenue;
use App\Models\Technology;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class RevenueImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $managerId = Manager::where('manager_name', $row[0])->value('id');
        $departmentID = Technology::where('technology_name', $row[1])->value('id');
        if (Revenue::where('manager_id', $managerId)->where('technology_id', $departmentID)->where('received_month', $row[3])->where('month_of', $row[4])->where('is_deleted', 'N')->count() == 0) {
            $objRevenue = new Revenue();
            $objRevenue->manager_id = $managerId;
            $objRevenue->technology_id = $departmentID;
            $objRevenue->date = $this->transformDate($row[2]);
            $objRevenue->received_month = $row[3];
            $objRevenue->month_of = $row[4];
            $objRevenue->year = $row[5];
            $objRevenue->amount = $row[6];
            $objRevenue->bank_name = $row[7];
            $objRevenue->holder_name = $row[8];
            $objRevenue->remarks = $row[9] ?? '-';
            $objRevenue->is_deleted = 'N';
            $objRevenue->created_at = date('Y-m-d H:i:s');
            $objRevenue->updated_at = date('Y-m-d H:i:s');
            $objRevenue->save();
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

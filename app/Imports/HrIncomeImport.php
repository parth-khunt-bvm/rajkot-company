<?php

namespace App\Imports;

use App\Models\HrIncome;
use App\Models\Manager;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class HrIncomeImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
            $managerId = Manager::where('manager_name', $row[0])->value('id');

            if (HrIncome::where('manager_id', $managerId)->where('month_of', $row[2])->where('is_deleted', 'N')->count() == 0) {
            $objHrIncome = new HrIncome();
            $objHrIncome->manager_id = $managerId;
            $objHrIncome->date = $this->transformDate($row[1]);
            $objHrIncome->month_of = $row[2];
            $objHrIncome->year = $row[3];
            $objHrIncome->amount = $row[4];
            $objHrIncome->payment_mode = $row[5];
            $objHrIncome->remarks = $row[6];
            $objHrIncome->is_deleted = 'N';
            $objHrIncome->created_at = date('Y-m-d H:i:s');
            $objHrIncome->updated_at = date('Y-m-d H:i:s');
            $objHrIncome->save();
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

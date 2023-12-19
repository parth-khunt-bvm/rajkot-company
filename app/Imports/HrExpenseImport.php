<?php

namespace App\Imports;

use App\Models\HrExpense;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class HrExpenseImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (HrExpense::where('date', $this->transformDate($row[0]))->where('month', $row[1])->where('is_deleted', 'N')->count() == 0) {
        $objHrExpense = new HrExpense();
        $objHrExpense->date = $this->transformDate($row[0]);
        $objHrExpense->month = $row[1];
        $objHrExpense->amount = $row[2];
        $objHrExpense->remarks = $row[3];
        $objHrExpense->is_deleted = 'N';
        $objHrExpense->created_at = date('Y-m-d H:i:s');
        $objHrExpense->updated_at = date('Y-m-d H:i:s');
        $objHrExpense->save();
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

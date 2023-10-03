<?php

namespace App\Imports;

use App\Models\Revenue;
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
        if (Revenue::where('manager_id', $row[0])->where('technology_id', $row[1])->where('received_month', $row[3])->where('month_of', $row[4])->where('is_deleted', 'N')->count() == 0) {
            $objRevenue = new Revenue();
            $objRevenue->manager_id = $row[0];
            $objRevenue->technology_id = $row[1];
            $objRevenue->date = $this->transformDate($row[2]);
            $objRevenue->received_month = $row[3];
            $objRevenue->month_of = $row[4];
            $objRevenue->amount = $row[5];
            $objRevenue->bank_name = $row[6];
            $objRevenue->holder_name = $row[7];
            $objRevenue->remarks = $row[8] ?? '-';
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

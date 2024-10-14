<?php

namespace App\Imports;

use App\Models\PublicHoliday;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PublicHolidayImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (PublicHoliday::where('date', date('Y-m-d', strtotime($this->transformDate($row[0]))))->where('is_deleted', 'N')->count() == 0) {
            $objPublicHoliday = new PublicHoliday();
            $objPublicHoliday->date = $this->transformDate($row[0]);
            $objPublicHoliday->holiday_name = $row[1];
            $objPublicHoliday->note = $row[2];
            $objPublicHoliday->is_deleted = 'N';
            $objPublicHoliday->created_at = date('Y-m-d H:i:s');
            $objPublicHoliday->updated_at = date('Y-m-d H:i:s');
            $objPublicHoliday->save();
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
}

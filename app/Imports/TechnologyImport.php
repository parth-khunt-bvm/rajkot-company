<?php

namespace App\Imports;

use App\Models\Technology;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class TechnologyImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (Technology::where('technology_name', $row[0])->where('is_deleted', 'N')->count() == 0) {
            $objTechnology = new Technology();
            $objTechnology->technology_name = $row[0];
            $objTechnology->status = 'A';
            $objTechnology->is_deleted = 'N';
            $objTechnology->created_at = date('Y-m-d H:i:s');
            $objTechnology->updated_at = date('Y-m-d H:i:s');
            $objTechnology->save();
        }
    }
    public function startRow(): int
    {
        return 2;
    }
}

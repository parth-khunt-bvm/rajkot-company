<?php

namespace App\Imports;

use App\Models\Designation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DesignationImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (Designation::where('designation_name', $row[0])->where('is_deleted', 'N')->count() == 0) {
            $objDesignation = new Designation();
            $objDesignation->designation_name = $row[0];
            $objDesignation->status = 'A';
            $objDesignation->is_deleted = 'N';
            $objDesignation->created_at = date('Y-m-d H:i:s');
            $objDesignation->updated_at = date('Y-m-d H:i:s');
            $objDesignation->save();
        }
    }
    public function startRow(): int
    {
        return 2;
    }
}

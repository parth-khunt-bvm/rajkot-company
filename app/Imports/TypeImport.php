<?php

namespace App\Imports;

use App\Models\Type;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class TypeImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (Type::where('type_name', $row[0])->where('is_deleted', 'N')->count() == 0) {
            $objManager = new Type();
            $objManager->type_name = $row[0];
            $objManager->status = 'A';
            $objManager->is_deleted = 'N';
            $objManager->created_at = date('Y-m-d H:i:s');
            $objManager->updated_at = date('Y-m-d H:i:s');
            $objManager->save();
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}

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
            $objType = new Type();
            $objType->type_name = $row[0];
            $objType->status = 'A';
            $objType->is_deleted = 'N';
            $objType->created_at = date('Y-m-d H:i:s');
            $objType->updated_at = date('Y-m-d H:i:s');
            $objType->save();
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}

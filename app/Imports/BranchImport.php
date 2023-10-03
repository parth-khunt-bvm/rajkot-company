<?php

namespace App\Imports;
use App\Models\Branch;
use Illuminate\Validation\Rules\Exists;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class BranchImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (Branch::where('branch_name', $row[0])->where('is_deleted', 'N')->count() == 0) {
            $objBranch = new Branch();
            $objBranch->branch_name = $row[0];
            $objBranch->status = 'A';
            $objBranch->is_deleted = 'N';
            $objBranch->created_at = date('Y-m-d H:i:s');
            $objBranch->updated_at = date('Y-m-d H:i:s');
            $objBranch->save();
        }
    }

    public function startRow(): int
    {
        return 2;
    }


}

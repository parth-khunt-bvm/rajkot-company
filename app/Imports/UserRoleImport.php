<?php

namespace App\Imports;

use App\Models\User;
use App\Models\UserRole;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UserRoleImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (UserRole::where('user_role', $row[0])->where('is_deleted', 'N')->count() == 0) {
            $objUserRole = new UserRole();
            $objUserRole->user_role = $row[0];
            $objUserRole->status = 'A';
            $objUserRole->is_deleted = 'N';
            $objUserRole->created_at = date('Y-m-d H:i:s');
            $objUserRole->updated_at = date('Y-m-d H:i:s');
            $objUserRole->save();
        }
    }

        public function startRow(): int
    {
        return 2;
    }
}

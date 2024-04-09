<?php

namespace App\Imports;

use App\Models\Manager;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ManagerImport implements ToModel, WithStartRow, WithValidation
{

    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (Manager::where('manager_name', $row[0])->where('is_deleted', 'N')->count() == 0) {
            $objManager = new Manager();
            $objManager->manager_name = $row[0];
            $objManager->status = 'A';
            $objManager->is_deleted = 'N';
            $objManager->created_at = date('Y-m-d H:i:s');
            $objManager->updated_at = date('Y-m-d H:i:s');
            $objManager->save();
        }
    }

    public function rules(): array
    {
        return [
            '0' => 'required', // Assuming the manager's name is in the first column (index 0)
        ];
    }


    public function customValidationMessages()
    {
        return [
            '0.required' => 'Manager name is required',
        ];
    }


    public function startRow(): int
    {
        return 2;
    }
}

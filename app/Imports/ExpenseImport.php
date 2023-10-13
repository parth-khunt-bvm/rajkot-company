<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Expense;
use App\Models\Manager;
use App\Models\Type;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Carbon;


class ExpenseImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (Expense::where('manager_id', $row[0])->where('branch_id', $row[1])->where('type_id', $row[2])->where('month', $row[4])->where('is_deleted', 'N')->count() == 0) {
        $objExpence = new Expense();
        $managerId = Manager::where('manager_name', $row[0])->value('id');
        $objExpence->manager_id = $managerId;
        $branchId = Branch::where('branch_name', $row[1])->value('id');
        $objExpence->branch_id = $branchId;
        $typeId = Type::where('type_name', $row[2])->value('id');
        $objExpence->type_id = $typeId;
        $objExpence->date = $this->transformDate($row[3]);
        $objExpence->month = $row[4];
        $objExpence->remarks = $row[5];
        $objExpence->amount = $row[6];
        $objExpence->is_deleted = 'N';
        $objExpence->created_at = date('Y-m-d H:i:s');
        $objExpence->updated_at = date('Y-m-d H:i:s');
        $objExpence->save();
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

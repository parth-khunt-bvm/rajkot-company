<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Expense;
use App\Models\Manager;
use App\Models\Type;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon;


class ExpenseImport implements ToModel, WithStartRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $managerId = Manager::where('manager_name', $row[8])->value('id');

        if ($managerId == NULL) {
            $objManager = new Manager();
            $objManager->manager_name = $row[8];
            $objManager->status = "A";
            $objManager->is_deleted = 'N';
            $objManager->created_at = date('Y-m-d H:i:s');
            $objManager->updated_at = date('Y-m-d H:i:s');
            $objManager->save();
            $managerId = $objManager->id;
        }

        $branchId = Branch::where('branch_name', $row[7])->value('id');

        if ($branchId == NULL) {
            $objBranch = new Branch();
            $objBranch->branch_name = $row[7];
            $objBranch->status = "A";
            $objBranch->is_deleted = 'N';
            $objBranch->created_at = date('Y-m-d H:i:s');
            $objBranch->updated_at = date('Y-m-d H:i:s');
            $objBranch->save();
            $branchId = $objBranch->id;
        }

        $typeId = Type::where('type_name', $row[5])->value('id');

        if ($typeId == NULL) {
            $objtype = new Type();
            $objtype->type_name = $row[5];
            $objtype->status = "A";
            $objtype->is_deleted = 'N';
            $objtype->created_at = date('Y-m-d H:i:s');
            $objtype->updated_at = date('Y-m-d H:i:s');
            $objtype->save();
            $typeId = $objtype->id;
        }

        $amount = str_replace(',', '', $row[6]);

        if (Expense::where('date',  date('Y-m-d', strtotime($row['0'])))->where('manager_id', $managerId)->where('branch_id', $branchId)->where('type_id',  $typeId)->where('month', date("n", strtotime($row[1])))->where('amount', $amount)->where('is_deleted', 'N')->count() == 0) {
        $objExpence = new Expense();
        // $objExpence->date = $this->transformDate($row[0]);
        $objExpence->date = date('Y-m-d', strtotime($row['0']));
        $objExpence->month = date("n", strtotime($row[1])); //$row[1];
        $objExpence->year = $row[2];
        $objExpence->remarks = $row[4] ?? '-';
        $objExpence->type_id = $typeId;
        $objExpence->amount = (float) $amount;
        $objExpence->branch_id = $branchId;
        $objExpence->manager_id = $managerId;
        $objExpence->is_deleted = 'N';
        $objExpence->created_at = date('Y-m-d H:i:s');
        $objExpence->updated_at = date('Y-m-d H:i:s');
        $objExpence->save();
        }
    }

    public function rules(): array
    {
        return [
            '0' => 'required',
            '1' => 'required',
            '2' => 'required',
            // '4' => 'required',
            '5' => 'required',
            '6' => 'required',
            '7' => 'required',
            '8' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '0.required' => 'Date is required',
            '1.required' => 'Month is required',
            '2.required' => 'Year is required',
            // '4.required' => 'Remarks is required',
            '5.required' => 'Type is required',
            '6.required' => 'Amount is required',
            '7.required' => 'Branch is required',
            '8.required' => 'Manager is required',
        ];
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
        return 3;
    }
}

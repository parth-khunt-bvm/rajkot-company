<?php

namespace App\Imports;

use App\Models\Manager;
use App\Models\Revenue;
use App\Models\Technology;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

use Carbon;

class RevenueImport implements ToModel, WithStartRow, WithValidation
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)

    {
        if (empty($row[0])) {
            return null; // Skip the row
        }

        $managerId = Manager::where('manager_name', $row[6])->value('id');
        if ($managerId == NULL) {
            $objManager = new Manager();
            $objManager->manager_name = $row[6];
            $objManager->status = "A";
            $objManager->is_deleted = 'N';
            $objManager->created_at = date('Y-m-d H:i:s');
            $objManager->updated_at = date('Y-m-d H:i:s');
            $objManager->save();
            $managerId = $objManager->id;
        }

        $departmentID = Technology::where('technology_name', $row[8])->value('id');
        if ($departmentID == NULL) {
            $objTechnology = new Technology();
            $objTechnology->technology_name =  $row[8];
            $objTechnology->status = "A";
            $objTechnology->is_deleted = 'N';
            $objTechnology->created_at = date('Y-m-d H:i:s');
            $objTechnology->updated_at = date('Y-m-d H:i:s');
            $objTechnology->save();
            $departmentID = $objTechnology->id;
        }

        $amount = str_replace(',', '', $row[5]);

        if (Revenue::where('manager_id', $managerId)->where('technology_id', $departmentID)->where('date', date('Y-m-d', strtotime($row['0'])))->where('received_month', date("n", strtotime($row[1])))->where('month_of', date("n", strtotime($row[2])))->where('amount', $amount)->where('is_deleted', 'N')->count() == 0) {
            $objRevenue = new Revenue();
            // $objRevenue->date = $row[0] != null && $row[0] != '' ? $this->transformDate($row[0]) : NULL;
            // $objRevenue->date =  $this->transformDate($row[0]) ?? '-';
            $objRevenue->date = date('Y-m-d', strtotime($row['0']))  ?? '-';
            $objRevenue->received_month = date("n", strtotime($row[1]));
            $objRevenue->month_of = date("n", strtotime($row[2]));
            $objRevenue->year = $row[3];
            $objRevenue->remarks = $row[4] ?? '-';
            // $objRevenue->amount = $row[5];
            $objRevenue->amount = (float) $amount;
            $objRevenue->manager_id = $managerId;
            $objRevenue->bank_name = $row[7];
            $objRevenue->technology_id = $departmentID;
            $objRevenue->holder_name = $row[9];
            $objRevenue->is_deleted = 'N';
            $objRevenue->created_at = date('Y-m-d H:i:s');
            $objRevenue->updated_at = date('Y-m-d H:i:s');
            $objRevenue->save();
        }

    }

    public function rules(): array
    {
        return [
            '0' => 'required',
            '1' => 'required',
            '2' => 'required',
            '3' => 'required',
            // '4' => 'required',
            '5' => 'required',
            '6' => 'required',
            '7' => 'required',
            '8' => 'required',
            '9' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '0.required' => 'Date is required',
            '1.required' => 'Received month is required',
            '2.required' => 'Month of is required',
            '3.required' => 'Year is required',
            // '4.required' => 'Remark is required',
            '5.required' => 'Amount is required',
            '6.required' => 'Received by is required',
            '7.required' => 'Bank name is required',
            '8.required' => 'Technology is required',
            '9.required' => 'Holder Name is required',
        ];
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            if (is_numeric($value)) {
                return \Carbon\Carbon::createFromTimestamp(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($value));
            } else {
                return \Carbon\Carbon::createFromFormat('d/m/Y', $value);
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function startRow(): int
    {
        return 3;
    }

}

<?php

namespace App\Exports;

use App\Models\CounterSheet;
use Maatwebsite\Excel\Concerns\FromCollection;

class CounterSheetExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CounterSheet::all();
    }
}

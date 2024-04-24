<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Countersheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportAttendance implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $technology;
    protected $month;
    protected $year;

    function __construct($technology, $month, $year){
        $this->technology = $technology;
        $this->month = $month;
        $this->year = $year;
    }

    public function headings():array{
        $headingArray  = ['Employee', 'Department','Total Working Day', 'Present Day',  'Absent Day', 'Half Leave', 'Short Leave', 'Overtime(Hrs.)', 'Total Working Day'];
        return $headingArray;
    }

    public function collection()
    {
        $objCounter = new Countersheet();
        $aaa = $objCounter->counterSheetExcel($this->technology, $this->month, $this->year);
        return $aaa;
    }
}

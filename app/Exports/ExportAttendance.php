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
        $headingArray  = ['P', '','' ];

        ccd($this->month." - ".$this->year);
    }

    public function collection()
    {
        $objCounter = new Countersheet();
        return $objCounter->counterSheetPdf($this->technology, $this->month, $this->year);
    }
}

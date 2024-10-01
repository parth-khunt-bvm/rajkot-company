<?php

namespace App\Exports;

use App\Models\AssetMaster;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AssetAllocationExport implements FromCollection, WithHeadings, WithEvents
{

    public function headings():array{
        $headingArray  = ['Employee Name', 'Supplier Name', 'Brand', 'Asset', 'Asset Code', 'Status', 'Description'];
        return $headingArray;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AssetMaster::from('asset_master')
                ->join("employee", "employee.id", "=", "asset_master.allocated_user_id")
                ->join("supplier", "supplier.id", "=", "asset_master.supplier_id")
                ->join("branch", "branch.id", "=", "asset_master.branch_id")
                ->join("asset", "asset.id", "=", "asset_master.asset_id")
                ->join("brand", "brand.id", "=", "asset_master.brand_id")
                ->where("asset_master.is_deleted", "=", "N")
                ->select(
                    DB::raw('CONCAT(first_name, " ", last_name) as fullName'), 
                    DB::raw('CONCAT(suppiler_name, " - ", supplier_shop_name) as supplierName'), 
                    'brand.brand_name' ,'asset.asset_type', 
                    'asset_master.asset_code',
                    DB::raw("CASE 
                        WHEN asset_master.status = '1' THEN 'Working' 
                        WHEN asset_master.status = '2' THEN 'Need To Service' 
                        WHEN asset_master.status = '3' THEN 'Not Working' 
                        ELSE 'Unknown'
                    END"),
                    'asset_master.description'
                )
                ->orderBy('fullName')
                ->get();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->getStyle('A1:G1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $sheet->getStyle('A2:A' . ($this->collection()->count() + 1))->applyFromArray([
                    'alignment' => [
                        'vertical' => 'middle',
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                foreach (range('A', 'G') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
                
                $rows = $this->collection()->count() + 1;
                $previousFullName = null;
                $startRow = 2;

                for ($row = 2; $row <= $rows; $row++) {
                    $currentFullName = $sheet->getCell("A{$row}")->getValue();

                    if ($currentFullName === $previousFullName) {
                        continue;
                    } elseif ($previousFullName !== null && $previousFullName !== $currentFullName) {
                        if ($row - 1 > $startRow) {
                            $sheet->mergeCells("A{$startRow}:A" . ($row - 1));
                        }
                        $startRow = $row;
                    }
                    $previousFullName = $currentFullName;
                }

                if ($rows > $startRow) {
                    $sheet->mergeCells("A{$startRow}:A{$rows}");
                }
            },
        ];
    }

}

<?php

namespace App\Exports;

use App\Models\AssetMaster;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class AssetMasterExport implements FromCollection, WithHeadings, WithEvents
{

    public function headings():array{
        $headingArray  = ['Employee Name', 'Asset Code', 'Supplier Name', 'Asset Name', 'Branch Name', 'Brand Name', 'Price', 'Status', 'Purchase Date', 'Warranty/Guarantee term (in years)', 'Warranty/Guarantee agreement', 'Expiration Date', 'Description'];
        return $headingArray;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AssetMaster::from('asset_master')
                    ->leftJoin("employee", "employee.id", "=", "asset_master.allocated_user_id")
                    ->join("supplier", "supplier.id", "=", "asset_master.supplier_id")
                    ->join("branch", "branch.id", "=", "asset_master.branch_id")
                    ->join("asset", "asset.id", "=", "asset_master.asset_id")
                    ->join("brand", "brand.id", "=", "asset_master.brand_id")
                    ->whereIn('asset_master.branch_id', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']] )
                    ->where("asset_master.is_deleted", "=", "N")
                    ->select(
                        DB::raw('COALESCE(CONCAT(employee.first_name, " ", employee.last_name), "-")'),
                        'asset_master.asset_code', 
                        'supplier.suppiler_name', 
                        'asset.asset_type', 
                        'branch.branch_name', 
                        'brand.brand_name', 
                        'asset_master.price',
                        DB::raw("CASE 
                                    WHEN asset_master.status = '1' THEN 'Working' 
                                    WHEN asset_master.status = '2' THEN 'Need To Service' 
                                    WHEN asset_master.status = '3' THEN 'Not Working' 
                                    ELSE 'Unknown'
                                 END"),
                        DB::raw('COALESCE(asset_master.purchase_date, "-")'),
                        DB::raw('COALESCE(asset_master.warranty_guarantee, "0")'),
                        DB::raw("CASE 
                                    WHEN asset_master.agreement = 'W' THEN 'Warranty' 
                                    WHEN asset_master.agreement = 'G' THEN 'Guarantee' 
                                    WHEN asset_master.agreement = 'N' THEN 'None' 
                                    ELSE 'Unknown'
                                 END"),
                        DB::raw("CASE 
                                    WHEN asset_master.warranty_guarantee > 0 THEN 
                                        DATE_ADD(asset_master.purchase_date, INTERVAL (asset_master.warranty_guarantee * 12) MONTH)
                                    ELSE '-'
                                END as expiration_date"),
                        'asset_master.description'
                    )
                    ->orderBy('asset_master.asset_code')
                    ->get();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->getStyle('A1:M1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                foreach (range('A', 'M') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class EmployeeAssetAllocation extends Model
{
    use HasFactory;

    protected $table = 'asset_master';

    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'asset_master.id',
            1 => 'asset.asset_type',
            2 => 'brand.brand_name',
            3 => DB::raw('CONCAT(suppiler_name, " - ", supplier_shop_name)'),
            4 => 'asset_master.asset_code',
        );
            $query = EmployeeAssetAllocation::from('asset_master')
            ->join("supplier", "supplier.id", "=", "asset_master.supplier_id")
            ->join("branch", "branch.id", "=", "asset_master.branch_id")
            ->join("asset", "asset.id", "=", "asset_master.asset_id")
            ->join("brand", "brand.id", "=", "asset_master.brand_id")
            ->where("asset_master.allocated_user_id", $fillterdata['userId']);

        if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchVal = $requestData['search']['value'];
            $query->where(function ($query) use ($columns, $searchVal, $requestData) {
                $flag = 0;
                foreach ($columns as $key => $value) {
                    $searchVal = $requestData['search']['value'];
                    if ($requestData['columns'][$key]['searchable'] == 'true') {
                        if ($flag == 0) {
                            $query->where($value, 'like', '%' . $searchVal . '%');
                            $flag = $flag + 1;
                        } else {
                            $query->orWhere($value, 'like', '%' . $searchVal . '%');
                        }
                    }
                }
            });
        }

        $temp = $query->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $totalData = count($temp->get());
        $totalFiltered = count($temp->get());

        $resultArr = $query->skip($requestData['start'])
            ->take($requestData['length'])
            ->select('asset_master.id','asset_master.description', 'asset_master.status', 'asset_master.price', 'asset_master.asset_id', 'asset_master.brand_id','asset_master.branch_id', 'asset_master.supplier_id' ,'asset_master.asset_code','asset_master.allocated_user_id', 'brand.brand_name', 'asset.asset_type',DB::raw('CONCAT(suppiler_name, " - ", supplier_shop_name) as supplierName'))
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['asset_type'];
            $nestedData[] = $row['brand_name'];
            $nestedData[] = $row['supplierName'];
            $nestedData[] = $row['asset_code'];
            $data[] = $nestedData;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
        );
        return $json_data;
    }
}

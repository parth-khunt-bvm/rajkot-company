<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AssetMaster extends Model
{
    use HasFactory;
    protected $table = "asset_master";
    protected $fillable = [
        'supplier_id',
        'asset_id',
        'brand_id',
        'branch_id',
        'description',
        'status',
        'price',
    ];

    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'asset_master.id',
            1 => 'supplier.suppiler_name',
            2 => 'asset.asset_type',
            3 => 'branch.branch_name',
            4 => 'brand.brand_name',
            5 => 'asset_master.description',
            6 => 'asset_master.status',
            7 => 'asset_master.price',
        );

        $query = AssetMaster::from('asset_master')
            ->join("supplier", "supplier.id", "=", "asset_master.supplier_id")
            ->join("branch", "branch.id", "=", "asset_master.branch_id")
            ->join("asset", "asset.id", "=", "asset_master.asset_id")
            ->join("brand", "brand.id", "=", "asset_master.branch_id")
            ->where("asset_master.is_deleted", "=", "N");

        if($fillterdata['supplier'] != null && $fillterdata['supplier'] != ''){
            $query->where("supplier.id", $fillterdata['supplier']);
        }

        if($fillterdata['branch'] != null && $fillterdata['branch'] != ''){
            $query->where("branch.id", $fillterdata['branch']);
        }

        if($fillterdata['asset'] != null && $fillterdata['asset'] != ''){
            $query->where("asset.id", $fillterdata['asset']);
        }
        if($fillterdata['brand'] != null && $fillterdata['brand'] != ''){
            $query->where("brand.id", $fillterdata['brand']);
        }



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
            ->select('asset_master.id', 'supplier.suppiler_name', 'branch.branch_name', 'asset.asset_type','brand.brand_name','asset_master.description', 'asset_master.status', 'asset_master.price')
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {

            $target = [];
            $target = [111, 112,113,114,115,116];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['suppiler_name'];
            $nestedData[] = $row['branch_name'];
            $nestedData[] = $row['asset_type'];
            $nestedData[] = $row['brand_name'];
            $nestedData[] = $row['status'];
            $nestedData[] = numberformat($row['price']);
            if (strlen($row['description']) > $max_length) {
                $nestedData[] = substr($row['description'], 0, $max_length) . '...';
            }else {
                $nestedData[] = $row['description']; // If it's not longer than max_length, keep it as is
            }
            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $nestedData[] = $actionhtml;
            }
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

    public function saveAdd($requestData)
    {

        $countAssetMaster = AssetMaster::from('asset_master')
        ->where('asset_master.supplier_id', $requestData['supplier_id'])
        ->where('asset_master.branch_id', $requestData['branch_id'])
        ->where('asset_master.asset_id', $requestData['asset_id'])
        ->where('asset_master.branch_id', $requestData['brand_id'])
        ->where("asset_master.is_deleted", "=", "N")
        ->count();

        if ($countAssetMaster == 0) {
            $objAssetMaster = new AssetMaster();
            $objAssetMaster->supplier_id = $requestData['supplier_id'];
            $objAssetMaster->asset_id = $requestData['asset_id'];
            $objAssetMaster->brand_id = $requestData['brand_id'];
            $objAssetMaster->branch_id = $requestData['branch_id'];
            $objAssetMaster->description = $requestData['description'];
            $objAssetMaster->status = $requestData['status'] ?? '-';
            $objAssetMaster->price = $requestData['price'];
            $objAssetMaster->is_deleted = 'N';
            $objAssetMaster->created_at = date('Y-m-d H:i:s');
            $objAssetMaster->updated_at = date('Y-m-d H:i:s');
            if ($objAssetMaster->save()) {
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit('I', $requestData, 'Asset Master');
                return 'added';
            }

            return 'wrong';
        }
        return 'assets_name_exists';
    }

}

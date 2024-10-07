<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AssetAllocation extends Model
{
    use HasFactory;

    protected $table = "asset_master";

    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'asset_master.id',
            1 => DB::raw('CONCAT(first_name, " ", last_name)'),
            2 => DB::raw('CONCAT(suppiler_name, " - ", supplier_shop_name)'),
            3 => 'brand.brand_name',
            4 => 'asset.asset_type',
            5 => 'asset_master.asset_code',
        );

        $query = AssetMaster::from('asset_master')
        ->join("employee", "employee.id", "=", "asset_master.allocated_user_id")
        ->join("supplier", "supplier.id", "=", "asset_master.supplier_id")
        ->join("branch", "branch.id", "=", "asset_master.branch_id")
        ->join("asset", "asset.id", "=", "asset_master.asset_id")
        ->join("brand", "brand.id", "=", "asset_master.brand_id")
        ->where("asset_master.is_deleted", "=", "N");

        if($fillterdata['employee'] != null && $fillterdata['employee'] != ''){
            $query->where("asset_master.allocated_user_id", $fillterdata['employee']);
        }
        if($fillterdata['supplier'] != null && $fillterdata['supplier'] != ''){
            $query->where("asset_master.supplier_id", $fillterdata['supplier']);
        }
        if($fillterdata['brand'] != null && $fillterdata['brand'] != ''){
            $query->where("asset_master.brand_id", $fillterdata['brand']);
        }
        if($fillterdata['asset'] != null && $fillterdata['asset'] != ''){
            $query->where("asset_master.asset_id", $fillterdata['asset']);
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
            ->select( 'asset_master.id', DB::raw('CONCAT(first_name, " ", last_name) as fullName'),DB::raw('CONCAT(suppiler_name, " - ", supplier_shop_name) as supplierName') ,'asset.asset_type', 'asset_master.asset_code','brand.brand_name',)
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {

            $target = [];
            $target = [118,119];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(118, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.asset-allocation.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

          if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(119, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['fullName'];
            $nestedData[] = $row['supplierName'];
            $nestedData[] = $row['brand_name'];
            $nestedData[] = $row['asset_type'];
            $nestedData[] = $row['asset_code'];
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
        foreach ($requestData['asset_master_id'] as $assetkey => $value) {
            $assetAllocationId = AssetAllocation::find($value);

            if ($assetAllocationId) {
                $assetAllocationId->allocated_user_id = $requestData['employee_id'];
                $assetAllocationId->updated_at = date('Y-m-d H:i:s');

                $objAssetAllocationHistory = new AssetAllocationHistory();
                $objAssetAllocationHistory->asset_id = $assetAllocationId->id;
                $objAssetAllocationHistory->employee_id = $requestData['employee_id'];

                if ($assetAllocationId->save() && $objAssetAllocationHistory->save()) {
                    $objAudittrails = new Audittrails();
                    $objAudittrails->add_audit("U", $requestData, 'AssetAllocation');
                }
            }
        }
        return 'updated';
    }

    public function saveEdit($requestData)
    {
            $objAssetAllocation = AssetAllocation::find($requestData['edit_id']);
            
            $objAssetAllocation->allocated_user_id = $requestData['employee_id'];
            $objAssetAllocation->updated_at = date('Y-m-d H:i:s');

            $newAssetAllocationHistory = new AssetAllocationHistory();
            $newAssetAllocationHistory->asset_id = $objAssetAllocation->id;
            $newAssetAllocationHistory->employee_id = $requestData['employee_id'];

            if ($objAssetAllocation->save() && $newAssetAllocationHistory->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit('U', $inputData, 'AssetAllocation');
                return 'added';
            }
            return 'wrong';
    }


    public function common_activity($requestData){

        $objAssetAllocation = AssetAllocation::find($requestData['id']);
        if($requestData['activity'] == 'delete-records'){
            // $objAssetAllocation->is_deleted = "Y";
            $objAssetAllocation->allocated_user_id = null;
            $event = 'D';
        }

        $objAssetAllocation->updated_at = date("Y-m-d H:i:s");

        $objAssetAllocationHistory = new AssetAllocationHistory();
        $objAssetAllocationHistory->asset_id = $objAssetAllocation->id;
        $objAssetAllocationHistory->employee_id = null;

        if($objAssetAllocation->save() && $objAssetAllocationHistory->save()){
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'AssetAllocation');
            return true;
        }else{
            return false ;
        }
    }

    public function get_asset_master_details($userId){

        return AssetMaster::from('asset_master')
        ->join("supplier", "supplier.id", "=", "asset_master.supplier_id")
        ->join("branch", "branch.id", "=", "asset_master.branch_id")
        ->join("asset", "asset.id", "=", "asset_master.asset_id")
        ->join("brand", "brand.id", "=", "asset_master.brand_id")
        ->where("asset_master.allocated_user_id",$userId)
        ->select('asset_master.id','asset_master.description', 'asset_master.status', 'asset_master.price', 'asset_master.asset_id', 'asset_master.brand_id','asset_master.branch_id', 'asset_master.supplier_id' ,'asset_master.asset_code','asset_master.allocated_user_id', 'brand.brand_name', 'asset.asset_type','supplier.suppiler_name','supplier.supplier_shop_name')
        ->get();
    }

    // public function getassetallocationdatatable($userId)
    // {
    //     $requestData = $_REQUEST;
    //     $columns = array(
    //         0 => 'asset_master.id',
    //         1 => 'asset.asset_type',
    //         3 => 'brand.brand_name',
    //         4 => 'supplier.suppiler_name',
    //         5 => 'asset_master.asset_code',
    //     );
    //     $query = AssetMaster::from('asset_master')
    //     ->join("supplier", "supplier.id", "=", "asset_master.supplier_id")
    //     ->join("branch", "branch.id", "=", "asset_master.branch_id")
    //     ->join("asset", "asset.id", "=", "asset_master.asset_id")
    //     ->join("brand", "brand.id", "=", "asset_master.brand_id")
    //     ->where("asset_master.allocated_user_id",$userId);

    //     if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    //         $searchVal = $requestData['search']['value'];
    //         $query->where(function ($query) use ($columns, $searchVal, $requestData) {
    //             $flag = 0;
    //             foreach ($columns as $key => $value) {
    //                 $searchVal = $requestData['search']['value'];
    //                 if ($requestData['columns'][$key]['searchable'] == 'true') {
    //                     if ($flag == 0) {
    //                         $query->where($value, 'like', '%' . $searchVal . '%');
    //                         $flag = $flag + 1;
    //                     } else {
    //                         $query->orWhere($value, 'like', '%' . $searchVal . '%');
    //                     }
    //                 }
    //             }
    //         });
    //     }

    //     $temp = $query->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

    //     $totalData = count($temp->get());
    //     $totalFiltered = count($temp->get());

    //     $resultArr = $query->skip($requestData['start'])
    //         ->take($requestData['length'])
    //         ->select('asset_master.id','asset_master.description', 'asset_master.status', 'asset_master.price', 'asset_master.asset_id', 'asset_master.brand_id','asset_master.branch_id', 'asset_master.supplier_id' ,'asset_master.asset_code','asset_master.allocated_user_id', 'brand.brand_name', 'asset.asset_type','supplier.suppiler_name','supplier.supplier_shop_name')
    //         ->get();

    //     $data = array();
    //     $i = 0;

    //     foreach ($resultArr as $row) {

    //         $target = [];
    //         $target = [15, 16, 17];
    //         $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

    //         // if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
    //             $actionhtml = '';
    //         // }
    //         // if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(15, explode(',', $permission_array[0]['permission'])) )
    //         $actionhtml .= '<a href="' . route('admin.type.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

    //         if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(16, explode(',', $permission_array[0]['permission'])) ){
    //             if ($row['status'] == 'A') {
    //                 $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deactiveModel" class="btn btn-icon  deactive-records" data-id="' . $row["id"] . '" ><i class="fa fa-times text-primary" ></i></a>';
    //             } else {
    //                 $actionhtml .= '<a href="#" data-toggle="modal" data-target="#activeModel" class="btn btn-icon  active-records" data-id="' . $row["id"] . '" ><i class="fa fa-check text-primary" ></i></a>';
    //             }
    //         }

    //         if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(17, explode(',', $permission_array[0]['permission'])) )
    //         $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

    //         $i++;
    //         $nestedData = array();
    //         $nestedData[] = $i;
    //         $nestedData[] = $row['asset_type'];
    //         $nestedData[] = $row['brand_name'];
    //         $nestedData[] = $row['suppiler_name'];
    //         $nestedData[] = $row['asset_type'];
    //         $nestedData[] = $row['asset_code'];
    //         // if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
    //             $nestedData[] = $actionhtml;
    //         // }
    //         $data[] = $nestedData;
    //     }
    //     $json_data = array(
    //         "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
    //         "recordsTotal" => intval($totalData), // total number of records
    //         "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
    //         "data" => $data   // total data array
    //     );
    //     return $json_data;
    // }


}

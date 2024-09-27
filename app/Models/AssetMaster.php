<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Route;

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
            1 => DB::raw('CONCAT(first_name, " ", last_name)'),
            2 => 'asset_master.asset_code',
            3 => 'supplier.suppiler_name',
            4 => 'asset.asset_type',
            5 => 'branch.branch_name',
            6 => 'brand.brand_name',
            7 => 'asset_master.description',
            8 => DB::raw('(CASE WHEN asset_master.status = 1 THEN "Working" WHEN asset_master.status = 2 THEN "NeedToService" ELSE "Not Working" END)'),
            9 => 'asset_master.price',
        );

        $query = AssetMaster::from('asset_master')
            ->leftJoin("employee", "employee.id", "=", "asset_master.allocated_user_id")
            ->join("supplier", "supplier.id", "=", "asset_master.supplier_id")
            ->join("branch", "branch.id", "=", "asset_master.branch_id")
            ->join("asset", "asset.id", "=", "asset_master.asset_id")
            ->join("brand", "brand.id", "=", "asset_master.brand_id")
            ->whereIn('asset_master.branch_id', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']] )
            ->where("asset_master.is_deleted", "=", "N");

        if($fillterdata['supplier'] != null && $fillterdata['supplier'] != ''){
            $query->where("supplier.id", $fillterdata['supplier']);
        }
        if($fillterdata['asset'] != null && $fillterdata['asset'] != ''){
            $query->where("asset.id", $fillterdata['asset']);
        }
        if($fillterdata['brand'] != null && $fillterdata['brand'] != ''){
            $query->where("brand.id", $fillterdata['brand']);
        }
        if($fillterdata['branch'] != null && $fillterdata['branch'] != ''){
            $query->where("branch.id", $fillterdata['branch']);
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
            ->select('asset_master.id', DB::raw('CONCAT(first_name, " ", last_name) as fullName'),'asset_master.asset_code', 'supplier.suppiler_name', 'branch.branch_name', 'asset.asset_type','brand.brand_name','asset_master.description', 'asset_master.status', 'asset_master.price')
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {
            $target = [];
            $target = [111, 112,113,114,115];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(113, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href=""data-toggle="modal" data-target="#asset-master-view" data-id="'.$row['id'].'" class="btn btn-icon asset-master-view"><i class="fa fa-eye text-primary"> </i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(114, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.asset-master.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

            if ($row['status'] == '1') {
                $status = '<span class="label label-lg label-light-success label-inline">Working</span>';
            } elseif($row['status'] == '2') {
                $status = '<span class="label label-lg label-light-warning label-inline">Need To Service</span>';
            } else {
                $status = '<span class="label label-lg label-light-danger label-inline">Not Working</span>';
            }

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(115, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['fullName'] ?? '-';
            $nestedData[] = $row['asset_code'];
            $nestedData[] = $row['suppiler_name'];
            $nestedData[] = $row['asset_type'];
            $nestedData[] = $row['branch_name'];
            $nestedData[] = $row['brand_name'];
            $nestedData[] = numberformat($row['price']);
            $nestedData[] = $status;

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

    public function getAssetMasterDatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'asset_master.id',
            1 => DB::raw('CONCAT(first_name, " ", last_name)'),
            2 => 'asset_master.asset_code',
            3 => 'supplier.suppiler_name',
            4 => 'asset.asset_type',
            5 => 'branch.branch_name',
            6 => 'brand.brand_name',
            7 => 'asset_master.description',
            8 => DB::raw('(CASE WHEN asset_master.status = 1 THEN "Working" WHEN asset_master.status = 2 THEN "NeedToService" ELSE "Not Working" END)'),
            9 => 'asset_master.price',
        );

        $query = AssetMaster::from('asset_master')
            ->leftJoin("employee", "employee.id", "=", "asset_master.allocated_user_id")
            ->join("supplier", "supplier.id", "=", "asset_master.supplier_id")
            ->join("branch", "branch.id", "=", "asset_master.branch_id")
            ->join("asset", "asset.id", "=", "asset_master.asset_id")
            ->join("brand", "brand.id", "=", "asset_master.brand_id")
            ->whereIn('asset_master.branch_id', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']] )
            ->where("asset_master.is_deleted", "=", "Y");

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
            ->select('asset_master.id', DB::raw('CONCAT(first_name, " ", last_name) as fullName'),'asset_master.asset_code', 'supplier.suppiler_name', 'branch.branch_name', 'asset.asset_type','brand.brand_name','asset_master.description', 'asset_master.status', 'asset_master.price')
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {
            $target = [];
            $target = [111, 112,113,114,115];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }

            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#restoreDataModel" class="btn btn-icon restore-records" data-id="' . $row["id"] . '" ><i class="fa fa-undo text-danger" ></i></a>';

            if ($row['status'] == '1') {
                $status = '<span class="label label-lg label-light-success label-inline">Working</span>';
            } elseif($row['status'] == '2') {
                $status = '<span class="label label-lg label-light-warning label-inline">Need To Service</span>';
            } else {
                $status = '<span class="label label-lg label-light-danger label-inline">Not Working</span>';
            }

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['fullName'] ?? '-';
            $nestedData[] = $row['asset_code'];
            $nestedData[] = $row['suppiler_name'];
            $nestedData[] = $row['asset_type'];
            $nestedData[] = $row['branch_name'];
            $nestedData[] = $row['brand_name'];
            $nestedData[] = numberformat($row['price']);
            $nestedData[] = $status;

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
            $supplierCode = Supplier::from('supplier')->select('supplier.sort_name')->where('supplier.id', $requestData['supplier_id'])->first();
            $assetCode = Asset::from('asset')->select('asset.asset_code', 'asset.asset_type')->where('asset.id', $requestData['asset_id'])->first();

            for ($i = 1; $i <= $requestData['quantity']; $i++){
                generateCode:
                $codeNumber = get_no_by_name($assetCode->asset_type);
                $code = $codeNumber->number > 0 && $codeNumber->number < 10 ? "0".$codeNumber->number : $codeNumber->number;
                $asset_code = $assetCode->asset_code.'00000000'.$code.$supplierCode->sort_name;

                $count_code = AssetMaster::from('asset_master')
                ->where("asset_master.asset_code", "=", $asset_code)
                ->count();

                if($count_code == 0){
                    $objAssetMaster = new AssetMaster();
                    $objAssetMaster->supplier_id = $requestData['supplier_id'];
                    $objAssetMaster->asset_id = $requestData['asset_id'];
                    $objAssetMaster->brand_id = $requestData['brand_id'];
                    $objAssetMaster->branch_id = $requestData['branch_id'];
                    $objAssetMaster->description = $requestData['description'] ?? '-';
                    $objAssetMaster->status = $requestData['status'];
                    $objAssetMaster->price = $requestData['price'] ?? '-';
                    $objAssetMaster->asset_code = $asset_code;
                    $objAssetMaster->is_deleted = 'N';
                    $objAssetMaster->created_at = date('Y-m-d H:i:s');
                    $objAssetMaster->updated_at = date('Y-m-d H:i:s');
                    if ($objAssetMaster->save()) {
                        auto_increment_no($assetCode->asset_type);
                        $objAudittrails = new Audittrails();
                        $objAudittrails->add_audit('I', $requestData, 'Asset Master');
                    }
                } else {
                    auto_increment_no($assetCode->asset_type);
                    goto generateCode;
                }
            }
            return 'added';

    }

    public function saveEdit($requestData)
    {
        $supplierCode = Supplier::from('supplier')->select('supplier.sort_name')->where('supplier.id', $requestData['supplier_id'])->first();
            $objAssetMaster = AssetMaster::find($requestData['edit_id']);
            $sortNameLength = Supplier::from('supplier')
                ->selectRaw('LENGTH(supplier.sort_name) AS sort_name_length')
                ->where('supplier.id', $objAssetMaster->supplier_id)
                ->value('sort_name_length');
            $objAssetMaster->supplier_id = $requestData['supplier_id'];
            $objAssetMaster->brand_id = $requestData['brand_id'];
            $objAssetMaster->branch_id = $requestData['branch_id'];
            $objAssetMaster->description = $requestData['description']?? '-';
            $objAssetMaster->status = $requestData['status'];
            $objAssetMaster->price = $requestData['price'] ?? '-';
            $assetCode = substr_replace($objAssetMaster->asset_code, $supplierCode->sort_name, -$sortNameLength);
            $objAssetMaster->asset_code = $assetCode;
            $objAssetMaster->updated_at = date('Y-m-d H:i:s');
            if ($objAssetMaster->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit('U', $inputData, 'AssetMaster');
                return 'added';
            }
            return 'wrong';
    }

    public function get_asset_master_details($assetMasterId){
        return AssetMaster::from('asset_master')
        ->where("asset_master.id", $assetMasterId)
        ->select('asset_master.id','asset_master.description', 'asset_master.status', 'asset_master.price', 'asset_master.asset_id', 'asset_master.brand_id', 'asset_master.branch_id', 'asset_master.supplier_id' ,'asset_master.asset_code','asset_master.allocated_user_id' )
        ->first();
    }

    public function common_activity($requestData)
    {
        $objAssetMaster = AssetMaster::find($requestData['id']);
        if ($requestData['activity'] == 'delete-records') {
            $objAssetMaster->is_deleted = "Y";
            $event = 'D';
        }

        if ($requestData['activity'] == 'restore-records') {
            $objAssetMaster->is_deleted = "N";
            $event = 'R';
        }

        if ($objAssetMaster->save()) {
            $currentRoute = Route::current()->getName();
            unset($requestData['_token']);
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'Counter');

            return true;
        } else {
            return false;
        }
    }

    public function get_asset_master_details_view($assetMasterId){
        return AssetMaster::from('asset_master')
        ->join("supplier", "supplier.id", "=", "asset_master.supplier_id")
        ->join("branch", "branch.id", "=", "asset_master.branch_id")
        ->join("asset", "asset.id", "=", "asset_master.asset_id")
        ->join("brand", "brand.id", "=", "asset_master.brand_id")
        ->where("asset_master.id", $assetMasterId)
        ->select('asset_master.id','asset_master.description', 'asset_master.status', 'asset_master.price', 'asset_master.asset_id', 'asset_master.brand_id', 'asset_master.branch_id', 'asset_master.supplier_id', 'supplier.suppiler_name','supplier.supplier_shop_name', 'branch.branch_name', 'asset.asset_type', 'brand.brand_name')
        ->first();
    }

    public function get_admin_asset_master_details(){
        return AssetMaster::from('asset_master')
            ->join("asset", "asset.id", "=", "asset_master.asset_id")
            ->select('asset.asset_type','asset_master.id','asset_master.description', 'asset_master.status', 'asset_master.price', 'asset_master.asset_id', 'asset_master.brand_id', 'asset_master.branch_id', 'asset_master.supplier_id' ,'asset_master.asset_code')
            ->get();
    }



}

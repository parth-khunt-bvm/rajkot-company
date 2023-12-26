<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\CodeGenerator;
class Asset extends Model
{
    use HasFactory;
    protected $table = "asset";
    protected $fillable = [
        'asset_type',
        'asset_code',
    ];

    public function getdatatable()
    {
        $requestData = $_REQUEST;

        $columns = array(
            0 => 'asset.id',
            1 => 'asset.asset_type',
            2 => 'asset.asset_code',
        );

        $query = Asset::from('asset')
            ->where("asset.is_deleted", "=", "N");

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
            ->select('asset.id', 'asset.asset_type', 'asset.asset_code')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $target = [];
            $target = [97, 98];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(35, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['asset_type'];
            $nestedData[] =$row['asset_code'];
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
        $checkAssetName = Asset::from('asset')
            ->where('asset.asset_type', $requestData['asset_type'])
            ->where('asset.asset_code', $requestData['asset_code'])
            ->where('asset.is_deleted', 'N')
            ->count();

        if ($checkAssetName == 0) {
            $i = 1;
            $objAsset = new Asset();
            $objAsset->asset_type = $requestData['asset_type'];
             $objAsset->asset_code = $requestData['asset_code'];
            $objAsset->is_deleted = 'N';
            $objAsset->created_at = date('Y-m-d H:i:s');
            $objAsset->updated_at = date('Y-m-d H:i:s');
            if ($objAsset->save()) {
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $requestData, 'Assets');
                return 'added';
            } else {
                return 'wrong';
            }
        }
        return 'asset_type_exists,asset_code_exists';
    }

    public function get_admin_asset_details(){
        return Asset::from('asset')
            ->select('asset.id','asset.asset_type','asset.asset_code')
            ->get();
    }

    public function get_admin_employee_details($employeIdArray = null){
        $qurey = Employee::from('employee')->select('employee.id','employee.first_name','employee.last_name');
        if($employeIdArray != null){
           $qurey->whereNotIn('employee.id', $employeIdArray);
        }
        return $qurey->get();
    }

    public function get_asset_list($id, $assetMasterIdArray = []){

        $qurey = AssetMaster::from('asset_master')
                    ->where('asset_master.asset_id',$id)
                    ->select('asset_master.asset_code', 'asset_master.id');

        if(!empty($assetMasterIdArray)){
            $qurey->whereNotIn('asset_master.id' ,$assetMasterIdArray);
        }
        return $qurey->get()->toArray();
    }
}

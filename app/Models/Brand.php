<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Brand extends Model
{
    use HasFactory;
    protected $table = "brand";
    protected $fillable = [
        'brand_name',
        'status',
    ];

    public function getdatatable()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'brand.id',
            1 => 'brand.brand_name',
            2 => DB::raw('(CASE WHEN brand.status = "A" THEN "Actived" ELSE "Deactived" END)'),
        );
        $query = Brand::from('brand')
            ->where("brand.is_deleted", "=", "N");

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
            ->select('brand.id', 'brand.brand_name','brand.status')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $target = [];
            $target = [27, 28, 29];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);
            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }
            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(27, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.brand.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';
            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(28, explode(',', $permission_array[0]['permission'])) ){
                if ($row['status'] == 'A') {
                    $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deactiveModel" class="btn btn-icon  deactive-records" data-id="' . $row["id"] . '" ><i class="fa fa-times text-primary" ></i></a>';
                } else {
                    $actionhtml .= '<a href="#" data-toggle="modal" data-target="#activeModel" class="btn btn-icon  active-records" data-id="' . $row["id"] . '" ><i class="fa fa-check text-primary" ></i></a>';
                }
             }
            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(29, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['brand_name'];
            $nestedData[] = $row['status'] == 'A' ? '<span class="label label-lg label-light-success label-inline">Active</span>' : '<span class="label label-lg label-light-danger  label-inline">Deactive</span>';
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

    public function getBrandDatatable()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'brand.id',
            1 => 'brand.brand_name',
            2 => DB::raw('(CASE WHEN brand.status = "A" THEN "Actived" ELSE "Deactived" END)'),
        );
        $query = Brand::from('brand')
            ->where("brand.is_deleted", "=", "Y");

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
            ->select('brand.id', 'brand.brand_name','brand.status')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $target = [];
            $target = [27, 28, 29];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);
            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }

            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#restoreDataModel" class="btn btn-icon restore-records" data-id="' . $row["id"] . '" ><i class="fa fa-undo text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['brand_name'];
            $nestedData[] = $row['status'] == 'A' ? '<span class="label label-lg label-light-success label-inline">Active</span>' : '<span class="label label-lg label-light-danger  label-inline">Deactive</span>';
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
        $checkBrandName = Brand::from('brand')
            ->where('brand.brand_name', $requestData['brand_name'])
            ->where('brand.is_deleted', 'N')
            ->count();

        if ($checkBrandName == 0) {
            $objBrand = new Brand();
            $objBrand->brand_name = $requestData['brand_name'];
            $objBrand->status = $requestData['status'];
            $objBrand->is_deleted = 'N';
            $objBrand->created_at = date('Y-m-d H:i:s');
            $objBrand->updated_at = date('Y-m-d H:i:s');
            if ($objBrand->save()) {
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $requestData, 'Brand');
                return 'added';
            } else {
                return 'wrong';
            }
        }
        return 'brand_name_exists';
    }

    public function saveEdit($requestData){
        $checkBrandName = Brand::from('brand')
            ->where('brand.brand_name', $requestData['brand_name'])
            ->where('brand.is_deleted', 'N')
            ->where('brand.id', '!=', $requestData['brand_Id'])
            ->count();

        if($checkBrandName == 0) {
            $objBrand = Brand::find($requestData['brand_Id']);
            $objBrand->brand_name = $requestData['brand_name'];
            $objBrand->status = $requestData['status'];
            $objBrand->updated_at = date('Y-m-d H:i:s');
            if ($objBrand->save()) {
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $requestData, 'Brand');
                return 'updated';
            } else {
                return 'wrong';
            }
        }
        return 'manager_name_exists';
    }

    public function get_brand_details($brandId){
        return Brand::from('brand')
            ->where("brand.id", $brandId)
            ->select('brand.id', 'brand.brand_name', 'brand.status')
            ->first();
    }

    public function get_admin_brand_details(){
        return Brand::from('brand')
            ->select('brand.id','brand.brand_name','brand.status')
            ->get();
    }

    public function common_activity($requestData){
        $objBrand = Brand::find($requestData['id']);
        if($requestData['activity'] == 'delete-records'){
            $objBrand->is_deleted = "Y";
            $event = 'D';
        }

        if ($requestData['activity'] == 'restore-records') {
            $objBrand->is_deleted = "N";
            $event = 'R';
        }

        if($requestData['activity'] == 'active-records'){
            $objBrand->status = "A";
            $event = 'A';
        }

        if($requestData['activity'] == 'deactive-records'){
            $objBrand->status = "I";
            $event = 'DA';
        }

        $objBrand->updated_at = date("Y-m-d H:i:s");
        if($objBrand->save()){
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'Manager');
            return true;
        }else{
            return false ;
        }
    }
}

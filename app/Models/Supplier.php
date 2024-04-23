<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';

    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'supplier.id',
            1 => 'supplier.suppiler_name',
            2 => 'supplier.supplier_shop_name',
            3 => 'supplier.shop_contact',
            4 => 'supplier.personal_contact',
            5 => 'supplier.sort_name',
            6 => DB::raw('(CASE WHEN supplier.priority = 0 THEN "Low" WHEN supplier.priority = 1 THEN "Medium" ELSE "High" END)'),
            7 => 'supplier.address',
            8 => DB::raw('(CASE WHEN supplier.status = "A" THEN "Actived" ELSE "Deactived" END)'),
        );
        $query = Supplier::from('supplier')
            ->where("supplier.is_deleted", "=", "N");

            if($fillterdata['Priority'] != null && $fillterdata['Priority'] != ''){
                if($fillterdata['Priority'] == 0){
                    $query->where("supplier.priority", "0");
                } elseif($fillterdata['Priority'] == 1){
                    $query->where("supplier.priority", "1");
                } else {
                    $query->where("supplier.priority", "2");
                }
            }

            if($fillterdata['status'] != null && $fillterdata['status'] != ''){
                if($fillterdata['status'] == 1){
                    $query->where("supplier.status", "A");
                } else {
                    $query->where("supplier.status", "I");
                }
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
            ->select('supplier.id','supplier.suppiler_name','supplier.supplier_shop_name','supplier.shop_contact','supplier.personal_contact','supplier.sort_name', 'supplier.priority', 'supplier.address','supplier.status')
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {
            $target = [];
            $target = [101, 102, 103, 104];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(101, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href=""data-toggle="modal" data-target="#supplier-view" data-id="'.$row['id'].'" class="btn btn-icon supplier-view"><i class="fa fa-eye text-primary"> </i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(102, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.supplier.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(103, explode(',', $permission_array[0]['permission'])) ){
                if ($row['status'] == 'A') {
                    $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deactiveModel" class="btn btn-icon  deactive-records" data-id="' . $row["id"] . '" ><i class="fa fa-times text-primary" ></i></a>';
                } else {
                    $actionhtml .= '<a href="#" data-toggle="modal" data-target="#activeModel" class="btn btn-icon  active-records" data-id="' . $row["id"] . '" ><i class="fa fa-check text-primary" ></i></a>';
                }
            }

            if ($row['priority'] == '0') {
                $priority = '<span class="label label-lg label-light-danger label-inline">Low</span>';
            } elseif($row['priority'] == '1') {
                $priority = '<span class="label label-lg label-light-warning label-inline">Medium</span>';
            } else {
                $priority = '<span class="label label-lg label-light-success label-inline">High</span>';
            }

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(104, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] =  $row['suppiler_name'];
            $nestedData[] = $row['supplier_shop_name'];
            $nestedData[] = $row['shop_contact'];
            $nestedData[] = $row['personal_contact'];
            $nestedData[] = $priority;
            $nestedData[] = $row['sort_name'];
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

    public function getSupplierDatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'supplier.id',
            1 => 'supplier.suppiler_name',
            2 => 'supplier.supplier_shop_name',
            3 => 'supplier.shop_contact',
            4 => 'supplier.personal_contact',
            5 => 'supplier.sort_name',
            6 => DB::raw('(CASE WHEN supplier.priority = 0 THEN "Low" WHEN supplier.priority = 1 THEN "Medium" ELSE "High" END)'),
            7 => 'supplier.address',
            8 => DB::raw('(CASE WHEN supplier.status = "A" THEN "Actived" ELSE "Deactived" END)'),
        );
        $query = Supplier::from('supplier')
            ->where("supplier.is_deleted", "=", "Y");

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
            ->select('supplier.id','supplier.suppiler_name','supplier.supplier_shop_name','supplier.shop_contact','supplier.personal_contact','supplier.sort_name', 'supplier.priority', 'supplier.address','supplier.status')
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {
            $target = [];
            $target = [101, 102, 103, 104];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }

            if ($row['priority'] == '0') {
                $priority = '<span class="label label-lg label-light-danger label-inline">Low</span>';
            } elseif($row['priority'] == '1') {
                $priority = '<span class="label label-lg label-light-warning label-inline">Medium</span>';
            } else {
                $priority = '<span class="label label-lg label-light-success label-inline">High</span>';
            }

            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#restoreDataModel" class="btn btn-icon restore-records" data-id="' . $row["id"] . '" ><i class="fa fa-undo text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] =  $row['suppiler_name'];
            $nestedData[] = $row['supplier_shop_name'];
            $nestedData[] = $row['shop_contact'];
            $nestedData[] = $row['personal_contact'];
            $nestedData[] = $priority;
            $nestedData[] = $row['sort_name'];
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
        $countSupplier = Supplier::from('supplier')
            ->where('supplier.suppiler_name', $requestData['supplier_name'])
            ->where('supplier.supplier_shop_name', $requestData['shop_name'])
            ->where('supplier.is_deleted', 'N')
            ->count();

        if ($countSupplier == 0) {
            $objSupplier = new Supplier();
            $objSupplier->suppiler_name = $requestData['supplier_name'];
            $objSupplier->supplier_shop_name = $requestData['shop_name'];
            $objSupplier->personal_contact = $requestData['personal_contact'];
            $objSupplier->shop_contact = $requestData['shop_contact'];
            $objSupplier->address = $requestData['address'];
            $objSupplier->priority = $requestData['priority'];
            $objSupplier->sort_name = $requestData['short_name'];
            $objSupplier->status = $requestData['status'];
            $objSupplier->is_deleted = 'N';
            $objSupplier->created_at = date('Y-m-d H:i:s');
            $objSupplier->updated_at = date('Y-m-d H:i:s');
            if ($objSupplier->save()) {
                unset($requestData['_token']);
                $objAudittrails = new Audittrails();
                $res = $objAudittrails->add_audit('I', $requestData, 'Supplier');
                return 'added';
            }
            return 'wrong';
        }
        return 'supplier_exists';
    }

    public function saveEdit($requestData)
    {
        $countSupplier = Supplier::from('supplier')
            ->where('supplier.suppiler_name', $requestData['supplier_name'])
            ->where('supplier.supplier_shop_name', $requestData['shop_name'])
            ->where('supplier.is_deleted', 'N')
            ->where('supplier.id', "!=", $requestData['supplier_id'])
            ->count();
        if ($countSupplier == 0) {
            $objSupplier = Supplier::find($requestData['supplier_id']);
            $objSupplier->suppiler_name = $requestData['supplier_name'];
            $objSupplier->supplier_shop_name = $requestData['shop_name'];
            $objSupplier->personal_contact = $requestData['personal_contact'];
            $objSupplier->sort_name = $requestData['short_name'];
            $objSupplier->address = $requestData['address'];
            $objSupplier->shop_contact = $requestData['shop_contact'];
            $objSupplier->priority = $requestData['priority'];
            $objSupplier->status = $requestData['status'];
            $objSupplier->updated_at = date('Y-m-d H:i:s');
            if ($objSupplier->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                //unset($requestData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit('U', $inputData, 'Supplier');
                return 'added';
            }
            return 'wrong';
        }
        return 'supplier_name_exists';
    }


    public function common_activity($requestData)
    {
        $objSupplier = Supplier::find($requestData['id']);
        if ($requestData['activity'] == 'delete-records') {
            $objSupplier->is_deleted = "Y";
            $event = 'D';
        }

        if ($requestData['activity'] == 'restore-records') {
            $objSupplier->is_deleted = "N";
            $event = 'R';
        }

        if ($requestData['activity'] == 'active-records') {
            $objSupplier->status = "A";
            $event = 'A';
        }

        if ($requestData['activity'] == 'deactive-records') {
            $objSupplier->status = "I";
            $event = 'DA';
        }

        $objSupplier->updated_at = date("Y-m-d H:i:s");
        if ($objSupplier->save()) {
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'Supplier');
            return true;
        } else {
            return false;
        }
    }

    public function get_Supplier_details($supplierId)
    {
        return Salary::from('supplier')
        ->select('supplier.id','supplier.suppiler_name','supplier.supplier_shop_name','supplier.shop_contact','supplier.personal_contact','supplier.priority','supplier.sort_name','supplier.address','supplier.status')
        ->where('supplier.id', $supplierId)
        ->first();
    }

    public function get_admin_suplier_details(){
        return Salary::from('supplier')
            ->select('supplier.id','supplier.suppiler_name','supplier.supplier_shop_name','supplier.status','supplier.sort_name','supplier.priority')
            ->get();
    }
}

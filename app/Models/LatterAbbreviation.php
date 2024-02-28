<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LatterAbbreviation extends Model
{
    use HasFactory;

    protected $table = 'latter_abbreviation';

    public function getdatatable()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'latter_abbreviation.id',
            0 => 'latter_abbreviation.key',
            0 => 'latter_abbreviation.value',
        );

        $query = LatterAbbreviation::from("latter_abbreviation");

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
            ->select('latter_abbreviation.id', 'latter_abbreviation.key', 'latter_abbreviation.value')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {

            // $target = [];
            // $target = [148];
            // $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            // if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
            //     $actionhtml = '';
            // }
            // if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(148, explode(',', $permission_array[0]['permission'])) )
            // $actionhtml .= '<a href="latter-abbreviations/' . $row["id"] . '/edit" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = htmlspecialchars($row['key']);
            $nestedData[] = $row['value'];
            // if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
            //     $nestedData[] = $actionhtml;
            // }
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

    public function store($requestData)
    {
        $checkLatterAbbreviation = LatterAbbreviation::where('latter_abbreviation.key', $requestData['key'])
            ->count();

        if ($checkLatterAbbreviation == 0) {
            $objLatterAbbreviation = new LatterAbbreviation();
            $objLatterAbbreviation->key = $requestData['key'];
            $objLatterAbbreviation->value = $requestData['value'];
            $objLatterAbbreviation->created_at = date('Y-m-d H:i:s');
            $objLatterAbbreviation->updated_at = date('Y-m-d H:i:s');
            if ($objLatterAbbreviation->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $inputData, 'Latter Abbreviation');
                return 'added';
            }
            return 'wrong';
        }
        return 'latter_abbreviation_exists';
    }

    public function saveEdit($requestData)
    {
        $checkLatterAbbreviation = LatterAbbreviation::where('latter_abbreviation.key', $requestData['key'])
        ->where('latter_abbreviation.id', '!=', $requestData['editId'])
        ->count();

        if ($checkLatterAbbreviation == 0) {
            $objLatterAbbreviation = LatterAbbreviation::find($requestData['editId']);
            $objLatterAbbreviation->key = $requestData['key'];
            $objLatterAbbreviation->value = $requestData['value'];
            $objLatterAbbreviation->updated_at = date('Y-m-d H:i:s');
            if ($objLatterAbbreviation->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $inputData, 'Latter Abbreviation');
                return 'updated';
            }
            return 'wrong';
        }
        return 'latter_abbreviation_exists';
        }


    public function get_latter_abbreviation_details($id)
    {
        return LatterAbbreviation::where('latter_abbreviation.id', $id)->first();
    }

    public function get_latter_abbreviation_view_details(){
        return LatterAbbreviation::all();
    }
}

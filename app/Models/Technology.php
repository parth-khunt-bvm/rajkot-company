<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Route;
use Session;
use Hash;

class Technology extends Model
{
    use HasFactory;

    protected $table = "technology";

    public function getdatatable()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'technology.id',
            1 => 'technology.technology_name',
            2 => DB::raw('(CASE WHEN technology.status = "A" THEN "Actived" ELSE "Deactived" END)'),
        );
        $query = Technology::from('technology')
            ->where("technology.is_deleted", "=", "N");

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
            ->select('technology.id', 'technology.technology_name', 'technology.status')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $actionhtml = '';
            $actionhtml .= '<a href="' . route('admin.technology.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';
            if ($row['status'] == 'A') {
                $status = '<span class="label label-lg label-light-success label-inline">Active</span>';
                $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deactiveModel" class="btn btn-icon  deactive-records" data-id="' . $row["id"] . '" ><i class="fa fa-times text-primary" ></i></a>';
            } else {
                $status = '<span class="label label-lg label-light-danger  label-inline">Deactive</span>';
                $actionhtml .= '<a href="#" data-toggle="modal" data-target="#activeModel" class="btn btn-icon  active-records" data-id="' . $row["id"] . '" ><i class="fa fa-check text-primary" ></i></a>';
            }
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            // $nestedData[] = $row['id'];
            $nestedData[] = $row['technology_name'];
            $nestedData[] = $row['created_date'];
            $nestedData[] = $status;
            $nestedData[] = $actionhtml;
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
        $objTechnology = new Technology();
        $objTechnology->technology_name = $requestData['technology_name'];
        $objTechnology->created_at = date('Y-m-d H:i:s');
        $objTechnology->updated_at = date('Y-m-d H:i:s');
        if ($objTechnology->save()) {
            return 'added';
        } else {
            return 'wrong';
        }
    }

    public function saveEdit($requestData)
    {
        $objTechnology = Technology::find($requestData['editId']);
        $objTechnology->technology_name = $requestData['technology_name'];
        $objTechnology->created_at = date('Y-m-d H:i:s');
        $objTechnology->updated_at = date('Y-m-d H:i:s');
        if ($objTechnology->save()) {
            return 'added';
        } else {
            return 'wrong';
        }
    }

    public function get_admin_technology_details()
    {
        return Technology::from('technology')
            ->select('technology.id', 'technology.technology_name')
            ->where('technology.id')
            ->get()->toArray();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PublicHoliday extends Model
{
    use HasFactory;

    protected $table= "public_holiday";

    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'public_holiday.id',
            1 => 'public_holiday.date',
            2 => 'public_holiday.holiday_name',
            3 => 'public_holiday.note',
            4 => DB::raw('DATE_FORMAT(public_holiday.date, "%d-%b-%Y")'),

        );
        $query = PublicHoliday::from('public_holiday')
            ->where("public_holiday.is_deleted", "=", "N");

            if($fillterdata['startDate'] != null && $fillterdata['startDate'] != ''){
                $query->whereDate('date', '>=', date('Y-m-d', strtotime($fillterdata['startDate'])));
            }
            if($fillterdata['endDate'] != null && $fillterdata['endDate'] != ''){
                $query->whereDate('date', '<=',  date('Y-m-d', strtotime($fillterdata['endDate'])));
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
            ->select( 'public_holiday.id','public_holiday.date','public_holiday.holiday_name','public_holiday.note')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {

            $target = [];
            $target = [123,124,125];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(123, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href=""data-toggle="modal" data-target="#public-holiday-view" data-id="'.$row['id'].'" class="btn btn-icon public-holiday-view"><i class="fa fa-eye text-primary"> </i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(124, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.public-holiday.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

             if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(125, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = date_formate($row['date']);
            $nestedData[] = $row['holiday_name'];
            $nestedData[] = $row['note'];
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
    public function saveAdd($requestData){
        $checkPublicHoliday = PublicHoliday::from('public_holiday')
                    ->where('public_holiday.date', date('Y-m-d', strtotime($requestData['date'])))
                    ->where('public_holiday.is_deleted', 'N')
                    ->count();

        if($checkPublicHoliday == 0){
            $objPublicHoliday = new PublicHoliday();
            $objPublicHoliday->date =date('Y-m-d', strtotime($requestData['date']));
            $objPublicHoliday->holiday_name = $requestData['public_holiday_name'];
            $objPublicHoliday->note = $requestData['note'] ?? '-';
            $objPublicHoliday->is_deleted = 'N';
            $objPublicHoliday->created_at = date('Y-m-d H:i:s');
            $objPublicHoliday->updated_at = date('Y-m-d H:i:s');
            if($objPublicHoliday->save()){
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $inputData, 'PublicHoliday');
                return 'added';
            }else{
                return 'wrong';
            }
        }
        return 'public_holiday_name_exists';
    }

    public function saveEdit($requestData){
        $checkPublicHoliday = PublicHoliday::from('public_holiday')
                    ->where('public_holiday.date', date('Y-m-d', strtotime($requestData['date'])))
                    ->where('public_holiday.is_deleted', 'N')
                    ->where('public_holiday.id', '!=', $requestData['public_holiday_Id'])
                    ->count();

        if($checkPublicHoliday == 0){
            $objPublicHoliday = PublicHoliday::find($requestData['public_holiday_Id']);
            $objPublicHoliday->date =date('Y-m-d', strtotime($requestData['date']));
            $objPublicHoliday->holiday_name = $requestData['public_holiday_name'];
            $objPublicHoliday->note = $requestData['note'] ?? '-';
            $objPublicHoliday->updated_at = date('Y-m-d H:i:s');
            if($objPublicHoliday->save()){
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $inputData, 'PublicHoliday');
                return 'updated';
            }else{
                return 'wrong';
            }
        }
        return 'public_holiday_name_exists';
    }

    public function common_activity($requestData){

        $objPublicHoliday = PublicHoliday::find($requestData['id']);
        if($requestData['activity'] == 'delete-records'){
            $objPublicHoliday->is_deleted = "Y";
            $event = 'D';
        }

        $objPublicHoliday->updated_at = date("Y-m-d H:i:s");
        if($objPublicHoliday->save()){
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'PublicHoliday');
            return true;
        }else{
            return false ;
        }
    }

    public function get_public_holiday_details($publicHolidayId){
        return PublicHoliday::from('public_holiday')
                ->where("public_holiday.id", $publicHolidayId)
                ->select( 'public_holiday.id','public_holiday.date','public_holiday.holiday_name','public_holiday.note')
                ->first();
    }

}

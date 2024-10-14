<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaPost extends Model
{
    use HasFactory;

    protected $table= 'social_media_post';

    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'social_media_post.id',
            1 => DB::raw('DATE_FORMAT(social_media_post.date, "%d-%b-%Y")'),
            3 => DB::raw('DATE_FORMAT(social_media_post.date, "%W")'),
            4 => 'social_media_post.post_detail',
            5 => 'social_media_post.note',

        );
        $query = SocialMediaPost::from('social_media_post')
            ->where("social_media_post.is_deleted", "=", "N");

            if($fillterdata['startDate'] != null && $fillterdata['startDate'] != ''){
                $query->whereDate('date', '>=', date('Y-m-d', strtotime($fillterdata['startDate'])));
            }
            if($fillterdata['endDate'] != null && $fillterdata['endDate'] != ''){
                $query->whereDate('date', '<=',  date('Y-m-d', strtotime($fillterdata['endDate'])));
            }

        if (!empty($requestData['search']['value'])) {
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
            ->select( 'social_media_post.id','social_media_post.date','social_media_post.post_detail','social_media_post.note')
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
            $actionhtml .= '<a href=""data-toggle="modal" data-target="#social-media-post-view" data-id="'.$row['id'].'" class="btn btn-icon social-media-post-view"><i class="fa fa-eye text-primary"> </i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(124, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.social-media-post.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

             if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(125, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = date_formate($row['date']);
            $nestedData[] = date("l", strtotime($row['date']));
            $nestedData[] = $row['post_detail'];
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
        $checkSocialMediaPost = SocialMediaPost::from('social_media_post')
                    ->where('social_media_post.date', date('Y-m-d', strtotime($requestData['date'])))
                    ->where('social_media_post.is_deleted', 'N')
                    ->count();

        if($checkSocialMediaPost == 0){
            $objSocialMediaPost = new SocialMediaPost();
            $objSocialMediaPost->date = date('Y-m-d', strtotime($requestData['date']));
            $objSocialMediaPost->post_detail = $requestData['post_detail'];
            $objSocialMediaPost->note = $requestData['note'] ?? '-';
            $objSocialMediaPost->is_deleted = 'N';
            $objSocialMediaPost->created_at = date('Y-m-d H:i:s');
            $objSocialMediaPost->updated_at = date('Y-m-d H:i:s');
            if($objSocialMediaPost->save()){
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $inputData, 'Social Media Post');
                return 'added';
            }else{
                return 'wrong';
            }
        }
        return 'social_media_post_exists';
    }

    public function saveEdit($requestData){
        $checkSocialMediaPost = SocialMediaPost::from('social_media_post')
                    ->where('social_media_post.date', date('Y-m-d', strtotime($requestData['date'])))
                    ->where('social_media_post.is_deleted', 'N')
                    ->where('social_media_post.id', '!=', $requestData['social_media_post_id'])
                    ->count();

        if($checkSocialMediaPost == 0){
            $objSocialMediaPost = SocialMediaPost::find($requestData['social_media_post_id']);
            $objSocialMediaPost->date = date('Y-m-d', strtotime($requestData['date']));
            $objSocialMediaPost->post_detail = $requestData['post_detail'];
            $objSocialMediaPost->note = $requestData['note'] ?? '-';
            $objSocialMediaPost->updated_at = date('Y-m-d H:i:s');
            if($objSocialMediaPost->save()){
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $inputData, 'Social Media Post');
                return 'updated';
            }else{
                return 'wrong';
            }
        }
        return 'social_media_post_exists';
    }

    public function common_activity($requestData){

        $objSocialMediaPost = SocialMediaPost::find($requestData['id']);
        if($requestData['activity'] == 'delete-records'){
            $objSocialMediaPost->is_deleted = "Y";
            $event = 'D';
        }

        $objSocialMediaPost->updated_at = date("Y-m-d H:i:s");
        if($objSocialMediaPost->save()){
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'Social Media Post');
            return true;
        } else {
            return false;
        }
    }

    public function get_social_meadia_post_details($socialMediaPostId){
        return SocialMediaPost::from('social_media_post')
                ->where('social_media_post.id', $socialMediaPostId)
                ->select( 'social_media_post.id', 'social_media_post.date', 'social_media_post.post_detail', 'social_media_post.note')
                ->first();
    }
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\SendMail;
// use App\Events\SendMail;
use Hash;
use DB;
use Event;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table= "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'users.id',
            1 => 'users.first_name',
            2 => 'users.last_name',
            3 => 'users.email',
            4 => 'user_role.user_role',
            5 => DB::raw('(CASE WHEN users.status = "A" THEN "Actived" ELSE "Deactived" END)'),
        );

        $query = User::from('users')
            ->join('user_role', 'user_role.id', '=', 'users.user_type')
            ->where("users.is_deleted", "=", "N")
            ->where("users.is_admin", "=", "N")
            ->where("users.user_type", "!=", 0)
            ->where("users.id", "!=", Auth()->guard('admin')->user()->id);

            if($fillterdata['userStatus'] != null && $fillterdata['userStatus'] != ''){
                if($fillterdata['userStatus'] == 1){
                    $query->where("users.status", "A");
                } else {
                    $query->where("users.status", "I");
                }
            }

            if($fillterdata['userType'] != null && $fillterdata['userType'] != ''){
                $query->where("user_role.id", $fillterdata['userType']);
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
            ->select('users.id','users.first_name','users.last_name','users.email', 'user_role.user_role','users.status')
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {
            $target = [];
            $target = [3, 4, 5];
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);
            if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 ){
                $actionhtml = '';
            }
            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(3, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="' . route('admin.user.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';

            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(4, explode(',', $permission_array[0]['permission'])) ){
                if ($row['status'] == 'A') {
                    $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deactiveModel" class="btn btn-icon  deactive-records" data-id="' . $row["id"] . '" ><i class="fa fa-times text-primary" ></i></a>';
                } else {
                    $actionhtml .= '<a href="#" data-toggle="modal" data-target="#activeModel" class="btn btn-icon  active-records" data-id="' . $row["id"] . '" ><i class="fa fa-check text-primary" ></i></a>';
                }
            }
            if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(5, explode(',', $permission_array[0]['permission'])) )
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] =  $row['first_name'];
            $nestedData[] = $row['last_name'];
            $nestedData[] = $row['email'];
            $nestedData[] = $row['user_role'];
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
    public function saveAdd($requestData){
        // dd($requestData);
        $checkUseremail = User::from('users')
                    ->where('users.email', $requestData['email'])
                    ->where('users.is_deleted', 'N')
                    ->count();

        if($checkUseremail == 0){
            $objUser = new User();
            $objUser->first_name = $requestData['first_name'];
            $objUser->last_name = $requestData['last_name'];
            $objUser->email  = $requestData['email'];
            $objUser->password = Hash::make($requestData['password']);
            $objUser->user_type = $requestData['user_role'];
            $objUser->status = $requestData['status'];
            $objUser->is_deleted = 'N';
            $objUser->created_at = date('Y-m-d H:i:s');
            $objUser->updated_at = date('Y-m-d H:i:s');
            if($objUser->save()){
                foreach ($requestData['branch'] as $key => $value) {
                    $objUserBranch = new UserBranch();
                    $objUserBranch->user_id = $objUser->id;
                    $objUserBranch->branch_id = $value;
                    $objUserBranch->save();
                  }
                $mailData['data']=[];
                $mailData['data']['first_name'] = $requestData['first_name'];
                $mailData['data']['last_name'] = $requestData['last_name'];
                $mailData['data']['email'] = $requestData['email'];
                $mailData['data']['password'] = $requestData['password'];
                $mailData['subject'] = 'Rajkot Company - Add User';
                $mailData['data']['company'] = 'BVM Infotech';
                $mailData['attachment'] = array(
                    'image_path' => public_path('upload/company_image/logo.png'),
                );
                $mailData['template'] ="backend.pages.user.user.mail";
                $mailData['mailto'] = $requestData['email'];
                $sendMail = new Sendmail();
                $sendMail->sendSMTPMail($mailData);

                // Event::dispatch(new SendMail(1),$mailData);

                $inputData = $requestData->input();
                unset($inputData['_token']);
                unset($inputData['password']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $inputData, 'User');
                return 'added';
            }else{
                return 'wrong';
            }
        }
        return 'user_name_exists';
    }

    public function saveEdit($requestData){

        $checkUseremail = User::from('users')
        ->where('users.email', $requestData['email'])
        ->where('users.is_deleted', 'N')
        ->where('users.id', '!=', $requestData['userId'])
        ->count();

        if($checkUseremail == 0){
            $objUser = User::find($requestData['userId']);
            $objUser->first_name = $requestData['first_name'];
            $objUser->last_name = $requestData['last_name'];
            $objUser->email  = $requestData['email'];
            $objUser->user_type = $requestData['user_role'];
            $objUser->status = $requestData['status'];
            $objUser->updated_at = date('Y-m-d H:i:s');
            if($objUser->save()){
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $inputData, 'Branch');
                return 'updated';
            }else{
                return 'wrong';
            }
        }
        return 'user_name_exists';
    }
    public function get_user_details($userId)
    {
        return User::from('users')
            ->where("users.id", $userId)
            ->select('users.id','users.first_name','users.last_name','users.email','users.password','users.user_type', 'users.status',)
            ->first();
    }


    public function common_activity($requestData){

        $objUser = User::find($requestData['id']);
        if($requestData['activity'] == 'delete-records'){
            $objUser->is_deleted = "Y";
            $event = 'D';
        }

        if($requestData['activity'] == 'active-records'){
            $objUser->status = "A";
            $event = 'A';
        }

        if($requestData['activity'] == 'deactive-records'){
            $objUser->status = "I";
            $event = 'DA';
        }

        $objUser->updated_at = date("Y-m-d H:i:s");
        if($objUser->save()){
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'User');
            return true;
        }else{
            return false ;
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Hash;
use DB;

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
            4 => 'users.password',
            5 => 'user_role.user_role',
            6 => DB::raw('(CASE WHEN users.status = "A" THEN "Actived" ELSE "Deactived" END)'),
        );

        $query = User::from('users')
            ->join('user_role', 'user_role.id', '=', 'users.user_type')
            ->where("users.is_deleted", "=", "N")
            ->where("users.is_admin", "=", "N")
            ->where("users.user_type", "!=", 0);

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
            ->select('users.id','users.first_name','users.last_name','users.email','users.password', 'user_role.user_role','users.status')
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {
            $actionhtml = '';
            $actionhtml .= '<a href="' . route('admin.user.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';
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
            $nestedData[] =  $row['first_name'];
            $nestedData[] = $row['last_name'];
            $nestedData[] = $row['email'];
            $nestedData[] = $row['password'];
            $nestedData[] = $row['user_role'];
            $nestedData[] = $status;
            $nestedData[] = $actionhtml;

            if (strlen($row['remarks']) > $max_length) {
                $nestedData[] = substr($row['remarks'], 0, $max_length) . '...';
            } else {
                $nestedData[] = $row['remarks']; // If it's not longer than max_length, keep it as is
            }
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


    public function saveAdd($requestData){
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
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("I", $requestData, 'User');
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
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $requestData, 'Branch');
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
            ->select('users.id','users.first_name','users.last_name','users.email','users.password','users.user_type', 'users.status')
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

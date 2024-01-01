<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBranch extends Model
{
    use HasFactory;
    protected $table= "user_branch";

    public function get_user_branch_detail($userId){
        return UserBranch::from('user_branch')
            ->where("user_branch.user_id", $userId)
            ->select('user_branch.id','user_branch.user_id','user_branch.branch_id')
            ->get();

    }
}

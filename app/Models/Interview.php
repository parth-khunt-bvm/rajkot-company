<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interview extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'interviews'; // Explicitly define the table name if different from default
    protected $primaryKey = 'interview_id'; // Define the primary key if it's not 'id'
    protected $SoftDelete = true;
    protected $fillable = [
        'schedule_date',
        'name',
        'mobile_no',
        'technology',
        'designation',
        'status',
        'description',
        'location',
        'experience',
        'current_salary',
        'expected_salary',
        'notice_period',
        'reason_for_change',
        'resume',
        'tag',
        'hr_round_date_time',
        'hr_round_status',
        'hr_round_reason',
        'team_leader_date_time',
        'team_leader_status',
        'team_leader_reason',
        'practical_date_time',
        'practical_status',
        'practical_reason',
        'allocated_interviewer',
        'final_status',
        'interviewer_note',
        'note',
    ];

    // Relationship to Technology model
    public function technology()
    {
        return $this->belongsTo(Technology::class, 'technology', 'id');
    }

    // Relationship to Designation model
    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation', 'id');
    }

    // Relationship to Employee model
    public function interviewer()
    {
        return $this->belongsTo(Employee::class, 'allocated_interviewer', 'id');
    }
}

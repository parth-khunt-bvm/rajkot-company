<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetAllocationHistory extends Model
{
    use HasFactory;
    protected $table = 'asset_allocation_history';
    protected $fillable = [
        'asset_id',
        'employee_id',
    ];

    public function asset()
    {
        return $this->belongsTo(AssetMaster::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

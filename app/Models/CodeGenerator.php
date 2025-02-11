<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeGenerator extends Model
{
    use HasFactory;

    protected $table = 'code_generator';
    protected $fillable = ['last_generated_value'];
}

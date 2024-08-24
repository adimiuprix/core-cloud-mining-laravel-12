<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPlanHistory extends Model
{
    use HasFactory;

    protected $table = 'user_plan_histories';

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'last_sum',
        'expire_date',
        'created_at'
    ];
}

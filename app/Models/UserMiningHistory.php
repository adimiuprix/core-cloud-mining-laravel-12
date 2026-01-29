<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMiningHistory extends Model
{
    use HasFactory;

    protected $table = 'user_mining_histories';

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'last_sum',
        'expire_date',
        'created_at'
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}

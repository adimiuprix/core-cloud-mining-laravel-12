<?php

namespace App\Models;

use App\Models\UserMiningHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_name',
        'is_default',
        'point_per_day',
        'version',
        'earning_rate',
        'price',
        'duration',
        'profit'
    ];

    /**
     * Get histories associated with this plan.
     */
    public function histories()
    {
        return $this->hasMany(UserMiningHistory::class);
    }
}

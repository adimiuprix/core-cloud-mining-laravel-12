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
        'expire_date'
    ];

    protected $casts = [
        'expire_date' => 'integer',
        'last_sum' => 'integer'
    ];

    /**
     * Get the user that owns the mining history.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the plan associated with the mining history.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Scope a query to only include active mining histories.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Calculate earnings since last update.
     */
    public function calculateEarnings(): float
    {
        $currentTime = time();
        $startTime = $this->last_sum ?: $this->created_at->timestamp;

        $seconds = $currentTime - $startTime;
        $earning = $seconds * ($this->plan->earning_rate / 60);

        return (float) $earning;
    }
}

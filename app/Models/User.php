<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'balance',
    ];

    /**
     * Get the mining histories for the user.
     */
    public function miningHistories()
    {
        return $this->hasMany(UserMiningHistory::class);
    }

    /**
     * Calculate and sync user balance from active plans.
     */
    public function syncBalance(): float
    {
        $activePlans = $this->miningHistories()->active()->with('plan')->get();
        $totalEarning = 0;
        $currentTime = time();

        foreach ($activePlans as $history) {
            $totalEarning += $history->calculateEarnings();
            $history->update(['last_sum' => $currentTime]);
        }

        if ($totalEarning > 0) {
            $this->increment('balance', $totalEarning);
        }

        return (float) $this->balance;
    }

    /**
     * Expire plans that have reached their expire_date.
     */
    public function expirePlans(): void
    {
        $this->miningHistories()
            ->active()
            ->whereNotNull('expire_date')
            ->where('expire_date', '<=', time())
            ->update(['status' => 'inactive']);
    }

    /**
     * Get active plans through relationship.
     */
    public function activePlans()
    {
        return $this->miningHistories()->active()->join('plans', 'plans.id', '=', 'user_mining_histories.plan_id')
            ->select('user_mining_histories.*', 'plans.*')
            ->get();
    }

    /**
     * Get earning rate per minute.
     */
    public function getTotalEarningRate(): float
    {
        return (float) $this->miningHistories()->active()
            ->with('plan')
            ->get()
            ->sum(fn($history) => $history->plan->earning_rate);
    }
}

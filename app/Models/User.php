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
        'unique_id',
        'username',
        'balance',
        'cashouts',
        'plan_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    public static function getBalance(array $data): string
    {
        $currentTime = time();

        $userPlans = UserMiningHistory::with('plan')
            ->where('user_id', $data['id'])
            ->where('status', 'active')
            ->get(['id', 'last_sum', 'created_at', 'plan_id']);

        $totalEarning = 0;
        $idsToUpdate = [];

        foreach ($userPlans as $value) {
            $lastSum = $value->last_sum ?: strtotime($value->created_at);
            $sec = $currentTime - $lastSum;
            $earning = $sec * ($value->plan->earning_rate / 60);

            $totalEarning += $earning;
            $idsToUpdate[] = $value->id;
        }

        if (!empty($idsToUpdate)) {
            UserMiningHistory::whereIn('id', $idsToUpdate)
                ->update(['last_sum' => $currentTime]);
        }

        return number_format($totalEarning, 8, '.', '');
    }

    public static function updateBalances(int $user_id, float $balance)
    {
        return DB::transaction(function () use ($user_id, $balance) {
            $user = self::where('id', $user_id)->lockForUpdate()->first();

            if ($user) {
                $user->balance += $balance;
                $user->save();
            }

            return $user;
        });
    }

    public static function getUserBalance(int $user_id) :float
    {
        $user = self::findOrFail($user_id);
        return (float) $user->balance;
    }

    public static function getActiveUserPlans(int $user_id)
    {
        return  DB::table('user_mining_histories')
            ->join('plans', 'plans.id', '=', 'user_mining_histories.plan_id')
            ->select('user_mining_histories.*', 'plans.*')
            ->where('user_mining_histories.user_id', $user_id)
            ->where('user_mining_histories.status', 'active')
            ->get();
    }
}

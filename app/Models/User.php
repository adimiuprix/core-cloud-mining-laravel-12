<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'unique_id',
        'username',
        'balance',
        'cashouts',
        'plan_id',
        'reference_user_id',
        'affiliate_earns',
        'affiliate_paid',
        'ip_addr'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [];
    }

    public static function getBalance(array $data): string
    {
        $currentTime = time();

        $earning = DB::table('user_plan_histories as uph')
            ->join('plans as p', 'uph.plan_id', '=', 'p.id')
            ->where('uph.user_id', $data['id'])
            ->where('uph.status', 'active')
            ->get()
            ->sum(function ($value) use ($currentTime) {
                $lastSum = $value->last_sum ?: strtotime($value->created_at);
                $sec = $currentTime - $lastSum;
                $earning = $sec * ($value->earning_rate / 60);

                UserPlanHistory::where('id', $value->id)->update(['last_sum' => $currentTime]);

                return $earning;
            });

        return number_format($earning, 8, '.', '');
    }

    public static function updateBalances(int $user_id, float $balance, float $withdraws)
    {
        return self::where('id', $user_id)
            ->update([
                'balance' => DB::raw('balance + ' . $balance),
                'cashouts' => DB::raw('cashouts + ' . $withdraws),
            ]);
    }

    public static function getUserBalance(int $user_id) :float
    {
        return DB::table('users')->where('id', $user_id)->value('balance');
    }

    public static function getActiveUserPlans(int $user_id)
    {
        return  DB::table('user_plan_histories')
            ->join('plans', 'plans.id', '=', 'user_plan_histories.plan_id')
            ->select('user_plan_histories.*', 'plans.*')
            ->where('user_plan_histories.user_id', $user_id)
            ->where('user_plan_histories.status', 'active')
            ->get();
    }
}

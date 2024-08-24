<?php

namespace App\Models;

use App\Models\UserPlanHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    public static function plansCron(array $data_session): void
    {
        $plans = UserPlanHistory::where('user_id', $data_session['id'])
            ->where('status', 'active')
            ->whereNotNull('expire_date')
            ->get();

        foreach ($plans as $plan) {
            $now = time();
            $expire_date = strtotime($plan->expire_date);

            if ($now >= $expire_date) {
                $plan->update(['status' => 'inactive']);
            }
        }
    }
}

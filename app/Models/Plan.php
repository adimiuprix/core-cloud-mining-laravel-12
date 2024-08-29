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
        UserPlanHistory::where('user_id', $data_session['id'])
            ->where('status', 'active')
            ->whereNotNull('expire_date')
            ->where('expire_date', '<=', now())
            ->update(['status' => 'inactive']);
    }
}

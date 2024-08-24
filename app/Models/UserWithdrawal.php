<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWithdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'status',
        'tx',
        'date_paid'
    ];

    public static function getWithdrawals(string $type = 'payment', ?string $status = null)
    {
        if (session()->has('user_data') && session('user_data') !== "") {
            return UserWithdrawal::query()
                ->where('user_id', session('user_data')->id)
                ->where('type', $type)
                ->when($status, fn($query) => $query->where('status', $status))
                ->get()
                ->toArray();
        }
    }
}

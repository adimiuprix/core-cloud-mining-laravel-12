<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user_session = session()->get('user_data')->toArray();

        Plan::plansCron($user_session);

        $balance = User::getBalance($user_session);

        User::updateBalances($user_session['id'], $balance);

        $getUserBalance = User::getUserBalance($user_session['id']);

        $total_balance = number_format($getUserBalance,8,'.','');

        $active_plans = User::getActiveUserPlans($user_session['id']);

        $userEarningRate = $active_plans->pluck('earning_rate')->map('floatval')->sum();

        return view('dashboard', [
            'address' => $user_session['username'],
            'balance' => $total_balance,
            'acplans' => $active_plans,
            'user_earning_rate' => $userEarningRate
        ]);
    }
}

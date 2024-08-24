<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserWithdrawal;
use App\Models\UserPlanHistory;

class HomeController extends Controller
{
    public function authorize(Request $request) {
        $user_ip_addr = $request->ip();
        $username = $request->input('username');

        $result = User::where('username', $username)->first();

        if ($result) {
            session(['user_data' => $result]);

            return redirect()->to('dashboard');
        } else {
            User::create([
                'username' => $username,
                'ip_addr' => $user_ip_addr,
            ]);

            $result = User::where('username', $username)->first();
            session(['user_data' => $result]);

            return redirect()->route('dashboard');
        }
    }

    public function dashboard()
    {
        $user_session = session()->get('user_data')->toArray();

        Plan::plansCron($user_session);

        $balance = User::getBalance($user_session);

        $withdrawals = UserWithdrawal::getWithdrawals($user_session['id'], 'payment', null);

        $total_withdrawal = array_sum(array_column($withdrawals, 'amount'));

        User::updateBalances($user_session['id'], $balance, $total_withdrawal);

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

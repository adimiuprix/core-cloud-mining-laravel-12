<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserPlanHistory;

class HomeController extends Controller
{
    public function authorize(Request $request) {
        $user_ip_addr = $request->ip();
        $username = $request->input('username');

        $result = User::where('username', $username)->first();

        $plan = Plan::where('is_default', 1)->first(['id']);

        if ($result) {
            session(['user_data' => $result]);

            return redirect()->to('dashboard');
        } else {
            $user = User::create([
                'username' => $username,
                'ip_addr' => $user_ip_addr,
            ]);

            UserPlanHistory::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'status'  => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'expire_date' => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' + 7 days')),
                'last_sum' => time()
            ]);

            $result = User::where('username', $username)->first();
            session(['user_data' => $result]);

            return redirect()->to('dashboard');
        }
    }

    public function logout()
    {
        session()->flush();

        return redirect()->to('/');
    }
}

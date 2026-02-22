<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function authorize(Request $request)
    {
        $username = $request->input('username');

        $user = User::firstOrCreate(
            ['username' => $username]
        );

        // Assign free plan if it's a new user or has no active histories
        if ($user->wasRecentlyCreated || !$user->miningHistories()->exists()) {
            $defaultPlan = Plan::where('is_default', true)->first();

            if ($defaultPlan) {
                $user->miningHistories()->create([
                    'plan_id'     => $defaultPlan->id,
                    'status'      => 'active',
                    'expire_date' => now()->addDays(7),
                    'last_sum'    => time()
                ]);
            }
        }

        session(['user_data' => $user]);

        return redirect()->to('dashboard');
    }

    public function logout()
    {
        session()->flush();

        return redirect()->to('/');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $sessionData = session()->get('user_data');

        if (!$sessionData) {
            return redirect()->to('/');
        }

        /** @var User $user */
        $user = User::findOrFail($sessionData['id']);

        // Orchestrate background tasks
        $user->expirePlans();
        $user->syncBalance();

        return view('dashboard', [
            'address'           => $user->username,
            'balance'           => number_format($user->balance, 8, '.', ''),
            'acplans'           => $user->activePlans(),
            'user_earning_rate' => $user->getTotalEarningRate()
        ]);
    }
}

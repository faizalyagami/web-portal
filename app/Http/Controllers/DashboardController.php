<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Models\System;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil semua sistem aktif, lalu filter berdasarkan akses
        $allSystems = System::active()->get();

        $systems = $allSystems->filter(function ($system) use ($user) {
            return $system->isAccessibleBy($user);
        });

        // Statistik
        $stats = [
            'total' => $allSystems->count(),
            'accessible' => $systems->count(),
            'categories' => $systems->pluck('category')->unique()->count(),
            'user_type_label' => $user->user_type->label(),
        ];

        return view('dashboard.index', compact('systems', 'stats'));
    }
}

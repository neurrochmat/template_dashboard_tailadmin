<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Models\Permission as SpatiePermission;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'roles' => SpatieRole::count(),
            'menus' => Menu::count(),
            'permissions' => SpatiePermission::count(),
        ];

        $recentUsers = User::with('roles')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $recentRoles = SpatieRole::query()
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $recentMenus = Menu::query()
            ->orderByDesc('id')
            ->take(5)
            ->get();

        return view('home', compact('stats', 'recentUsers', 'recentRoles', 'recentMenus'));
    }
}

<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.sidebar', function ($view) {
            $user = Auth::user();
            $menuTree = [];
            if ($user) {
                $roleIds = DB::table('model_has_roles')
                    ->where('model_type', User::class)
                    ->where('model_id', $user->id)
                    ->pluck('role_id');
                $allowedMenuIds = DB::table('role_has_menus')
                    ->whereIn('role_id', $roleIds)
                    ->pluck('menu_id')
                    ->unique();

                if ($allowedMenuIds->isNotEmpty()) {
                    $allMenus = Menu::whereIn('id', $allowedMenuIds)
                        ->orderByRaw("CASE WHEN parent_id IS NULL OR parent_id = '0' THEN id ELSE parent_id END")
                        ->orderBy('urutan')
                        ->get();

                    $byParent = $allMenus->groupBy(function ($m) {
                        return (string)($m->parent_id ?? '0');
                    });

                    $tops = collect()
                        ->merge($byParent->get('0', collect()))
                        ->merge($byParent->get('', collect()));

                    $tree = [];
                    foreach ($tops as $top) {
                        $level1 = $byParent->get((string)$top->id, collect());
                        $children = [];
                        foreach ($level1 as $child) {
                            $grand = $byParent->get((string)$child->id, collect());
                            $children[] = [
                                'menu' => $child,
                                'children' => $grand,
                            ];
                        }
                        $tree[] = [
                            'menu' => $top,
                            'children' => $children,
                        ];
                    }
                    $menuTree = $tree;
                }
            }

            $view->with('menuTree', $menuTree);
        });
    }
}

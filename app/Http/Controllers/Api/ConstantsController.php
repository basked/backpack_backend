<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ConstantsController extends Controller
{
    public function index()
    {
        $permissions = Permission::all()->map(function ($permission) {
            $slug=Str::slug($permission->name);
            $permission->slugCamel = Str::camel($slug);
            return $permission;
        })->pluck('name', 'slugCamel');

        $roles = Role::all()->map(function ($role) {
            $slug=Str::slug($role->name);
            $role->slugCamel = Str::camel($slug);
            return $role;
        })->pluck('slug', 'slugCamel');

        return response()->json([
            "permissions" => $permissions,
            "roles" => $roles
        ]);
    }
}

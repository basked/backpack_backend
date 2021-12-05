<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Role;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $userRoles = $this->roles()->with('permissions')->get();
        $roles = $userRoles->pluck('name');
        $rolesPermissions = $userRoles->pluck('permissions')->flatten(1)->pluck('name');
        $userPermissions = $rolesPermissions->merge($this->permissions->pluck('name'));
        return [
            "name" => $this->name,
            "email" => $this->email,
            "created_at" => $this->created_at->format('Y-m-d'),
            "roles" => $roles,
            "permissions" => $userPermissions,
        ];
    }
}

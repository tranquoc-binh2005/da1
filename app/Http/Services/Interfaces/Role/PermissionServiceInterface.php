<?php
namespace App\Http\Services\Interfaces\Role;

interface PermissionServiceInterface
{
    public function syncPermissions(array $payload = []): bool;
}

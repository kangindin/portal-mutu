<?php

namespace App\Models;

use CodeIgniter\Model;

class RolePermissionModel extends Model
{
    protected $table            = 'role_permissions';
    protected $primaryKey       = 'role_id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'role_id',
        'permission_id',
    ];

    protected $useTimestamps = false;

    /**
     * Mengambil seluruh permission berdasarkan role.
     */
    public function getPermissionsByRole(int $roleId): array
    {
        return $this->db->table('permissions')
            ->select('permissions.*')
            ->join(
                'role_permissions',
                'role_permissions.permission_id = permissions.id'
            )
            ->where('role_permissions.role_id', $roleId)
            ->orderBy('permissions.name', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Mengambil seluruh ID permission berdasarkan role.
     */
    public function getPermissionIdsByRole(int $roleId): array
    {
        $result = $this->where('role_id', $roleId)
            ->findAll();

        return array_column($result, 'permission_id');
    }

    /**
     * Mengganti seluruh permission suatu role.
     */
    public function syncPermissions(int $roleId, array $permissionIds): bool
    {
        $this->db->transStart();

        $this->where('role_id', $roleId)->delete();

        $permissionIds = array_unique(
            array_map('intval', $permissionIds)
        );

        foreach ($permissionIds as $permissionId) {
            if ($permissionId <= 0) {
                continue;
            }

            $this->insert([
                'role_id'       => $roleId,
                'permission_id' => $permissionId,
            ]);
        }

        $this->db->transComplete();

        return $this->db->transStatus();
    }
}
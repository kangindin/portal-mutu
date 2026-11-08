<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\PermissionModel;
use App\Models\RolePermissionModel;
use App\Models\UserModel;

class RolesController extends BaseController
{
    protected $roleModel;
    protected $permissionModel;
    protected $rolePermissionModel;
    protected $userModel;

    public function __construct()
    {
        $this->roleModel           = new RoleModel();
        $this->permissionModel     = new PermissionModel();
        $this->rolePermissionModel = new RolePermissionModel();
        $this->userModel           = new UserModel();
    }

    /**
     * Menampilkan daftar role
     */
    public function index()
    {
        $data = [
            'title' => 'Master Role',
            'roles' => $this->roleModel
                ->orderBy('name', 'ASC')
                ->findAll(),
        ];

        return view('roles/index', $data);
    }

    /**
     * Form tambah role
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Role',
        ];

        return view('roles/create', $data);
    }

    /**
     * Simpan role baru
     */
    public function store()
    {
        $data = [
            'name'        => trim($this->request->getPost('name')),
            'slug'        => trim($this->request->getPost('slug')),
            'description' => trim($this->request->getPost('description') ?? ''),
        ];

        if (!$this->roleModel->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->roleModel->errors());
        }

        return redirect()->to(site_url('roles'))
            ->with('success', 'Role berhasil ditambahkan.');
    }

    /**
     * Form edit role
     */
    public function edit($id = null)
    {
        $role = $this->roleModel->find($id);

        if (!$role) {
            return redirect()->to(site_url('roles'))
                ->with('error', 'Role tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Role',
            'role'  => $role,
        ];

        return view('roles/edit', $data);
    }

    /**
     * Update role
     */
    public function update($id = null)
    {
        $role = $this->roleModel->find($id);

        if (!$role) {
            return redirect()->to(site_url('roles'))
                ->with('error', 'Role tidak ditemukan.');
        }

        $data = [
            'name'        => trim($this->request->getPost('name')),
            'slug'        => trim($this->request->getPost('slug')),
            'description' => trim($this->request->getPost('description') ?? ''),
        ];

        if (!$this->roleModel->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->roleModel->errors());
        }

        return redirect()->to(site_url('roles'))
            ->with('success', 'Role berhasil diperbarui.');
    }

    /**
     * Hapus role
     */
    public function delete($id = null)
    {
        $role = $this->roleModel->find($id);

        if (!$role) {
            return redirect()->to(site_url('roles'))
                ->with('error', 'Role tidak ditemukan.');
        }

        // Cek apakah role masih digunakan pengguna
        $userCount = $this->userModel
            ->where('role_id', $id)
            ->countAllResults();

        if ($userCount > 0) {
            return redirect()->to(site_url('roles'))
                ->with(
                    'error',
                    'Role tidak dapat dihapus karena masih digunakan oleh pengguna.'
                );
        }

        $this->roleModel->delete($id);

        return redirect()->to(site_url('roles'))
            ->with('success', 'Role berhasil dihapus.');
    }

    /**
     * Menampilkan pengaturan hak akses
     */
    public function permissions($id = null)
    {
        $role = $this->roleModel->find($id);

        if (!$role) {
            return redirect()->to(site_url('roles'))
                ->with('error', 'Role tidak ditemukan.');
        }

        $permissions = $this->permissionModel
            ->orderBy('slug', 'ASC')
            ->findAll();

        // Mengelompokkan permission berdasarkan modul
        $permissionGroups = [];

        foreach ($permissions as $permission) {
            $module = explode('.', $permission['slug'])[0];

            $permissionGroups[$module][] = $permission;
        }

        $selectedPermissions = $this->rolePermissionModel
            ->getPermissionIdsByRole((int) $id);

        $data = [
            'title'                => 'Pengaturan Hak Akses',
            'role'                 => $role,
            'permissionGroups'     => $permissionGroups,
            'selectedPermissions'  => $selectedPermissions,
        ];

        return view('roles/permissions', $data);
    }

    /**
     * Simpan pengaturan hak akses
     */
    public function updatePermissions($id = null)
    {
        $role = $this->roleModel->find($id);

        if (!$role) {
            return redirect()->to(site_url('roles'))
                ->with('error', 'Role tidak ditemukan.');
        }

        $permissionIds = $this->request->getPost('permissions') ?? [];

        if (!is_array($permissionIds)) {
            return redirect()->back()
                ->with('error', 'Format hak akses tidak valid.');
        }

        // Konversi ke integer dan hilangkan duplikasi
        $permissionIds = array_unique(
            array_map('intval', $permissionIds)
        );

        // Pastikan semua permission benar-benar tersedia
        if (!empty($permissionIds)) {
            $validIds = $this->permissionModel
                ->whereIn('id', $permissionIds)
                ->findColumn('id');

            $validIds = array_map('intval', $validIds ?? []);

            if (count($validIds) !== count($permissionIds)) {
                return redirect()->back()
                    ->with('error', 'Terdapat hak akses yang tidak valid.');
            }

            $permissionIds = $validIds;
        }

        $result = $this->rolePermissionModel->syncPermissions(
            (int) $id,
            $permissionIds
        );

        if (!$result) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan pengaturan hak akses.');
        }

        return redirect()->to(
            site_url('roles/permissions/' . $id)
        )->with('success', 'Hak akses berhasil diperbarui.');
    }
}
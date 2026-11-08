<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    /**
     * Data dropdown departemen dan role
     */
    private function getFormData($departmentId = null)
    {
        $builder = db_connect()->table('departments');

        $builder->groupStart()
            ->where('status', 'active');

        if ($departmentId !== null) {
            $builder->orWhere('id', $departmentId);
        }

        $builder->groupEnd();

        $departments = $builder
            ->orderBy('name', 'ASC')
            ->get()
            ->getResultArray();

        return [
            'departments' => $departments,
            'roles' => $this->roleModel
                ->orderBy('name', 'ASC')
                ->findAll()
        ];
    }

    /**
     * Daftar pengguna
     */
    public function index()
    {
        $users = db_connect()->table('users')
            ->select('users.*, departments.name AS department_name, departments.code AS department_code, roles.name AS role_name')
            ->join('departments', 'departments.id = users.department_id', 'left')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->orderBy('users.name', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Master Pengguna',
            'users' => $users
        ];

        return view('users/index', $data);
    }

    /**
     * Form tambah pengguna
     */
    public function create()
    {
        $data = array_merge(
            [
                'title' => 'Tambah Pengguna'
            ],
            $this->getFormData()
        );

        return view('users/create', $data);
    }

    /**
     * Simpan pengguna baru
     */
    public function store()
    {
        $name = trim($this->request->getPost('name') ?? '');
        $email = strtolower(trim($this->request->getPost('email') ?? ''));
        $departmentId = (int) $this->request->getPost('department_id');
        $roleId = (int) $this->request->getPost('role_id');
        $password = $this->request->getPost('password') ?? '';
        $confirmPassword = $this->request->getPost('password_confirm') ?? '';

        $errors = [];

        if ($name === '' || mb_strlen($name) > 150) {
            $errors['name'] = 'Nama wajib diisi dan maksimal 150 karakter.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) {
            $errors['email'] = 'Format email tidak valid.';
        } elseif ($this->userModel->where('email', $email)->countAllResults() > 0) {
            $errors['email'] = 'Email sudah digunakan.';
        }

        if ($password === '' || strlen($password) < 8) {
            $errors['password'] = 'Password minimal 8 karakter.';
        } elseif ($password !== $confirmPassword) {
            $errors['password_confirm'] = 'Konfirmasi password tidak sama.';
        }

        $department = db_connect()->table('departments')
            ->where('id', $departmentId)
            ->where('status', 'active')
            ->get()
            ->getRowArray();

        if (!$department) {
            $errors['department_id'] = 'Departemen tidak valid atau tidak aktif.';
        }

        if (!$this->roleModel->find($roleId)) {
            $errors['role_id'] = 'Role tidak valid.';
        }

        if (!empty($errors)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $errors);
        }

        $this->userModel->insert([
            'name'          => $name,
            'email'         => $email,
            'department_id' => $departmentId,
            'role_id'       => $roleId,
            'password'      => password_hash($password, PASSWORD_DEFAULT),
            'status'        => 'active'
        ]);

        return redirect()->to(site_url('users'))
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Form edit pengguna
     */
    public function edit($id = null)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to(site_url('users'))
                ->with('error', 'Pengguna tidak ditemukan.');
        }

        $data = array_merge(
            [
                'title' => 'Edit Pengguna',
                'user'  => $user
            ],
            $this->getFormData($user['department_id'])
        );

        return view('users/edit', $data);
    }

    /**
     * Update pengguna
     */
    public function update($id = null)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to(site_url('users'))
                ->with('error', 'Pengguna tidak ditemukan.');
        }

        $name = trim($this->request->getPost('name') ?? '');
        $email = strtolower(trim($this->request->getPost('email') ?? ''));
        $departmentId = (int) $this->request->getPost('department_id');
        $roleId = (int) $this->request->getPost('role_id');
        $password = $this->request->getPost('password') ?? '';
        $confirmPassword = $this->request->getPost('password_confirm') ?? '';

        $errors = [];

        if ($name === '' || mb_strlen($name) > 150) {
            $errors['name'] = 'Nama wajib diisi dan maksimal 150 karakter.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) {
            $errors['email'] = 'Format email tidak valid.';
        } else {
            $existingEmail = $this->userModel
                ->where('email', $email)
                ->where('id !=', $id)
                ->countAllResults();

            if ($existingEmail > 0) {
                $errors['email'] = 'Email sudah digunakan pengguna lain.';
            }
        }

        if ($password !== '') {
            if (strlen($password) < 8) {
                $errors['password'] = 'Password minimal 8 karakter.';
            } elseif ($password !== $confirmPassword) {
                $errors['password_confirm'] = 'Konfirmasi password tidak sama.';
            }
        }

        $department = db_connect()->table('departments')
            ->where('id', $departmentId)
            ->get()
            ->getRowArray();

        if (!$department) {
            $errors['department_id'] = 'Departemen tidak valid.';
        } elseif (
            $department['status'] !== 'active' &&
            (int) $departmentId !== (int) $user['department_id']
        ) {
            $errors['department_id'] = 'Departemen tidak aktif.';
        }

        if (!$this->roleModel->find($roleId)) {
            $errors['role_id'] = 'Role tidak valid.';
        }

        if (!empty($errors)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $errors);
        }

        $updateData = [
            'name'          => $name,
            'email'         => $email,
            'department_id' => $departmentId,
            'role_id'       => $roleId
        ];

        // Password hanya diperbarui jika diisi
        if ($password !== '') {
            $updateData['password'] = password_hash(
                $password,
                PASSWORD_DEFAULT
            );
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to(site_url('users'))
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Mengaktifkan / menonaktifkan pengguna
     */
    public function toggleStatus($id = null)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to(site_url('users'))
                ->with('error', 'Pengguna tidak ditemukan.');
        }

        $newStatus = $user['status'] === 'active'
            ? 'inactive'
            : 'active';

        $this->userModel->update($id, [
            'status' => $newStatus
        ]);

        $message = $newStatus === 'active'
            ? 'Pengguna berhasil diaktifkan.'
            : 'Pengguna berhasil dinonaktifkan.';

        return redirect()->to(site_url('users'))
            ->with('success', $message);
    }
}
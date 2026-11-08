<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DepartmentModel;

class DepartmentController extends BaseController
{
    protected $departmentModel;

    public function __construct()
    {
        $this->departmentModel = new DepartmentModel();
    }

    /**
     * Menampilkan daftar departemen
     */
    public function index()
    {
        $data = [
            'title'       => 'Master Departemen',
            'activeMenu'  => 'departments',
            'departments' => $this->departmentModel
                ->orderBy('id', 'DESC')
                ->findAll(),
        ];

        return view('departments/index', $data);
    }

    /**
     * Form tambah departemen
     */
    public function create()
    {
        $data = [
            'title'      => 'Tambah Departemen',
            'activeMenu' => 'departments',
        ];

        return view('departments/create', $data);
    }

    /**
     * Simpan departemen baru
     */
    public function store()
    {
        $rules = [
            'code' => [
                'rules'  => 'required|max_length[20]|is_unique[departments.code]',
                'errors' => [
                    'required'   => 'Kode departemen wajib diisi.',
                    'max_length' => 'Kode maksimal 20 karakter.',
                    'is_unique'  => 'Kode departemen sudah digunakan.',
                ],
            ],
            'name' => [
                'rules'  => 'required|max_length[100]',
                'errors' => [
                    'required'   => 'Nama departemen wajib diisi.',
                    'max_length' => 'Nama maksimal 100 karakter.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->departmentModel->insert([
            'code'   => strtoupper(trim($this->request->getPost('code'))),
            'name'   => trim($this->request->getPost('name')),
            'status' => 'active',
        ]);

        return redirect()->to(site_url('departments'))
            ->with('success', 'Departemen berhasil ditambahkan.');
    }

    /**
     * Form edit departemen
     */
    public function edit($id)
    {
        $department = $this->departmentModel->find($id);

        if (!$department) {
            return redirect()->to(site_url('departments'))
                ->with('error', 'Departemen tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Departemen',
            'activeMenu' => 'departments',
            'department' => $department,
        ];

        return view('departments/edit', $data);
    }

    /**
     * Update departemen
     */
    public function update($id)
    {
        $department = $this->departmentModel->find($id);

        if (!$department) {
            return redirect()->to(site_url('departments'))
                ->with('error', 'Departemen tidak ditemukan.');
        }

        $rules = [
            'code' => [
                'rules'  => "required|max_length[20]|is_unique[departments.code,id,{$id}]",
                'errors' => [
                    'required'  => 'Kode departemen wajib diisi.',
                    'is_unique' => 'Kode departemen sudah digunakan.',
                ],
            ],
            'name' => [
                'rules'  => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Nama departemen wajib diisi.',
                ],

            'status' => [
                  'rules' => 'required|in_list[active,inactive]',
                 'errors' => [
                    'required' => 'Status wajib dipilih.',
                    'in_list'  => 'Status tidak valid.',
    ],
],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->departmentModel->update($id, [
            'code' => strtoupper(trim($this->request->getPost('code'))),
            'name' => trim($this->request->getPost('name')),
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->to(site_url('departments'))
            ->with('success', 'Departemen berhasil diperbarui.');
    }

    /**
     * Hapus departemen
     */
    public function delete($id)
    {
        $department = $this->departmentModel->find($id);

        if (!$department) {
            return redirect()->to(site_url('departments'))
                ->with('error', 'Departemen tidak ditemukan.');
        }

        // Cek apakah departemen masih digunakan oleh user
        // Aktifkan jika relasi users.department_id sudah tersedia.

        $this->departmentModel->delete($id);

        return redirect()->to(site_url('departments'))
            ->with('success', 'Departemen berhasil dihapus.');
    }
}
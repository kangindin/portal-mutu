<?php

namespace App\Controllers;

class AuthController extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        helper(['form', 'url']);

        return view('auth/login');
    }

    public function attempt()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/login')
                ->withInput()
                ->with('error', 'Email atau password tidak valid.');
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $db = \Config\Database::connect();

        $user = $db->table('users u')
            ->select('
                u.id,
                u.name,
                u.email,
                u.password,
                u.role_id,
                u.department_id,
                r.name AS role_name,
                r.slug AS role_slug,
                d.name AS department_name
            ')
            ->join('roles r', 'r.id = u.role_id')
            ->join('departments d', 'd.id = u.department_id', 'left')
            ->where('u.email', $email)
            ->where('u.status', 'active')
            ->get()
            ->getRowArray();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->to('/login')
                ->withInput()
                ->with('error', 'Email atau password salah.');
        }

        // Regenerasi session untuk keamanan
        session()->regenerate(true);

        // Simpan informasi pengguna
        session()->set([
            'user_id'          => $user['id'],
            'name'             => $user['name'],
            'email'            => $user['email'],
            'role_id'          => $user['role_id'],
            'role_name'        => $user['role_name'],
            'role_slug'        => $user['role_slug'],
            'department_id'    => $user['department_id'],
            'department_name'  => $user['department_name'],
            'isLoggedIn'       => true
        ]);

        // Update waktu login
        $db->table('users')
            ->where('id', $user['id'])
            ->update([
                'last_login' => date('Y-m-d H:i:s')
            ]);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')
            ->with('success', 'Anda berhasil logout.');
    }
}
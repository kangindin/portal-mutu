<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Memiliki akses penuh terhadap seluruh sistem.',
            ],
            [
                'name' => 'Admin Mutu',
                'slug' => 'admin-mutu',
                'description' => 'Mengelola dokumen dan informasi mutu perusahaan.',
            ],
            [
                'name' => 'Koordinator',
                'slug' => 'koordinator',
                'description' => 'Mengelola dan memantau dokumen pada departemennya.',
            ],
            [
                'name' => 'Staff',
                'slug' => 'staff',
                'description' => 'Mengakses dokumen sesuai hak akses yang diberikan.',
            ],
            [
                'name' => 'Management',
                'slug' => 'management',
                'description' => 'Melihat informasi mutu, dashboard, dan laporan manajemen.',
            ],
        ];

        foreach ($roles as $role) {
            $existing = $this->db->table('roles')
                ->where('slug', $role['slug'])
                ->countAllResults();

            if ($existing === 0) {
                $this->db->table('roles')->insert([
                    ...$role,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
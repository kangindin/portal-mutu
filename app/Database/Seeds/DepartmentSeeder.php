<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['code' => 'IT', 'name' => 'Information Technology'],
            ['code' => 'LAB', 'name' => 'Laboratorium'],
            ['code' => 'HRD', 'name' => 'Sumber Daya Manusia'],
            ['code' => 'FIN', 'name' => 'Finance'],
            ['code' => 'MKT', 'name' => 'Marketing'],
            ['code' => 'MGT', 'name' => 'Management'],
            ['code' => 'MUTU', 'name' => 'Mutu'],
            ['code' => 'GA', 'name' => 'Umum'],
        ];

        foreach ($departments as $department) {
            $existing = $this->db->table('departments')
                ->where('code', $department['code'])
                ->countAllResults();

            if ($existing === 0) {
                $this->db->table('departments')->insert([
                    'code' => $department['code'],
                    'name' => $department['name'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
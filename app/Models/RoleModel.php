<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table            = 'roles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'name',
        'slug',
        'description',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[50]',
        'slug' => 'required|min_length[3]|max_length[50]|alpha_dash',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Nama role wajib diisi.',
        ],
        'slug' => [
            'required'   => 'Slug role wajib diisi.',
            'alpha_dash' => 'Slug hanya boleh menggunakan huruf, angka, tanda hubung, dan underscore.',
        ],
    ];
}
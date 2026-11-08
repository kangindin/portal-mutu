<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
    protected $table            = 'permissions';
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
        'name' => 'required|min_length[3]|max_length[100]',
        'slug' => 'required|min_length[3]|max_length[100]|alpha_dash',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Nama permission wajib diisi.',
        ],
        'slug' => [
            'required'   => 'Slug permission wajib diisi.',
            'alpha_dash' => 'Slug hanya boleh menggunakan huruf, angka, tanda hubung, dan underscore.',
        ],
    ];
}
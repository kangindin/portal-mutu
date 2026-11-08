<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
    $errors = session()->getFlashdata('errors') ?? [];
    $old = old('name', $user['name']);
?>

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Pengguna</h4>
            <p class="text-muted mb-0">
                Perbarui informasi dan hak akses pengguna.
            </p>
        </div>

        <a href="<?= site_url('users') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>
    </div>

    <form action="<?= site_url('users/update/' . $user['id']) ?>" method="post">

        <?= csrf_field() ?>

        <div class="row">

            <!-- Form Utama -->
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-person-lines-fill text-primary me-2"></i>
                            Informasi Pengguna
                        </h6>
                    </div>

                    <div class="card-body">

                        <!-- Nama -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                                value="<?= esc($old['name'] ?? $user['name']) ?>"
                                placeholder="Masukkan nama lengkap"
                                required
                            >

                            <?php if (isset($errors['name'])): ?>
                                <div class="invalid-feedback">
                                    <?= esc($errors['name']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Email <span class="text-danger">*</span>
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                value="<?= esc($old['email'] ?? $user['email']) ?>"
                                placeholder="nama@perusahaan.com"
                                required
                            >

                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback">
                                    <?= esc($errors['email']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <hr class="my-4">

                        <h6 class="fw-bold mb-3">Penempatan dan Hak Akses</h6>

                        <!-- Departemen -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Departemen
                            </label>

                            <select
                                name="department_id"
                                class="form-select <?= isset($errors['department_id']) ? 'is-invalid' : '' ?>"
                            >
                                <option value="">-- Pilih Departemen --</option>

                                <?php foreach ($departments as $department): ?>
                                    <option
                                        value="<?= $department['id'] ?>"
                                        <?= (string) ($old['department_id'] ?? $user['department_id']) === (string) $department['id'] ? 'selected' : '' ?>
                                    >
                                        <?= esc($department['code']) ?> -
                                        <?= esc($department['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <?php if (isset($errors['department_id'])): ?>
                                <div class="invalid-feedback">
                                    <?= esc($errors['department_id']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Role -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Role / Peran <span class="text-danger">*</span>
                            </label>

                            <select
                                name="role_id"
                                class="form-select <?= isset($errors['role_id']) ? 'is-invalid' : '' ?>"
                                required
                            >
                                <option value="">-- Pilih Role --</option>

                                <?php foreach ($roles as $role): ?>
                                    <option
                                        value="<?= $role['id'] ?>"
                                        <?= (string) ($old['role_id'] ?? $user['role_id']) === (string) $role['id'] ? 'selected' : '' ?>
                                    >
                                        <?= esc($role['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <?php if (isset($errors['role_id'])): ?>
                                <div class="invalid-feedback">
                                    <?= esc($errors['role_id']) ?>
                                </div>
                            <?php endif; ?>

                            <div class="form-text">
                                Role menentukan hak akses pengguna di Portal Mutu.
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Password -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-shield-lock text-primary me-2"></i>
                            Ubah Password
                        </h6>
                    </div>

                    <div class="card-body">

                        <div class="alert alert-info border-0">
                            <i class="bi bi-info-circle me-2"></i>
                            Kosongkan password jika tidak ingin mengubah password pengguna.
                        </div>

                        <!-- Password Baru -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Password Baru
                            </label>

                            <div class="input-group">
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                                    placeholder="Minimal 8 karakter"
                                >

                                <button
                                    type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="togglePassword('password', this)"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>

                            <?php if (isset($errors['password'])): ?>
                                <div class="text-danger small mt-1">
                                    <?= esc($errors['password']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Konfirmasi Password Baru
                            </label>

                            <div class="input-group">
                                <input
                                    type="password"
                                    name="password_confirm"
                                    id="password_confirm"
                                    class="form-control"
                                    placeholder="Ulangi password baru"
                                >

                                <button
                                    type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="togglePassword('password_confirm', this)"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-end gap-2 mb-4">

                    <a href="<?= site_url('users') ?>" class="btn btn-light border">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan Perubahan
                    </button>

                </div>

            </div>

            <!-- Sidebar Informasi -->
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <h6 class="fw-bold mb-3">
                            Informasi Akun
                        </h6>

                        <div class="mb-3">
                            <small class="text-muted d-block">ID Pengguna</small>
                            <strong>#<?= esc($user['id']) ?></strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Status Akun</small>

                            <?php if ($user['status'] === 'active'): ?>
                                <span class="badge bg-success-subtle text-success">
                                    Aktif
                                </span>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger">
                                    Nonaktif
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Terdaftar Sejak</small>
                            <strong>
                                <?= !empty($user['created_at'])
                                    ? date('d-m-Y H:i', strtotime($user['created_at']))
                                    : '-' ?>
                            </strong>
                        </div>

                        <div>
                            <small class="text-muted d-block">Login Terakhir</small>
                            <strong>
                                <?= !empty($user['last_login'])
                                    ? date('d-m-Y H:i', strtotime($user['last_login']))
                                    : 'Belum pernah login' ?>
                            </strong>
                        </div>

                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-lightbulb text-warning me-2"></i>
                            Catatan
                        </h6>

                        <ul class="text-muted small ps-3 mb-0">
                            <li class="mb-2">
                                Email digunakan sebagai identitas login.
                            </li>

                            <li class="mb-2">
                                Perubahan role akan memengaruhi hak akses pengguna.
                            </li>

                            <li class="mb-2">
                                Password tidak perlu diisi jika tidak ada perubahan.
                            </li>

                            <li>
                                Password disimpan dalam bentuk hash, bukan teks biasa.
                            </li>
                        </ul>

                    </div>
                </div>

            </div>

        </div>

    </form>

</div>

<script>
    function togglePassword(id, button) {
        const input = document.getElementById(id);
        const icon = button.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirm');

    function validatePassword() {
        if (password.value === '' && passwordConfirm.value === '') {
            passwordConfirm.setCustomValidity('');
            return;
        }

        if (password.value !== passwordConfirm.value) {
            passwordConfirm.setCustomValidity('Konfirmasi password tidak sama.');
        } else {
            passwordConfirm.setCustomValidity('');
        }
    }

    password.addEventListener('input', validatePassword);
    passwordConfirm.addEventListener('input', validatePassword);
</script>

<?= $this->endSection() ?>
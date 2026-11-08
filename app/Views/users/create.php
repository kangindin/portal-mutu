<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">Tambah Pengguna</h4>
            <p class="text-muted mb-0">
                Tambahkan pengguna baru ke dalam Portal Mutu.
            </p>
        </div>

        <a href="<?= site_url('users') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>

    </div>


    <!-- VALIDATION ERRORS -->
    <?php if (session()->getFlashdata('errors')) : ?>

        <div class="alert alert-danger alert-dismissible fade show">

            <strong>Periksa kembali data berikut:</strong>

            <ul class="mb-0 mt-2">

                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>

            </ul>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    <?php endif; ?>


    <div class="row">

        <!-- FORM -->
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-person-plus text-primary me-2"></i>
                        Informasi Pengguna
                    </h6>

                </div>


                <div class="card-body">

                    <form action="<?= site_url('users/store') ?>"
                          method="post">

                        <?= csrf_field() ?>


                        <!-- NAMA -->
                        <div class="mb-3">

                            <label for="name" class="form-label fw-semibold">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="name"
                                   name="name"
                                   value="<?= old('name') ?>"
                                   placeholder="Masukkan nama lengkap"
                                   maxlength="150"
                                   required>

                        </div>


                        <!-- EMAIL -->
                        <div class="mb-3">

                            <label for="email" class="form-label fw-semibold">
                                Email <span class="text-danger">*</span>
                            </label>

                            <input type="email"
                                   class="form-control"
                                   id="email"
                                   name="email"
                                   value="<?= old('email') ?>"
                                   placeholder="nama@westerindo.com"
                                   maxlength="150"
                                   required>

                            <div class="form-text">
                                Email digunakan sebagai identitas login pengguna.
                            </div>

                        </div>


                        <div class="row">

                            <!-- DEPARTMENT -->
                            <div class="col-md-6 mb-3">

                                <label for="department_id"
                                       class="form-label fw-semibold">

                                    Departemen <span class="text-danger">*</span>

                                </label>

                                <select class="form-select"
                                        id="department_id"
                                        name="department_id"
                                        required>

                                    <option value="">
                                        Pilih Departemen
                                    </option>

                                    <?php foreach ($departments as $department) : ?>

                                        <option value="<?= esc($department['id']) ?>"
                                            <?= old('department_id') == $department['id'] ? 'selected' : '' ?>>

                                            <?= esc($department['name']) ?>
                                            (<?= esc($department['code']) ?>)

                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>


                            <!-- ROLE -->
                            <div class="col-md-6 mb-3">

                                <label for="role_id"
                                       class="form-label fw-semibold">

                                    Role <span class="text-danger">*</span>

                                </label>

                                <select class="form-select"
                                        id="role_id"
                                        name="role_id"
                                        required>

                                    <option value="">
                                        Pilih Role
                                    </option>

                                    <?php foreach ($roles as $role) : ?>

                                        <option value="<?= esc($role['id']) ?>"
                                            <?= old('role_id') == $role['id'] ? 'selected' : '' ?>>

                                            <?= esc($role['name']) ?>

                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                        </div>


                        <hr class="my-4">


                        <!-- PASSWORD SECTION -->
                        <div class="mb-3">

                            <h6 class="fw-bold mb-1">
                                <i class="bi bi-shield-lock text-primary me-2"></i>
                                Keamanan Akun
                            </h6>

                            <small class="text-muted">
                                Tentukan password awal untuk pengguna.
                            </small>

                        </div>


                        <div class="row">

                            <!-- PASSWORD -->
                            <div class="col-md-6 mb-3">

                                <label for="password"
                                       class="form-label fw-semibold">

                                    Password <span class="text-danger">*</span>

                                </label>

                                <div class="input-group">

                                    <input type="password"
                                           class="form-control"
                                           id="password"
                                           name="password"
                                           minlength="8"
                                           required>

                                    <button class="btn btn-outline-secondary"
                                            type="button"
                                            onclick="togglePassword('password', this)">

                                        <i class="bi bi-eye"></i>

                                    </button>

                                </div>

                                <div class="form-text">
                                    Minimal 8 karakter.
                                </div>

                            </div>


                            <!-- CONFIRM PASSWORD -->
                            <div class="col-md-6 mb-3">

                                <label for="password_confirm"
                                       class="form-label fw-semibold">

                                    Konfirmasi Password <span class="text-danger">*</span>

                                </label>

                                <div class="input-group">

                                    <input type="password"
                                           class="form-control"
                                           id="password_confirm"
                                           name="password_confirm"
                                           minlength="8"
                                           required>

                                    <button class="btn btn-outline-secondary"
                                            type="button"
                                            onclick="togglePassword('password_confirm', this)">

                                        <i class="bi bi-eye"></i>

                                    </button>

                                </div>

                                <div id="passwordMessage"
                                     class="form-text">

                                </div>

                            </div>

                        </div>


                        <!-- ACTION -->
                        <div class="d-flex justify-content-end gap-2 mt-4">

                            <a href="<?= site_url('users') ?>"
                               class="btn btn-light border">

                                Batal

                            </a>

                            <button type="submit"
                                    class="btn btn-primary">

                                <i class="bi bi-save me-1"></i>
                                Simpan Pengguna

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>


        <!-- INFORMATION -->
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm mb-3">

                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">

                        <div class="rounded-3 bg-info bg-opacity-10 p-3 me-3">

                            <i class="bi bi-info-circle text-info fs-4"></i>

                        </div>

                        <h6 class="fw-bold mb-0">
                            Informasi Pengguna
                        </h6>

                    </div>


                    <p class="text-muted small">
                        Setiap pengguna memiliki akun tersendiri
                        untuk mengakses Portal Mutu sesuai dengan
                        role dan departemen yang ditentukan.
                    </p>

                    <hr>


                    <div class="small">

                        <div class="fw-semibold mb-2">
                            Ketentuan Akun
                        </div>

                        <ul class="text-muted ps-3 mb-0">

                            <li>Email harus unik.</li>

                            <li>Satu pengguna memiliki satu role.</li>

                            <li>Pengguna terhubung dengan departemen.</li>

                            <li>Password minimal 8 karakter.</li>

                            <li>Password disimpan dalam bentuk hash.</li>

                        </ul>

                    </div>

                </div>

            </div>


            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex align-items-center mb-2">

                        <i class="bi bi-shield-check text-success fs-4 me-2"></i>

                        <h6 class="fw-bold mb-0">
                            Keamanan Sistem
                        </h6>

                    </div>

                    <p class="text-muted small mb-0">
                        Password pengguna akan dienkripsi menggunakan
                        password_hash() sebelum disimpan ke database.
                        Password asli tidak disimpan dalam database.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

// =====================================
// SHOW / HIDE PASSWORD
// =====================================

function togglePassword(fieldId, button) {

    const input = document.getElementById(fieldId);

    if (input.type === 'password') {

        input.type = 'text';

        button.innerHTML = '<i class="bi bi-eye-slash"></i>';

    } else {

        input.type = 'password';

        button.innerHTML = '<i class="bi bi-eye"></i>';

    }

}


// =====================================
// VALIDASI KONFIRMASI PASSWORD
// =====================================

const password = document.getElementById('password');

const confirmPassword = document.getElementById('password_confirm');

const passwordMessage = document.getElementById('passwordMessage');


function validatePassword() {

    if (confirmPassword.value === '') {

        passwordMessage.textContent = '';

        confirmPassword.setCustomValidity('');

        return;

    }

    if (password.value !== confirmPassword.value) {

        passwordMessage.textContent = 'Password tidak sama.';

        passwordMessage.className = 'form-text text-danger';

        confirmPassword.setCustomValidity('Password tidak sama.');

    } else {

        passwordMessage.textContent = 'Password sudah sesuai.';

        passwordMessage.className = 'form-text text-success';

        confirmPassword.setCustomValidity('');

    }

}


password.addEventListener('input', validatePassword);

confirmPassword.addEventListener('input', validatePassword);

</script>

<?= $this->endSection() ?>
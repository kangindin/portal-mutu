<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">Pengaturan Hak Akses</h4>
            <p class="text-muted mb-0">
                Atur kewenangan untuk role <?= esc($role['name']) ?>.
            </p>
        </div>

        <a href="<?= site_url('roles') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>

    </div>


    <!-- Role Information -->
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex align-items-center">

                <div class="rounded-3 bg-primary bg-opacity-10 p-3 me-3">
                    <i class="bi bi-shield-lock text-primary fs-3"></i>
                </div>

                <div>
                    <h5 class="fw-bold mb-1">
                        <?= esc($role['name']) ?>
                    </h5>

                    <span class="badge bg-primary bg-opacity-10 text-primary">
                        <?= esc($role['slug']) ?>
                    </span>
                </div>

            </div>

        </div>

    </div>

    <!-- Permission Form -->
    <form action="<?= site_url('roles/permissions/' . $role['id']) ?>"
          method="post">

        <?= csrf_field() ?>

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-list-check text-primary me-2"></i>
                        Daftar Hak Akses
                    </h6>

                    <div>
                        <button type="button"
                                class="btn btn-sm btn-outline-primary"
                                onclick="toggleAll(true)">
                            Pilih Semua
                        </button>

                        <button type="button"
                                class="btn btn-sm btn-outline-secondary"
                                onclick="toggleAll(false)">
                            Hapus Pilihan
                        </button>
                    </div>

                </div>

            </div>


            <div class="card-body">

                <?php if (!empty($permissionGroups)) : ?>

                    <?php foreach ($permissionGroups as $module => $permissions) : ?>

                        <div class="mb-4">

                            <div class="bg-light rounded px-3 py-2 mb-3">

                                <h6 class="fw-bold text-primary mb-0 text-uppercase">
                                    <i class="bi bi-folder2-open me-2"></i>
                                    <?= esc($module) ?>
                                </h6>

                            </div>


                            <div class="row g-3">

                                <?php foreach ($permissions as $permission) : ?>

                                    <div class="col-md-6 col-lg-4">

                                        <label class="border rounded p-3 d-flex align-items-start gap-2 h-100">

                                            <input
                                                type="checkbox"
                                                class="form-check-input permission-checkbox mt-1"
                                                name="permissions[]"
                                                value="<?= esc($permission['id']) ?>"
                                                <?= in_array(
                                                    $permission['id'],
                                                    $selectedPermissions
                                                ) ? 'checked' : '' ?>
                                            >

                                            <span>

                                                <span class="fw-semibold d-block">
                                                    <?= esc($permission['name']) ?>
                                                </span>

                                                <small class="text-muted">
                                                    <?= esc($permission['slug']) ?>
                                                </small>

                                                <?php if (!empty($permission['description'])) : ?>
                                                    <small class="text-muted d-block mt-1">
                                                        <?= esc($permission['description']) ?>
                                                    </small>
                                                <?php endif; ?>

                                            </span>

                                        </label>

                                    </div>

                                <?php endforeach; ?>

                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php else : ?>

                    <div class="text-center py-5">

                        <i class="bi bi-shield-x fs-1 text-muted"></i>

                        <h6 class="mt-3">Belum Ada Hak Akses</h6>

                        <p class="text-muted mb-0">
                            Silakan tambahkan data permission terlebih dahulu.
                        </p>

                    </div>

                <?php endif; ?>

            </div>


            <div class="card-footer bg-white py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <small class="text-muted">
                        Hak akses akan berlaku untuk seluruh pengguna
                        dengan role ini.
                    </small>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan Hak Akses
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>


<script>
    function toggleAll(status) {

        document.querySelectorAll('.permission-checkbox')
            .forEach(function (checkbox) {
                checkbox.checked = status;
            });

    }
</script>

<?= $this->endSection() ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Master Role</h4>
            <p class="text-muted mb-0">
                Kelola role dan hak akses pengguna Portal Mutu.
            </p>
        </div>

        <a href="<?= site_url('roles/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Tambah Role
        </a>
    </div>

    <!-- Role Summary -->
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-3 bg-primary bg-opacity-10 p-3 me-3">
                        <i class="bi bi-shield-lock text-primary fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Role</div>
                        <h4 class="fw-bold mb-0">
                            <?= count($roles) ?>
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-3 bg-info bg-opacity-10 p-3 me-3">
                        <i class="bi bi-info-circle text-info fs-3"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">Informasi Role</div>
                        <small class="text-muted">
                            Setiap role memiliki hak akses yang dapat
                            disesuaikan berdasarkan kebutuhan operasional.
                        </small>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Role Table -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-shield-check me-2 text-primary"></i>
                    Daftar Role
                </h6>

                <span class="badge bg-light text-dark border">
                    <?= count($roles) ?> Role
                </span>
            </div>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th width="60" class="text-center">No</th>
                            <th>Nama Role</th>
                            <th>Slug</th>
                            <th>Deskripsi</th>
                            <th width="220" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (!empty($roles)) : ?>

                            <?php $no = 1; ?>

                            <?php foreach ($roles as $role) : ?>

                                <tr>

                                    <td class="text-center">
                                        <?= $no++ ?>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">
                                            <?= esc($role['name']) ?>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            <?= esc($role['slug']) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span class="text-muted small">
                                            <?= esc($role['description'] ?: '-') ?>
                                        </span>
                                    </td>

                                    <td class="text-center">

                                        <div class="btn-group btn-group-sm">

                                            <a href="<?= site_url('roles/permissions/' . $role['id']) ?>"
                                               class="btn btn-outline-info"
                                               title="Pengaturan Hak Akses">
                                                <i class="bi bi-shield-check"></i>
                                            </a>

                                            <a href="<?= site_url('roles/edit/' . $role['id']) ?>"
                                               class="btn btn-outline-primary"
                                               title="Edit Role">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <button type="button"
                                                    class="btn btn-outline-danger"
                                                    title="Hapus Role"
                                                    onclick="confirmDelete(
                                                        <?= $role['id'] ?>,
                                                        '<?= esc($role['name'], 'js') ?>'
                                                    )">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </div>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else : ?>

                            <tr>
                                <td colspan="5" class="text-center py-5">

                                    <i class="bi bi-shield-x fs-1 text-muted"></i>

                                    <p class="text-muted mt-2 mb-0">
                                        Belum ada data role.
                                    </p>

                                    <a href="<?= site_url('roles/create') ?>"
                                       class="btn btn-sm btn-primary mt-3">
                                        Tambah Role Pertama
                                    </a>

                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteRoleModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    Konfirmasi Hapus Role
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <p class="mb-0">
                    Apakah Anda yakin ingin menghapus role
                    <strong id="roleName"></strong>?
                </p>

                <small class="text-danger">
                    Tindakan ini tidak dapat dibatalkan.
                </small>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">
                    Batal
                </button>

                <form id="deleteRoleForm" method="post">

                    <?= csrf_field() ?>

                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Ya, Hapus
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


<script>
    function confirmDelete(id, name) {

        document.getElementById('roleName').textContent = name;

        document.getElementById('deleteRoleForm').action =
            "<?= site_url('roles/delete') ?>/" + id;

        const modal = new bootstrap.Modal(
            document.getElementById('deleteRoleModal')
        );

        modal.show();
    }
</script>

<?= $this->endSection() ?>
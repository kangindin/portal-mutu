<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">

    <div class="card-body p-4">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div>
                <h5 class="fw-bold mb-1">Daftar Departemen</h5>
                <small class="text-muted">
                    Kelola data departemen Westerindo.
                </small>
            </div>

            <a href="<?= site_url('departments/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                Tambah Departemen
            </a>

        </div>


        <!-- SEARCH -->
        <div class="row mb-3">

            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>

                    <input type="text"
                           id="searchDepartment"
                           class="form-control"
                           placeholder="Cari departemen...">
                </div>
            </div>

        </div>


        <!-- TABLE -->
        <div class="table-responsive">

            <table class="table table-hover align-middle" id="departmentTable">

                <thead class="table-light">

                    <tr>
                        <th width="60">No</th>
                        <th width="150">Kode</th>
                        <th>Nama Departemen</th>
                        <th width="120">Status</th>
                        <th width="130" class="text-center">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if (!empty($departments)): ?>

                        <?php $no = 1; ?>

                        <?php foreach ($departments as $department): ?>

                            <tr>

                                <td><?= $no++ ?></td>

                                <td>
                                    <span class="badge bg-light text-primary border">
                                        <?= esc($department['code']) ?>
                                    </span>
                                </td>

                                <td class="fw-semibold">
                                    <?= esc($department['name']) ?>
                                </td>

                                <td>

                                    <?php if ($department['status'] === 'active'): ?>

                                        <span class="badge bg-success-subtle text-success">
                                            Aktif
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-secondary-subtle text-secondary">
                                            Nonaktif
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td class="text-center">

                                    <a href="<?= site_url('departments/edit/' . $department['id']) ?>"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Edit">

                                        <i class="bi bi-pencil-square"></i>

                                    </a>

                                    <form action="<?= site_url('departments/delete/' . $department['id']) ?>"
                                          method="post"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus departemen ini?')">

                                        <?= csrf_field() ?>

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Hapus">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Belum ada data departemen.
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>


        <!-- FOOTER -->
        <div class="text-muted small mt-3">
            Total departemen: <?= count($departments) ?> data
        </div>

    </div>

</div>


<?= $this->endSection() ?>


<?= $this->section('scripts') ?>

<script>
    document.getElementById('searchDepartment').addEventListener('keyup', function () {

        let keyword = this.value.toLowerCase();

        document.querySelectorAll('#departmentTable tbody tr').forEach(function (row) {

            row.style.display = row.innerText.toLowerCase().includes(keyword)
                ? ''
                : 'none';

        });

    });
</script>

<?= $this->endSection() ?>
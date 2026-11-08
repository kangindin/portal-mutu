<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$totalUsers = count($users);

$activeUsers = count(array_filter($users, function ($user) {
    return $user['status'] === 'active';
}));

$inactiveUsers = $totalUsers - $activeUsers;
?>

<div class="container-fluid">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">Master Pengguna</h4>
            <p class="text-muted mb-0">
                Kelola pengguna dan hak akses Portal Mutu Westerindo.
            </p>
        </div>

        <a href="<?= site_url('users/create') ?>" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i>
            Tambah Pengguna
        </a>

    </div>


    <!-- SUMMARY CARDS -->
    <div class="row g-3 mb-4">

        <!-- Total -->
        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="rounded-3 bg-primary bg-opacity-10 p-3 me-3">
                        <i class="bi bi-people text-primary fs-3"></i>
                    </div>

                    <div>
                        <div class="text-muted small">Total Pengguna</div>
                        <h4 class="fw-bold mb-0">
                            <?= $totalUsers ?>
                        </h4>
                    </div>

                </div>

            </div>

        </div>


        <!-- Active -->
        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="rounded-3 bg-success bg-opacity-10 p-3 me-3">
                        <i class="bi bi-person-check text-success fs-3"></i>
                    </div>

                    <div>
                        <div class="text-muted small">Pengguna Aktif</div>
                        <h4 class="fw-bold mb-0">
                            <?= $activeUsers ?>
                        </h4>
                    </div>

                </div>

            </div>

        </div>


        <!-- Inactive -->
        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="rounded-3 bg-danger bg-opacity-10 p-3 me-3">
                        <i class="bi bi-person-x text-danger fs-3"></i>
                    </div>

                    <div>
                        <div class="text-muted small">Pengguna Nonaktif</div>
                        <h4 class="fw-bold mb-0">
                            <?= $inactiveUsers ?>
                        </h4>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- USER TABLE -->
    <div class="card border-0 shadow-sm">

        <!-- CARD HEADER -->
        <div class="card-header bg-white py-3">

            <div class="d-flex justify-content-between align-items-center">

                <h6 class="fw-bold mb-0">
                    <i class="bi bi-people text-primary me-2"></i>
                    Daftar Pengguna
                </h6>

                <span class="badge bg-light text-dark border">
                    <?= $totalUsers ?> Pengguna
                </span>

            </div>

        </div>


        <!-- FILTER -->
        <div class="card-body border-bottom">

            <div class="row g-2">

                <div class="col-md-5">

                    <div class="input-group">

                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>

                        <input type="text"
                               id="searchUser"
                               class="form-control"
                               placeholder="Cari nama atau email...">

                    </div>

                </div>


                <div class="col-md-3">

                    <select id="filterDepartment" class="form-select">

                        <option value="">Semua Departemen</option>

                        <?php
                        $departmentList = [];

                        foreach ($users as $user) {
                            if (!empty($user['department_name'])) {
                                $departmentList[$user['department_name']] =
                                    $user['department_name'];
                            }
                        }

                        asort($departmentList);
                        ?>

                        <?php foreach ($departmentList as $department) : ?>

                            <option value="<?= esc($department) ?>">
                                <?= esc($department) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <div class="col-md-2">

                    <select id="filterStatus" class="form-select">

                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Nonaktif</option>

                    </select>

                </div>


                <div class="col-md-2">

                    <button type="button"
                            onclick="resetFilter()"
                            class="btn btn-outline-secondary w-100">

                        <i class="bi bi-arrow-counterclockwise me-1"></i>
                        Reset

                    </button>

                </div>

            </div>

        </div>


        <!-- TABLE -->
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0"
                       id="userTable">

                    <thead class="table-light">

                        <tr>
                            <th width="55" class="text-center">No</th>
                            <th>Pengguna</th>
                            <th>Departemen</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th width="130" class="text-center">Aksi</th>
                        </tr>

                    </thead>


                    <tbody>

                        <?php if (!empty($users)) : ?>

                            <?php $no = 1; ?>

                            <?php foreach ($users as $user) : ?>

                                <tr class="user-row"
                                    data-name="<?= esc(strtolower($user['name']), 'attr') ?>"
                                    data-email="<?= esc(strtolower($user['email']), 'attr') ?>"
                                    data-department="<?= esc($user['department_name'] ?? '', 'attr') ?>"
                                    data-status="<?= esc($user['status'], 'attr') ?>">

                                    <td class="text-center">
                                        <?= $no++ ?>
                                    </td>


                                    <!-- USER -->
                                    <td>

                                        <div class="fw-semibold">
                                            <?= esc($user['name']) ?>
                                        </div>

                                        <small class="text-muted">
                                            <i class="bi bi-envelope me-1"></i>
                                            <?= esc($user['email']) ?>
                                        </small>

                                    </td>


                                    <!-- DEPARTMENT -->
                                    <td>

                                        <?php if (!empty($user['department_name'])) : ?>

                                            <div class="fw-semibold">
                                                <?= esc($user['department_name']) ?>
                                            </div>

                                            <small class="text-muted">
                                                <?= esc($user['department_code']) ?>
                                            </small>

                                        <?php else : ?>

                                            <span class="text-muted">-</span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- ROLE -->
                                    <td>

                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            <?= esc($user['role_name'] ?? 'Belum ada role') ?>
                                        </span>

                                    </td>


                                    <!-- STATUS -->
                                    <td>

                                        <?php if ($user['status'] === 'active') : ?>

                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Aktif
                                            </span>

                                        <?php else : ?>

                                            <span class="badge bg-danger bg-opacity-10 text-danger">
                                                <i class="bi bi-x-circle me-1"></i>
                                                Nonaktif
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- ACTION -->
                                    <td class="text-center">

                                        <div class="btn-group btn-group-sm">

                                            <!-- EDIT -->
                                            <a href="<?= site_url('users/edit/' . $user['id']) ?>"
                                               class="btn btn-outline-primary"
                                               title="Edit Pengguna">

                                                <i class="bi bi-pencil-square"></i>

                                            </a>


                                            <!-- TOGGLE STATUS -->
                                            <button type="button"
                                                    class="btn btn-outline-<?= $user['status'] === 'active' ? 'danger' : 'success' ?>"
                                                    title="<?= $user['status'] === 'active' ? 'Nonaktifkan' : 'Aktifkan' ?> Pengguna"
                                                    onclick="confirmStatus(
                                                        <?= $user['id'] ?>,
                                                        '<?= esc($user['name'], 'js') ?>',
                                                        '<?= esc($user['status'], 'js') ?>'
                                                    )">

                                                <i class="bi bi-<?= $user['status'] === 'active' ? 'person-x' : 'person-check' ?>"></i>

                                            </button>

                                        </div>

                                    </td>

                                </tr>

                            <?php endforeach; ?>


                            <!-- EMPTY FILTER RESULT -->
                            <tr id="emptyFilter" style="display:none">

                                <td colspan="6" class="text-center py-5">

                                    <i class="bi bi-search fs-1 text-muted"></i>

                                    <p class="text-muted mt-2 mb-0">
                                        Pengguna tidak ditemukan.
                                    </p>

                                </td>

                            </tr>


                        <?php else : ?>

                            <tr>

                                <td colspan="6" class="text-center py-5">

                                    <i class="bi bi-people fs-1 text-muted"></i>

                                    <h6 class="mt-3">
                                        Belum Ada Pengguna
                                    </h6>

                                    <p class="text-muted mb-3">
                                        Silakan tambahkan pengguna pertama.
                                    </p>

                                    <a href="<?= site_url('users/create') ?>"
                                       class="btn btn-primary btn-sm">

                                        <i class="bi bi-person-plus me-1"></i>
                                        Tambah Pengguna

                                    </a>

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>


        <!-- FOOTER -->
        <?php if (!empty($users)) : ?>

            <div class="card-footer bg-white py-3">

                <small class="text-muted" id="userCount">
                    Menampilkan <?= $totalUsers ?> pengguna.
                </small>

            </div>

        <?php endif; ?>

    </div>

</div>


<!-- STATUS CONFIRMATION MODAL -->
<div class="modal fade" id="statusModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">
                    Konfirmasi Status Pengguna
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">

                <p id="statusMessage" class="mb-0"></p>

            </div>


            <div class="modal-footer">

                <button type="button"
                        class="btn btn-light border"
                        data-bs-dismiss="modal">

                    Batal

                </button>


                <form id="statusForm" method="post">

                    <?= csrf_field() ?>

                    <button type="submit"
                            id="statusSubmit"
                            class="btn">

                        Konfirmasi

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


<script>

// =====================================
// SEARCH DAN FILTER PENGGUNA
// =====================================

function filterUsers() {

    const search = document.getElementById('searchUser')
        .value.toLowerCase();

    const department = document.getElementById('filterDepartment')
        .value.toLowerCase();

    const status = document.getElementById('filterStatus')
        .value.toLowerCase();

    const rows = document.querySelectorAll('.user-row');

    let visible = 0;

    rows.forEach(function(row) {

        const name = row.dataset.name;
        const email = row.dataset.email;
        const dept = row.dataset.department.toLowerCase();
        const userStatus = row.dataset.status;

        const matchSearch =
            name.includes(search) ||
            email.includes(search);

        const matchDepartment =
            department === '' || dept === department;

        const matchStatus =
            status === '' || userStatus === status;

        const show =
            matchSearch &&
            matchDepartment &&
            matchStatus;

        row.style.display = show ? '' : 'none';

        if (show) {
            visible++;
        }

    });

    const emptyFilter = document.getElementById('emptyFilter');

    if (emptyFilter) {
        emptyFilter.style.display =
            visible === 0 ? '' : 'none';
    }

    const count = document.getElementById('userCount');

    if (count) {
        count.textContent =
            'Menampilkan ' + visible + ' dari ' +
            rows.length + ' pengguna.';
    }

}


// Event Listener
document.getElementById('searchUser')
    .addEventListener('input', filterUsers);

document.getElementById('filterDepartment')
    .addEventListener('change', filterUsers);

document.getElementById('filterStatus')
    .addEventListener('change', filterUsers);


// Reset Filter
function resetFilter() {

    document.getElementById('searchUser').value = '';
    document.getElementById('filterDepartment').value = '';
    document.getElementById('filterStatus').value = '';

    filterUsers();

}


// =====================================
// KONFIRMASI AKTIF / NONAKTIF
// =====================================

function confirmStatus(id, name, currentStatus) {

    const isActive = currentStatus === 'active';

    const message = isActive
        ? 'Apakah Anda yakin ingin menonaktifkan pengguna '
        : 'Apakah Anda yakin ingin mengaktifkan kembali pengguna ';

    document.getElementById('statusMessage').textContent =
        message + name + '?';

    const form = document.getElementById('statusForm');

    form.action =
        "<?= site_url('users/toggle-status') ?>/" + id;

    const button = document.getElementById('statusSubmit');

    button.className = isActive
        ? 'btn btn-danger'
        : 'btn btn-success';

    button.textContent = isActive
        ? 'Ya, Nonaktifkan'
        : 'Ya, Aktifkan';

    const modal = new bootstrap.Modal(
        document.getElementById('statusModal')
    );

    modal.show();

}

</script>

<?= $this->endSection() ?>
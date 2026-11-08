<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row g-4">

    <div class="col-md-4">
        <div class="card p-4">
            <div class="text-muted mb-2">Total Dokumen</div>
            <h3 class="fw-bold">0</h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-4">
            <div class="text-muted mb-2">Departemen</div>
            <h3 class="fw-bold">8</h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-4">
            <div class="text-muted mb-2">Pengguna</div>
            <h3 class="fw-bold">1</h3>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
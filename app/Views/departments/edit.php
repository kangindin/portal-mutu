<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row">

    <div class="col-lg-8 col-xl-7">

        <div class="card">

            <div class="card-body p-4">

                <div class="mb-4">

                    <h5 class="fw-bold mb-1">
                        Edit Departemen
                    </h5>

                    <small class="text-muted">
                        Perbarui informasi departemen.
                    </small>

                </div>


                <!-- VALIDATION ERROR -->
                <?php if (session()->getFlashdata('errors')): ?>

                    <div class="alert alert-danger">

                        <ul class="mb-0">

                            <?php foreach (session()->getFlashdata('errors') as $error): ?>

                                <li><?= esc($error) ?></li>

                            <?php endforeach; ?>

                        </ul>

                    </div>

                <?php endif; ?>


                <form action="<?= site_url('departments/update/' . $department['id']) ?>"
                      method="post">

                    <?= csrf_field() ?>


                    <!-- KODE -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Kode Departemen <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="code"
                               class="form-control text-uppercase"
                               value="<?= old('code', $department['code']) ?>"
                               maxlength="20"
                               required>

                    </div>


                    <!-- NAMA -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Nama Departemen <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               value="<?= old('name', $department['name']) ?>"
                               maxlength="100"
                               required>

                    </div>


                    <!-- STATUS -->
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select name="status" class="form-select">

                            <option value="active"
                                <?= old('status', $department['status']) === 'active' ? 'selected' : '' ?>>
                                Aktif
                            </option>

                            <option value="inactive"
                                <?= old('status', $department['status']) === 'inactive' ? 'selected' : '' ?>>
                                Nonaktif
                            </option>

                        </select>

                    </div>


                    <!-- BUTTON -->
                    <div class="d-flex gap-2">

                        <button type="submit" class="btn btn-primary">

                            <i class="bi bi-save me-1"></i>
                            Simpan Perubahan

                        </button>

                        <a href="<?= site_url('departments') ?>"
                           class="btn btn-light border">

                            Batal

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>
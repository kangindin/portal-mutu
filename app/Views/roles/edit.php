<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">Edit Role</h4>
            <p class="text-muted mb-0">
                Perbarui informasi role Portal Mutu.
            </p>
        </div>

        <a href="<?= site_url('roles') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>

    </div>


    <!-- Validation Errors -->
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

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-pencil-square text-primary me-2"></i>
                        Informasi Role
                    </h6>

                </div>


                <div class="card-body">

                    <form action="<?= site_url('roles/update/' . $role['id']) ?>"
                          method="post">

                        <?= csrf_field() ?>


                        <!-- Nama Role -->
                        <div class="mb-3">

                            <label for="name" class="form-label fw-semibold">
                                Nama Role <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="name"
                                   name="name"
                                   value="<?= old('name', $role['name']) ?>"
                                   maxlength="50"
                                   required>

                            <div class="form-text">
                                Nama role yang ditampilkan pada sistem.
                            </div>

                        </div>


                        <!-- Slug -->
                        <div class="mb-3">

                            <label for="slug" class="form-label fw-semibold">
                                Slug <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="slug"
                                   name="slug"
                                   value="<?= old('slug', $role['slug']) ?>"
                                   maxlength="50"
                                   pattern="[a-z0-9_-]+"
                                   required>

                            <div class="form-text">
                                Identitas unik role. Gunakan huruf kecil,
                                angka, underscore, atau tanda hubung.
                            </div>

                        </div>


                        <!-- Deskripsi -->
                        <div class="mb-4">

                            <label for="description" class="form-label fw-semibold">
                                Deskripsi
                            </label>

                            <textarea class="form-control"
                                      id="description"
                                      name="description"
                                      rows="4"
                                      placeholder="Jelaskan fungsi dan tanggung jawab role..."><?= esc(old('description', $role['description'] ?? '')) ?></textarea>

                        </div>


                        <!-- Action -->
                        <div class="d-flex justify-content-end gap-2">

                            <a href="<?= site_url('roles') ?>"
                               class="btn btn-light border">
                                Batal
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>
                                Simpan Perubahan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>


        <!-- Information Card -->
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">

                        <div class="rounded-3 bg-info bg-opacity-10 p-3 me-3">
                            <i class="bi bi-info-circle text-info fs-4"></i>
                        </div>

                        <h6 class="fw-bold mb-0">
                            Informasi
                        </h6>

                    </div>

                    <p class="text-muted small">
                        Perubahan informasi role tidak otomatis
                        mengubah hak akses yang telah diberikan.
                    </p>

                    <hr>

                    <div class="small text-muted">

                        <div class="mb-2">
                            <strong>ID Role:</strong>
                            <?= esc($role['id']) ?>
                        </div>

                        <div class="mb-2">
                            <strong>Slug:</strong>
                            <?= esc($role['slug']) ?>
                        </div>

                        <div>
                            <strong>Dibuat:</strong>
                            <?= esc($role['created_at'] ?? '-') ?>
                        </div>

                    </div>

                    <hr>

                    <a href="<?= site_url('roles/permissions/' . $role['id']) ?>"
                       class="btn btn-outline-info w-100">

                        <i class="bi bi-shield-check me-1"></i>
                        Atur Hak Akses

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">Tambah Role</h4>
            <p class="text-muted mb-0">
                Tambahkan role baru untuk pengaturan hak akses pengguna.
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
                        <i class="bi bi-shield-plus text-primary me-2"></i>
                        Informasi Role
                    </h6>

                </div>


                <div class="card-body">

                    <form action="<?= site_url('roles/store') ?>"
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
                                   value="<?= old('name') ?>"
                                   placeholder="Contoh: Kepala Departemen"
                                   maxlength="50"
                                   required>

                            <div class="form-text">
                                Nama role yang akan ditampilkan pada sistem.
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
                                   value="<?= old('slug') ?>"
                                   placeholder="Contoh: dept_head"
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
                                      placeholder="Jelaskan fungsi dan tanggung jawab role..."><?= old('description') ?></textarea>

                        </div>


                        <!-- Action -->
                        <div class="d-flex justify-content-end gap-2">

                            <a href="<?= site_url('roles') ?>"
                               class="btn btn-light border">
                                Batal
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>
                                Simpan Role
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
                        Role digunakan untuk mengelompokkan pengguna
                        berdasarkan tanggung jawab dan kewenangan
                        dalam Portal Mutu.
                    </p>

                    <hr>

                    <div class="small">

                        <div class="fw-semibold mb-2">
                            Contoh Role:
                        </div>

                        <ul class="text-muted ps-3 mb-0">
                            <li>Super Administrator</li>
                            <li>Administrator</li>
                            <li>Management</li>
                            <li>Kepala Departemen</li>
                            <li>Staff Departemen</li>
                            <li>Auditor</li>
                            <li>Viewer</li>
                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script>
    // Otomatis membuat slug berdasarkan nama role
    document.getElementById('name').addEventListener('input', function () {

        const slug = this.value
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '_')
            .replace(/[^a-z0-9_-]/g, '');

        document.getElementById('slug').value = slug;

    });
</script>

<?= $this->endSection() ?>
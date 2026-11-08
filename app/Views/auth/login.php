<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Portal Mutu Westerindo</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <style>
        :root {
            --primary: #0877C9;
            --secondary: #0CA6A6;
            --background: #F5F8FC;
            --text: #263445;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: var(--background);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1050px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(20, 60, 100, 0.08);
        }

        .login-brand {
            background: linear-gradient(145deg, #0877C9, #0CA6A6);
            color: white;
            padding: 60px 45px;
            min-height: 570px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand-icon {
            width: 65px;
            height: 65px;
            background: rgba(255,255,255,.18);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }

        .login-form {
            padding: 60px 55px;
        }

        .form-control {
            padding: 13px 15px;
            border-radius: 10px;
            border: 1px solid #DCE4ED;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(8,119,201,.10);
        }

        .btn-login {
            background: var(--primary);
            color: white;
            padding: 13px;
            border-radius: 10px;
            font-weight: 600;
            border: none;
        }

        .btn-login:hover {
            background: #0665AC;
            color: white;
        }

        .text-primary-custom {
            color: var(--primary);
        }

        @media(max-width: 767px) {
            .login-brand {
                min-height: 230px;
                padding: 30px;
            }

            .login-form {
                padding: 35px 25px;
            }
        }
    </style>
</head>

<body>

<div class="container py-4">

    <div class="login-wrapper mx-auto">

        <div class="row g-0">

            <!-- BRANDING -->
            <div class="col-md-5">

                <div class="login-brand">

                    <div>
                        <div class="brand-icon mb-4">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        <h3 class="fw-bold">
                            Portal Mutu
                        </h3>

                        <p class="opacity-75">
                            Westerindo
                        </p>
                    </div>

                    <div>
                        <h4 class="fw-bold mb-3">
                            Sistem Informasi Manajemen Mutu
                        </h4>

                        <p class="opacity-75 mb-0">
                            Satu portal untuk mengelola,
                            mengakses, dan memantau informasi
                            mutu perusahaan secara terintegrasi.
                        </p>
                    </div>

                    <small class="opacity-75">
                        © <?= date('Y') ?> Westerindo
                    </small>

                </div>

            </div>

            <!-- LOGIN FORM -->
            <div class="col-md-7">

                <div class="login-form">

                    <div class="mb-4">

                        <h3 class="fw-bold mb-2">
                            Selamat Datang
                        </h3>

                        <p class="text-secondary">
                            Silakan login menggunakan akun Anda.
                        </p>

                    </div>

                    <!-- NOTIFIKASI ERROR -->
                    <?php if (session()->getFlashdata('error')): ?>

                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            <?= esc(session()->getFlashdata('error')) ?>
                        </div>

                    <?php endif; ?>

                    <!-- NOTIFIKASI SUCCESS -->
                    <?php if (session()->getFlashdata('success')): ?>

                        <div class="alert alert-success">
                            <?= esc(session()->getFlashdata('success')) ?>
                        </div>

                    <?php endif; ?>

                    <form action="<?= site_url('login') ?>" method="POST">

                        <?= csrf_field() ?>

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="nama@westerindo.com"
                                value="<?= esc(old('email')) ?>"
                                autocomplete="username"
                                required
                            >

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Password
                            </label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control"
                                    placeholder="Masukkan password"
                                    autocomplete="current-password"
                                    required
                                >

                                <button
                                    class="btn btn-outline-secondary"
                                    type="button"
                                    onclick="togglePassword()"
                                >
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </button>

                            </div>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-login w-100"
                        >
                            Login
                            <i class="bi bi-arrow-right ms-2"></i>
                        </button>

                    </form>

                    <div class="text-center mt-5">

                        <small class="text-secondary">
                            Portal Mutu Westerindo
                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
    function togglePassword() {

        const password = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');

        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }

    }
</script>

</body>
</html>
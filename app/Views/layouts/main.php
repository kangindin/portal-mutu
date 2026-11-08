<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($title ?? 'Portal Mutu Westerindo') ?></title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #0877c9;
            --primary-dark: #075fa0;
            --secondary: #18b6b0;
            --background: #f4f7fb;
            --sidebar-width: 255px;
            --sidebar-mini: 75px;
            --text-dark: #263445;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--background);
            font-family: Arial, sans-serif;
            color: var(--text-dark);
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--primary);
            color: white;
            padding: 22px 15px;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1050;
            transition: width .25s ease, transform .25s ease;
        }

        .sidebar-brand {
            padding: 0 10px 25px;
            white-space: nowrap;
        }

        .sidebar-brand h5 {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .sidebar-brand small {
            opacity: .75;
        }

        .sidebar-section {
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 1px;
            color: rgba(255,255,255,.6);
            padding: 15px 12px 7px;
            white-space: nowrap;
        }

        .sidebar-menu {
            margin-bottom: 5px;
        }

        .sidebar-menu a,
        .sidebar-menu button {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            color: rgba(255,255,255,.85);
            text-decoration: none;
            padding: 11px 13px;
            margin-bottom: 4px;
            border: none;
            border-radius: 8px;
            background: transparent;
            font-size: 14px;
            text-align: left;
            white-space: nowrap;
            transition: .2s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu button:hover,
        .sidebar-menu a.active,
        .sidebar-menu button.active {
            background: rgba(255,255,255,.18);
            color: white;
        }

        .sidebar-menu i {
            font-size: 18px;
            min-width: 20px;
        }

        .menu-arrow {
            margin-left: auto;
            font-size: 12px !important;
            transition: transform .2s;
        }

        .sidebar-menu button[aria-expanded="true"] .menu-arrow {
            transform: rotate(90deg);
        }

        /* TREE MENU */

        .tree-menu {
            padding-left: 18px;
            margin: 2px 0 8px;
            border-left: 1px solid rgba(255,255,255,.3);
            margin-left: 22px;
        }

        .tree-menu a {
            font-size: 13px;
            padding: 9px 12px;
        }

        .tree-menu a i {
            font-size: 13px;
        }

        .sidebar-divider {
            border-color: rgba(255,255,255,.25);
            margin: 20px 0;
        }

        /* =========================
           MAIN CONTENT
        ========================= */

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 25px 30px;
            min-height: 100vh;
            transition: margin-left .25s ease;
        }

        /* COLLAPSED DESKTOP */

        body.sidebar-collapsed .sidebar {
            width: var(--sidebar-mini);
        }

        body.sidebar-collapsed .main-content {
            margin-left: var(--sidebar-mini);
        }

        body.sidebar-collapsed .sidebar-brand h5 span,
        body.sidebar-collapsed .sidebar-brand small,
        body.sidebar-collapsed .sidebar-section,
        body.sidebar-collapsed .sidebar-menu span,
        body.sidebar-collapsed .menu-arrow,
        body.sidebar-collapsed .tree-menu {
            display: none !important;
        }

        body.sidebar-collapsed .sidebar-menu a,
        body.sidebar-collapsed .sidebar-menu button {
            justify-content: center;
            padding: 12px 5px;
        }

        body.sidebar-collapsed .sidebar-menu i {
            margin: 0;
        }

        body.sidebar-collapsed .sidebar-brand {
            padding-left: 5px;
        }

        body.sidebar-collapsed .sidebar-brand h5 {
            font-size: 0;
        }

        body.sidebar-collapsed .sidebar-brand h5 i {
            font-size: 25px;
        }

        /* =========================
           HEADER
        ========================= */

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .top-header h4 {
            font-weight: bold;
            margin: 0;
            font-size: 21px;
        }

        .toggle-sidebar {
            border: none;
            background: white;
            color: var(--primary);
            width: 40px;
            height: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,.05);
            font-size: 20px;
        }

        .toggle-sidebar:hover {
            background: #eaf5ff;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #d9efff;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .user-name {
            font-weight: bold;
            font-size: 14px;
        }

        .user-role {
            font-size: 12px;
            color: #718096;
        }

        /* =========================
           CARD
        ========================= */

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,.04);
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* MOBILE BACKDROP */

        .sidebar-backdrop {
            display: none;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 768px) {

            .sidebar {
                width: 255px;
                transform: translateX(-100%);
            }

            .sidebar.mobile-show {
                transform: translateX(0);
            }

            .sidebar-backdrop.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.4);
                z-index: 1040;
            }

            .main-content,
            body.sidebar-collapsed .main-content {
                margin-left: 0;
                padding: 20px 15px;
            }

            body.sidebar-collapsed .sidebar {
                width: 255px;
            }

            body.sidebar-collapsed .sidebar-brand h5 span,
            body.sidebar-collapsed .sidebar-brand small,
            body.sidebar-collapsed .sidebar-section,
            body.sidebar-collapsed .sidebar-menu span,
            body.sidebar-collapsed .menu-arrow,
            body.sidebar-collapsed .tree-menu {
                display: initial !important;
            }

            body.sidebar-collapsed .sidebar-brand h5 {
                font-size: inherit;
            }

            body.sidebar-collapsed .sidebar-menu a,
            body.sidebar-collapsed .sidebar-menu button {
                justify-content: flex-start;
                padding: 11px 13px;
            }

            .top-header h4 {
                font-size: 18px;
            }

            .user-role {
                display: none;
            }
        }
    </style>

    <?= $this->renderSection('styles') ?>

</head>

<body>

    <?php
    $activeMenu = $activeMenu ?? 'dashboard';

    $masterMenus = ['departments', 'users', 'roles'];
    $documentMenus = ['documents'];
    $qualityMenus = ['kpi', 'audits'];
    $utilityMenus = ['activity-logs', 'settings'];

    ?>

    <!-- SIDEBAR BACKDROP -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>


    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-brand">
            <h5>
                <i class="bi bi-shield-check me-2"></i>
                <span>PORTAL MUTU</span>
            </h5>
            <small>Westerindo</small>
        </div>


        <div class="sidebar-menu">

            <!-- DASHBOARD -->
            <a href="<?= site_url('dashboard') ?>"
               class="<?= $activeMenu === 'dashboard' ? 'active' : '' ?>">

                <i class="bi bi-grid"></i>
                <span>Dashboard</span>

            </a>


            <!-- MANAJEMEN DOKUMEN -->
            <div class="sidebar-section">
                MANAJEMEN DOKUMEN
            </div>

            <button type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuDocuments"
                    aria-expanded="<?= in_array($activeMenu, $documentMenus) ? 'true' : 'false' ?>">

                <i class="bi bi-folder2-open"></i>
                <span>Dokumen Mutu</span>
                <i class="bi bi-chevron-right menu-arrow"></i>

            </button>

            <div class="collapse <?= in_array($activeMenu, $documentMenus) ? 'show' : '' ?>"
                 id="menuDocuments">

                <div class="tree-menu">

                    <a href="<?= site_url('documents') ?>"
                       class="<?= $activeMenu === 'documents' ? 'active' : '' ?>">

                        <i class="bi bi-file-earmark-text"></i>
                        <span>Daftar Dokumen</span>

                    </a>

                </div>

            </div>


            <!-- MANAJEMEN MUTU -->
            <div class="sidebar-section">
                MANAJEMEN MUTU
            </div>

            <button type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuQuality"
                    aria-expanded="<?= in_array($activeMenu, $qualityMenus) ? 'true' : 'false' ?>">

                <i class="bi bi-clipboard-check"></i>
                <span>Pengendalian Mutu</span>
                <i class="bi bi-chevron-right menu-arrow"></i>

            </button>

            <div class="collapse <?= in_array($activeMenu, $qualityMenus) ? 'show' : '' ?>"
                 id="menuQuality">

                <div class="tree-menu">

                    <a href="<?= site_url('kpi') ?>"
                       class="<?= $activeMenu === 'kpi' ? 'active' : '' ?>">

                        <i class="bi bi-bar-chart"></i>
                        <span>KPI</span>

                    </a>

                    <a href="<?= site_url('audits') ?>"
                       class="<?= $activeMenu === 'audits' ? 'active' : '' ?>">

                        <i class="bi bi-clipboard2-check"></i>
                        <span>Audit Internal</span>

                    </a>

                </div>

            </div>


            <!-- MASTER DATA -->
            <div class="sidebar-section">
                MASTER DATA
            </div>

            <button type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuMaster"
                    aria-expanded="<?= in_array($activeMenu, $masterMenus) ? 'true' : 'false' ?>">

                <i class="bi bi-database"></i>
                <span>Master Data</span>
                <i class="bi bi-chevron-right menu-arrow"></i>

            </button>

            <div class="collapse <?= in_array($activeMenu, $masterMenus) ? 'show' : '' ?>"
                 id="menuMaster">

                <div class="tree-menu">

                    <a href="<?= site_url('departments') ?>"
                       class="<?= $activeMenu === 'departments' ? 'active' : '' ?>">

                        <i class="bi bi-building"></i>
                        <span>Departemen</span>

                    </a>

                    <a href="<?= site_url('users') ?>"
                       class="<?= $activeMenu === 'users' ? 'active' : '' ?>">

                        <i class="bi bi-people"></i>
                        <span>Pengguna</span>

                    </a>

                    <a href="<?= site_url('roles') ?>"
                       class="<?= $activeMenu === 'roles' ? 'active' : '' ?>">

                        <i class="bi bi-shield-lock"></i>
                        <span>Roles & Hak Akses</span>

                    </a>

                </div>

            </div>


            <!-- UTILITY -->
            <div class="sidebar-section">
                UTILITY
            </div>

            <button type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuUtility"
                    aria-expanded="<?= in_array($activeMenu, $utilityMenus) ? 'true' : 'false' ?>">

                <i class="bi bi-gear"></i>
                <span>Utility</span>
                <i class="bi bi-chevron-right menu-arrow"></i>

            </button>

            <div class="collapse <?= in_array($activeMenu, $utilityMenus) ? 'show' : '' ?>"
                 id="menuUtility">

                <div class="tree-menu">

                    <a href="<?= site_url('activity-logs') ?>"
                       class="<?= $activeMenu === 'activity-logs' ? 'active' : '' ?>">

                        <i class="bi bi-clock-history"></i>
                        <span>Log Aktivitas</span>

                    </a>

                    <a href="<?= site_url('settings') ?>"
                       class="<?= $activeMenu === 'settings' ? 'active' : '' ?>">

                        <i class="bi bi-sliders"></i>
                        <span>Pengaturan</span>

                    </a>

                </div>

            </div>

        </div>


        <hr class="sidebar-divider">


        <!-- LOGOUT -->
        <div class="sidebar-menu">

            <form action="<?= site_url('logout') ?>" method="post">

                <?= csrf_field() ?>

                <button type="submit">

                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>

                </button>

            </form>

        </div>

    </aside>


    <!-- MAIN CONTENT -->
    <main class="main-content">


        <!-- HEADER -->
        <div class="top-header">

            <div class="header-left">

                <button class="toggle-sidebar" id="toggleSidebar" type="button">
                    <i class="bi bi-list"></i>
                </button>

                <div>

                    <h4><?= esc($title ?? 'Dashboard') ?></h4>

                    <small class="text-muted">
                        Portal Informasi dan Manajemen Mutu Westerindo
                    </small>

                </div>

            </div>


            <!-- USER INFO -->
            <div class="user-info">

                <div class="user-avatar">
                    <i class="bi bi-person"></i>
                </div>

                <div>

                    <div class="user-name">
                        <?= esc(session()->get('name') ?? 'Pengguna') ?>
                    </div>

                    <div class="user-role">
                        <?= esc(session()->get('role_name') ?? '') ?>
                    </div>

                </div>

            </div>

        </div>


        <!-- FLASH MESSAGE -->
        <?php if ($success = session()->getFlashdata('success')): ?>

            <div class="alert alert-success alert-dismissible fade show">

                <?= esc($success) ?>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"></button>

            </div>

        <?php endif; ?>


        <?php if ($error = session()->getFlashdata('error')): ?>

            <div class="alert alert-danger alert-dismissible fade show">

                <?= esc($error) ?>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"></button>

            </div>

        <?php endif; ?>


        <!-- PAGE CONTENT -->
        <?= $this->renderSection('content') ?>


    </main>


    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- SIDEBAR SCRIPT -->
    <script>

        const sidebar = document.getElementById('sidebar');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');

        toggleSidebar.addEventListener('click', function () {

            if (window.innerWidth <= 768) {

                sidebar.classList.toggle('mobile-show');
                backdrop.classList.toggle('show');

            } else {

                document.body.classList.toggle('sidebar-collapsed');

            }

        });


        backdrop.addEventListener('click', function () {

            sidebar.classList.remove('mobile-show');
            backdrop.classList.remove('show');

        });


        // Tutup sidebar mobile setelah memilih menu
        sidebar.querySelectorAll('a').forEach(function (link) {

            link.addEventListener('click', function () {

                if (window.innerWidth <= 768) {

                    sidebar.classList.remove('mobile-show');
                    backdrop.classList.remove('show');

                }

            });

        });

    </script>


    <?= $this->renderSection('scripts') ?>

</body>
</html>
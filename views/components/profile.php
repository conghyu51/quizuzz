<div class="nav-item dropdown">
    <a href="#!" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-label="Open user menu">
        <span class="avatar avatar-sm" style="background-image: url(/assets/img/flags/vn.svg)"></span>
        <div class="d-none d-xl-block ps-2">
            <div><?= e($_SESSION['user']['username']) ?></div>
            <div class="mt-1 small text-secondary">Điểm: 0</div>
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" data-bs-theme="light">
        <a href="/dang-xuat" class="dropdown-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-logout">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                <path d="M9 12h12l-3 -3" />
                <path d="M18 15l3 -3" />
            </svg>
            Đăng xuất
        </a>
    </div>
</div>

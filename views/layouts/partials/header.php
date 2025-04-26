<div class="page-header d-print-none text-white">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Xin chào<?= isset($_SESSION['user']) ? ', ' . $_SESSION['user']['username'] : '' ?>!</div>
                <h2 class="page-title"><?= e($heading ?? $title) ?></h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <?php if (isset($_SESSION['user'])): ?>
                    <?php if (isset($_GET['quiz']) && $_GET['action'] == 'edit' && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == '/thu-vien-cua-toi'): ?>
                        <div class="btn-list">
                            <a class="btn btn-secondary btn-5 d-sm-none btn-icon" href="/thu-vien-cua-toi">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-back-up">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M9 14l-4 -4l4 -4" />
                                    <path d="M5 10h11a4 4 0 1 1 0 8h-1" />
                                </svg>
                            </a>
                            <a class="btn btn-secondary btn-5 d-none d-sm-inline-block" href="/thu-vien-cua-toi">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-back-up">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M9 14l-4 -4l4 -4" />
                                    <path d="M5 10h11a4 4 0 1 1 0 8h-1" />
                                </svg>
                                Quay lại
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="btn-list">
                            <a href="#!" class="btn btn-primary btn-5 d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-create-new-quiz">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-2">
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Tạo quiz mới
                            </a>
                            <a
                                href="#!"
                                class="btn btn-primary btn-6 d-sm-none btn-icon"
                                data-bs-toggle="modal"
                                data-bs-target="#modal-create-new-quiz"
                                aria-label="Create new report">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-2">
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                            </a>
                        </div>
                    <?php endif ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

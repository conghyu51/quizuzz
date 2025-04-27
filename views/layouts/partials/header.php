<div class="page-header d-print-none text-white">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Xin chào<?= isset($_SESSION['user']) ? ', ' . $_SESSION['user']['username'] : '' ?>!</div>
                <h2 class="page-title"><?= e($heading ?? $title) ?></h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <?php if (isset($_SESSION['user'])): ?>
                    <?php
                    if (
                        isset($_GET['quiz'])
                        && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == '/thu-vien-cua-toi'
                    ): ?>
                        <?php include BASE . '/views/components/back-button.php' ?>
                    <?php elseif (isset($customAction)): ?>
                        <?php include $customAction ?>
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

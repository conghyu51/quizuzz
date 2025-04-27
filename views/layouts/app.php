<!doctype html>
<html lang="vi" data-bs-theme-base="neutral" data-bs-theme-font="comic" data-bs-theme-radius="1.5">

<?php include BASE . '/views/layouts/partials/head.php' ?>

<body>
    <div class="page">
        <?php include BASE . '/views/layouts/partials/navbar.php' ?>
        <div class="page-wrapper">
            <?php include BASE . '/views/layouts/partials/header.php' ?>
            <div class="page-body">
                <?php
                $parsedUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

                $extendContainerClass = ($parsedUri == '/' || $parsedUri == '/thu-vien-cua-toi')
                    && isset($quizzes) && count($quizzes) <= 0
                    ? ' my-auto' : '';
                ?>
                <div class="container-xl<?= $extendContainerClass ?>">
                    <?= $slot ?? null ?>
                </div>
            </div>
            <?php include BASE . '/views/layouts/partials/footer.php' ?>
        </div>
    </div>
    <?php if (isset($_GET['quiz']) && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == '/thu-vien-cua-toi'): ?>
        <?php include BASE . '/views/components/modal-add-new-question.php' ?>
    <?php else: ?>
        <?php include BASE . '/views/components/modal-create-new-quiz.php' ?>
    <?php endif; ?>
    <script src="/assets/js/tabler.min.js?1745522455" defer></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>

</html>

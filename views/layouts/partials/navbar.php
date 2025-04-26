<?php
$routes = [
    ['uri' => '/', 'title' => 'Khám phá', 'icon' => 'discovery', 'auth_required' => false],
    ['uri' => '/thu-vien-cua-toi', 'title' => 'Thư viện của tôi', 'icon' => 'library', 'auth_required' => true],
]
?>

<header class="navbar navbar-expand-md navbar-overlap d-print-none" data-bs-theme="dark">
    <div class="container-xl">
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbar-menu"
            aria-controls="navbar-menu"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php include BASE . '/views/components/logo.php' ?>
        <div class="navbar-nav flex-row order-md-last">
            <?php if (isset($_SESSION['user'])): ?>
                <div class="nav-item d-none d-md-flex me-3">
                    <?php include BASE . '/views/components/play-quiz.php' ?>
                </div>
                <?php include BASE . '/views/components/profile.php' ?>
            <?php else: ?>
                <div class="nav-item d-flex">
                    <?php include BASE . '/views/components/login-button.php' ?>
                </div>
            <?php endif ?>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav">
                <?php foreach ($routes as $route): ?>
                    <?php if ($route['auth_required'] && !isset($_SESSION['user'])) continue; ?>
                    <li class="nav-item<?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === $route['uri'] ? ' active' : '' ?>">
                        <a class="nav-link" href="<?= $route['uri'] ?>">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <?php include BASE . "/public/assets/img/icons/{$route['icon']}.svg" ?>
                            </span>
                            <span class="nav-link-title">
                                <?= e($route['title']) ?>
                            </span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</header>

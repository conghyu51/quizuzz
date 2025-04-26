<?php if (count($quizzes) > 0): ?>
    <div class="row row-cards">
        <?php foreach ($quizzes as $quiz): ?>
            <div class="col-sm-6 col-lg-4">
                <a href="/choi?quiz=<?= e($quiz['slug']) ?>" class="card card-sm">
                    <div class="d-block position-relative">
                        <img src="<?= e($quiz['image']) ?>" class="card-img-top" style="height: 280px; width: 100%; object-fit: cover;">
                        <div class="position-absolute" style="top: 10px; right: 10px; background: rgba(0,0,0,0.7); color: white; padding: 5px 10px; border-radius: 7px;">
                            Lượt chơi: <?= number_format(e($quiz['play'])) ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-2 me-3 rounded" style="background-image: url(/assets/img/flags/vn.svg);"></span>
                            <div>
                                <div><?= e(mb_strlen($quiz['name']) > 43 ? mb_substr($quiz['name'], 0, 43) . '...' : $quiz['name']) ?></div>
                                <div class="text-secondary">
                                    Bởi <?= e($quiz['username']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach ?>
    </div>
<?php else: ?>
    <?php include BASE . '/views/components/empty-quiz.php' ?>
<?php endif ?>

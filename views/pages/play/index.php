<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card card-sm shadow">
            <div class="card-body text-center ps-0 pe-0">
                <h2 class="mb-3">
                    Quiz: <?= e($quiz['name']) ?>
                </h2>

                <?php if (!empty($quiz['image'])): ?>
                    <img src="<?= e($quiz['image']) ?>" class="img-fluid mb-4" style="max-height: 280px;">
                <?php endif; ?>

                <div class="mb-3 mt-2">
                    <div class="mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-list-numbers me-1">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M11 6h9" />
                            <path d="M11 12h9" />
                            <path d="M12 18h8" />
                            <path d="M4 16a2 2 0 1 1 4 0c0 .591 -.5 1 -1 1.5l-3 2.5h4" />
                            <path d="M6 10v-6l-2 2" />
                        </svg>
                        Số câu hỏi: <strong><?= e($quiz['questions']) ?></strong>
                    </div>
                    <div class="mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-hourglass-empty">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M6 20v-2a6 6 0 1 1 12 0v2a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1z" />
                            <path d="M6 4v2a6 6 0 1 0 12 0v-2a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1z" />
                        </svg>
                        Giới hạn thời gian: <strong><?= e($quiz['duration_minutes']) == 0 ? 'Không giới hạn' : number_format(e($quiz['duration_minutes'])) . ' phút' ?></strong>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                        Tạo bởi: <strong><?= e($quiz['username']) ?></strong>
                    </div>
                </div>

                <form action="/choi/bat-dau" method="POST">
                    <input type="hidden" name="quizId" value="<?= e($quiz['id']) ?>">
                    <button type="submit" class="btn btn-primary mt-3">Bắt đầu</button>
                </form>
            </div>
        </div>
    </div>
</div>

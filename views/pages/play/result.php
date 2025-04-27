<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body text-center ps-0 pe-0">
                <h1 class="mb-3 mt-2">
                    Kết quả
                </h1>

                <div class="result-summary mb-5">
                    <h2 class="display-2 fw-bold mb-1">
                        <?= $results['score'] ?>
                    </h2>
                    <p>điểm</p>
                    <div class="hr"></div>
                    <p class="mb-1">
                        Bạn đã trả lời đúng <strong><?= $results['correct_count'] ?>/<?= $results['total_questions'] ?></strong> câu hỏi
                    </p>
                    <p class="mb-1">
                        Quiz: <strong><?= e($results['quiz']['name']) ?></strong>
                    </p>
                    <p class="mb-1">
                        Bắt đầu lúc: <strong><?= (new DateTimeImmutable(e($results['attempt']['started_at'])))->format('H:i:s d/m/Y') ?></strong>
                    </p>
                    <p class="mb-1">
                        Kết thúc lúc: <strong><?= (new DateTimeImmutable(e($results['attempt']['completed_at'])))->format('H:i:s d/m/Y') ?></strong>
                    </p>
                </div>

                <div class="buttons mt-4">
                    <a href="/choi?quiz=<?= htmlspecialchars($results['quiz']['slug']) ?>" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-reload">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747" />
                            <path d="M20 4v5h-5" />
                        </svg>
                        Làm lại
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

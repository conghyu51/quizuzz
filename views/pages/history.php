<?php if (is_array($quizAttempts)): ?>
    <div class="row row-cards">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Quiz</th>
                            <th>Bắt đầu lúc</th>
                            <th>Kết thúc lúc</th>
                            <th>Điểm</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($quizAttempts as $attempt): ?>
                            <tr>
                                <td><?= e($attempt['id']) ?></td>
                                <td><?= e($attempt['name']) ?></td>
                                <td><?= e($attempt['started_at']) ?></td>
                                <td><?= e($attempt['completed_at'] ?? '') ?></td>
                                <td><?= e($attempt['score']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="container-xl my-auto">
        <div class="empty">
            <p class="empty-title">
                Không tìm thấy quiz nào
            </p>
            <p class="empty-subtitle text-secondary">
                Bạn chưa làm quiz nào...
            </p>
        </div>
    </div>
<?php endif ?>

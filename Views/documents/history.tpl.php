<?php include("Views/layouts/header.php"); ?>

<link rel="stylesheet" href="../assets/css/style.css">

<section class="document-page">
    <div class="container">
        <h2 class="section-title">История загруженных документов</h2>
        <div class="history__list">
            <?php foreach ($pageData['history'] as $item): ?>
            <div class="list-item">
                <p class="doc-info">Документ: <span><?= $item['filename'];?></span></p>
                <p class="user-info">Загрузил пользователь: <span><?= ucfirst($item['username']);?></span> в <?= $item['time'];?></p>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</section>
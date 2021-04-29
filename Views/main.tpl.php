<?php include("layouts/header.php");
echo "<pre>";

echo "</pre>";
?>

<main class="main">
    <section class="documents-list">
        <div class="container">
            <div class="section__filters">
                <nav class="nav__filter">
                    <!-- <a href="/" class="btn btn-nav <?= ($pageData['style']['nav__allDoc'] == 'active') ? 'active' : ''; ?>"> Все </a>
                    <a href="?newDoc" class="btn btn-nav <?= ($pageData['style']['nav__newDoc'] == 'active') ? 'active' : ''; ?>"> Новые</a>
                    <a href="?processDoc" class="btn btn-nav <?= ($pageData['style']['nav__processDoc'] == 'active') ? 'active' : ''; ?>">В процессе</a>
                    <a href="?completeDoc" class="btn btn-nav <?= ($pageData['style']['nav__completeDoc'] == 'active') ? 'active' : ''; ?>">Готовые</a> -->
                    <a href="/" class="btn btn-nav"> Все </a>
                    <a href="?newDoc" class="btn btn-nav"> Новые</a>
                    <a href="?processDoc" class="btn btn-nav">В процессе</a>
                    <a href="?completeDoc" class="btn btn-nav">Готовые</a> 

                </nav>
            </div>
            <div class="list-wrapper">
                <?php foreach ($pageData['documents'] as $document) : ?>

                    <div class="document__item">
                        <div class="item__header">
                            <h3 class="item__title"><a href="document?id=<?= $document['id']; ?>" class="item__title-link"><?= $document['filename']; ?></a></h3>
                        </div>
                        <div class="item__body">
                            <div class="item__date">Дата загрузки: <?= $document['uploaded_date']; ?></div>
                            <div class="item__type">Тип: <?= $document['type']; ?></div>
                        </div>
                        <div class="item__footer">
                            <div class="item__likes"><span><?= $document['likes']; ?></span></div>
                            <!-- <div class="item__dislikes">Дизлайки: <?= $document['dislikes']; ?></div> -->
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
</body>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/app.js"></script>

</html>
<?php include("Views/layouts/header.php");


// Поиск отличий в двух текстах
// use DiffMatchPatch\DiffMatchPatch;

// $text1 = $_SESSION['text'];
// $text2 = $pageData['documentTextPreview'];
// $dmp = new DiffMatchPatch();
// $diffs = $dmp->diff_main($text1, $text2, false);
// $myDiff = [];

// foreach ($diffs as $diff => $value) {
//     if ($value[0] == 1) {
//         array_push($myDiff, $value[1]);
//     }
// }
// print_r(implode($myDiff));

?>

<section class="document-page">
    <div class="container">
        <h2 class="section-title"><?= $pageData['document']['filename']; ?></h2>
        <h4 class="section-subtitle">Cодержание</h4>
        <div class="votes">
            <div class="like"><span> <?= isset($pageData['like']['dislike']) ? $pageData['like']['dislike'] : 0; ?> </span></div>
            <div class="dislike"><span> <?= isset($pageData['dislike']['dislike']) ? $pageData['dislike']['dislike'] : 0; ?> </span></div>
        </div>
        <div class="document">
            <p class="document__preview">
                <?= $pageData['documentTextPreview']; ?>
            </p>
            <div class="document__actions">
                <?php if (empty($pageData['hasVote'])) : ?>
                    <button class="btn btn-modal popup-open">Проголосовать</button>
                <?php else : ?>
                    <p>Вы уже оставили свой отзыв</p>
                <?php endif; ?>
                <form action="" method="POST" style="display: flex; align-items: center;">
                    <button class="btn btn-download" type="submit" name="submitDownload">Скачать</button>
                    <button class="btn btn-download load-popup-open" type="submit">Загрузить новый файл</button>
                    <button class="btn btn-download" id="save-state" type="submit" name="saveState">Сохранить состояние</button>
                </form>
            </div>
        </div>

        <!-- Комментарии -->

        <div class="comments">
            <h3 class="section__title">Комментарии</h3>
            <?php foreach ($pageData['comments'] as $comment) : ?>

                <div class="comments__card">
                    <div class="comment__header">
                        <p class="comment__author"><span><?= ucfirst($comment['username']); ?></span></p>
                        <p class="comment_date">Дата: <?= date("d:m H:i:s", strtotime($comment['date'])); ?></p>
                    </div>
                    <div class="comment__body">
                        <p class="comment__text"><?= $comment['comment']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>


        <!-- Modal -->

        <div class="popup-fade">
            <div class="popup">
                <a class="popup-close" href="/">×</a>
                <p>Оставьте ваш отзыв</p>
                <form action="" method="POST" id="form-modal">
                    <div class="form__group">
                        <label for="username" class="form__label">Ваше имя</label>
                        <input type="text" id="username" name="username" class="form__input" value="<?= $_SESSION['user']['username']; ?>" disabled>
                    </div>

                    <div class="form__group">
                        <label for="username" class="form__label">Проголосовать</label>
                        <div class="radio__wrapper">
                            <div class="radio">
                                <label class="custom-radio">
                                    <input type="radio" name="like" value="like">
                                    <span>Нравится</span>
                                </label>
                            </div>
                            <div class="radio">
                                <label class="custom-radio">
                                    <input type="radio" name="like" value="dislike" required>
                                    <span>Не нравится</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form__group">
                        <label for="comment" class="form__label">Комментарий</label>
                        <textarea name="textComment" id="text-comment" class="form__input" cols="42" rows="5" required></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-submit submit-modal">Оставить отзыв</button>
                </form>
            </div>
        </div>

        <!-- Upload Modal -->

        <div class="load-popup">
            <div class="popup">
                <a class="load-popup-close" href="/">×</a>

                <?php if (isset($pageData['message'])) : ?>
                    <div class="message"><?= $pageData['message']; ?></div>
                <?php endif; ?>

                <p>Загрузите обновленную версию файла</p>

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="field__wrapper">

                        <input name="inputFile" type="file" id="field__file-2" class="field field__file" accept=".txt, .doc, .docx">
                        <label class="field__file-wrapper" for="field__file-2">
                            <div class="field__file-fake">Файл не выбран</div>
                            <div class="field__file-button">Выбрать</div>
                        </label>

                    </div>
                    <button class="btn btn-submit" name="updateFile" style="margin: auto;">Загрузить</button>
                </form>
            </div>
        </div>

    </div>
</section>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/form.js"></script>

<script>
    let fileUploader = document.getElementById('field__file-2');

    fileUploader.addEventListener('change', function(e) {
        const file = e.target.files;
        document.querySelector('.field__file-fake').innerHTML = `${file[0].name}`;
    })
</script>
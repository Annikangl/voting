<?php include(ROOT . 'Views/layouts/header.php'); ?>

<link rel="stylesheet" href="../assets/css/style.css">

<section class="upload">
    <div class="container">
        <h3 class="section__title">Загрузить документ на голосование</h3>
        <p class="section__subtitle">Можно загрузить: DOC, DOCX, TXT</p>
        <?php if (isset($pageData['message'])) : ?>
            <div class="message"><?= $pageData['message']; ?></div>
        <?php endif; ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="field__wrapper">
                
                <input name="inputFile" type="file" id="field__file-2" class="field field__file" accept=".txt, .doc, .docx">
                <label class="field__file-wrapper" for="field__file-2">
                    <div class="field__file-fake">Файл не выбран</div>
                    <div class="field__file-button">Выбрать</div>
                </label>

            </div>
            <button class="btn btn-submit" name="submit">Загрузить</button>
        </form>
    </div>
</section>

<script>
    let fileUploader = document.getElementById('field__file-2');

    fileUploader.addEventListener('change', function(e) {
        const file = e.target.files;
        document.querySelector('.field__file-fake').innerHTML = `${file[0].name}`;
    })
</script>
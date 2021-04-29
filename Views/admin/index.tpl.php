<link rel="stylesheet" href="../assets/css/style.css">

<?php

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <div class="header__inner">
                <div class="header__title"><a href="<?= '../'; ?>" class="header__title">Панель администратора</a></div>
                <div class="header__actions">
                    <?php if (isset($_SESSION['user'])) : ?>
                        <div class="dropdown">
                            <button class="dropbtn">Кабинет, <?= ucfirst($_SESSION['user']['username']); ?></button>
                            <div class="dropdown-content">
                                <a href="/document/history" class="btn btn-dropdown">История загрузок</a>
                                <a href="/user/addFiles" class="btn btn-dropdown">Загрузить документ</a>
                                <a href="/user/logout" class="btn btn-dropdown">Выйти</a>
                            </div>
                        </div>

                    <?php else : ?>
                        <a href="user/login" class="btn btn-login">Войти</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <main class="main">
        <section class="admin-actions">
            <div class="container">
                <h3 class="section__title">Панель управления</h3>
                <div class="admin__actions">
                        <a href="/voting/admin/userList/" class="btn btn-action">Список пользователей</a>
                </div>
            </div>

        </section>
    </main>
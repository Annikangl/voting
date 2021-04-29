<link rel="stylesheet" href="/assets/css/style.css">
<link rel="stylesheet" href="/assets/css/table.css">
<link rel="stylesheet" href="/assets/css/modal.css">
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/modal.js"></script>
<script src="/assets/js/form.js"></script>

<header class="header">
    <div class="container">
        <div class="header__inner">
            <div class="header__title"><a href="<?= '/admin'; ?>" class="header__title">Панель администратора</a></div>
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

<section class="userList">

    <div class="container">
        <div class="userList__header">
            <h3 class="section__title">Список участников</h3>
            <button class="btn btn-modal popup-open">Добавить участника</button>
        </div>
        <table class="table">
            <thead>
                <th>Username</th>
                <th>Дата регистрации</th>
                <th>Роль</th>
                <th></th>
            </thead>
            <tbody>
                <?php foreach ($pageData['usersList'] as $user) : ?>
                    <tr class="table-row">
                        <td><?= $user['username']; ?></td>
                        <td><?= $user['date_created']; ?></td>
                        <td><?= $user['role']; ?></td>
                        <td>
                            <button class="btn btn-delete" data-user-id="<?= $user['id']; ?>" >Удалить</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="popup-fade">
            <div class="popup">
                <a class="popup-close" href="/">×</a>
                <p>Редактирование данных участника</p>
                <form action="" method="POST" id="form-modal" class="delete-user" enctype="multipart/form-data">
                    <div class="form__group">
                        <label for="username" class="form__label">Логин</label>
                        <input type="text" id="username" name="username" class="form__input" required>
                        <label for="username" class="form__label">Пароль</label>
                        <input type="password" id="pwd" name="pwd" class="form__input" required>
                        <label for="username" class="form__label">Роль</label>
                        <select name="role" id="select-role" class="form__input" required>
                            <option value="default" disabled>Выберите роль участника</option>
                            <option value="admin">Администратор</option>
                            <option value="user">Участник</option>
                        </select>
                        <button type="submit" name="submit" id="create-user" class="btn btn-submit submit-modal">Создать</button>
                    </div>
            </div>
    </div>
</section>
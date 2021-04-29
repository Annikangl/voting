<?php include("Views\layouts\header.php"); ?>

<link rel="stylesheet" href="../assets/css/style.css">
<section class="login">

    <div class="form__auth">
        <form action="" method="POST" class="form">
            <h3 class="form__title">Регистрация</h3>
            <?php if (isset($pageData['error'])): ?>
                <p class='message-error'><?= $pageData['error'];?></p>
            <?php endif; ?>


            <div class="form__group">
                <label for="username" class="form__label">Логин</label>
                <input type="text" id="username" name="username" class="form__input">
            </div>

            <div class="form__group">
                <label for="pass" class="form__label">Пароль</label>
                <input type="password" id="pass" name="pwd1" class="form__input">
            </div>

            <div class="form__group">
                <label for="pass" class="form__label">Повторите пароль</label>
                <input type="password" id="pass" name="pwd2" class="form__input">
                
            </div>

            <button type="submit" name="submit" class="btn btn-submit">Зарегистрироваться</button>
            <p>Уже есть аккаунт? <a href="./login" class="form-link">Войти</a></p>
        </form>
    </div>
</section>
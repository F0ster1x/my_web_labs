<?php if (isset($_SESSION['name'])):?>
    <?php ob_start() ?>
    <div class="header_logo"><img src="/images/logo.png"></div>
    <div class="header_text"><a href="/index.php">Сайт объявлений</a></div>
    <div class="header_sign-in">Привет, <?=$_SESSION['name']?></div>
    <div class="header_text"><a href="/form.php">Добавить объявление</a></div>
    <div class="header_sign-up" onclick="sessionDelete()">Выход</div>
    <?php $header = ob_get_clean() ?>
<?php endif;?>
<?php if (!isset($_SESSION['name'])):?>
    <?php ob_start() ?>
    <div class="header_logo"><img src="/images/logo.png"></div>
    <div class="header_text"><a href="/index.php">Сайт объявлений</a></div>
    <div class="header_sign-in"><a href="#login-window">Вход</a></div>
    <div class="header_sign-up"><a href="#registration-window">Регистрация</a></div>
    <?php $header = ob_get_clean() ?>
<?php endif;
echo $header;



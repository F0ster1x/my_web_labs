<?php session_start();?>
<!doctype html>

<html lang="en">
<head>
    <link href="css/index.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <title>Сайт объявлений Глеба Поленникова</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<script src="js/scripts.js"></script>
<body onload="loginCheck(), registerCheck();">
    <header id="header" >
        <?php include 'PHPscripts/checkSession.php'?>
    </header>

    <div id = "login-window">
        <div class = "registration-top">
            <a href="">
                <div class="cl-btn-2">
                    <div>
                        <div class="left-to-right"></div>
                        <div class="right-to-left"></div>
                        <span class="close-btn">закрыть</span>
                    </div>
                </div>
            </a>
            <div><h1>Вход</h1></div>
            <div><a href="#registration-window" class="change-window">Регистрация</a></div>
        </div>
        <form action="#" class = "top-row" id="authorization-form" method="post" onsubmit="
            event.preventDefault();
            authorization();
            ">
                <label for="loginEmail"></label><input type="email" placeholder="Электронная почта..." required autocomplete="email" name="email" pattern="[a-zA-Z0-9\s]+@[a-zA-Z0-9\s]+\.[a-zA-Z0-9\s]+$" id="loginEmail"/>

                <label for="loginPassword"></label><input type="password" placeholder="Пароль..." required autocomplete="off" name="password" pattern="[@?!,.a-zA-Z0-9\s]+$" id="loginPassword" minlength="7"/>

            <button type="submit" id="login_button" class="button button-block">Войти</button>
        </form>
        <ul id="logUL">

        </ul>
    </div>


    <div id = "registration-window">
        <div class = "registration-top">
            <a href="" id="CloseRegistrationWindow">
                <div class="cl-btn-2">
                    <div>
                        <div class="left-to-right"></div>
                        <div class="right-to-left"></div>
                        <span class="close-btn">закрыть</span>
                    </div>
                </div>
            </a>
            <div><h1>Регистрация</h1></div>
            <div><a href="#login-window" class="change-window">Вход</a></div>
        </div>
        <form action="index.php" class = "top-row" id="registration-form" method="post" onsubmit="
            event.preventDefault();
            registration();
            ">

            <label for="RegistrationName"></label><input type="name" name="name" placeholder="Введите ваше имя..." required autocomplete="on" pattern="[А-ЯЁа-яё]+$" id="RegistrationName"/>

            <label for="email"></label><input type="email" name="email" placeholder="Электронная почта..." required autocomplete="email" pattern="[a-zA-Z0-9\s]+@[a-zA-Z0-9\s]+\.[a-zA-Z0-9\s]+$" id="email"/>

            <label for="tel"></label><input type="tel" name="tel" placeholder="Номер телефона (в формате +71234567890)...." required autocomplete="tel" pattern="[\+]\d{11}" minlength="12" maxlength="12" id="tel"/>

            <label for="txtNewPassword"></label><input type="password" name="firstPassword" placeholder="Пароль..." required autocomplete="off" pattern="[@?!,.a-zA-Z0-9\s]+$" id="txtNewPassword" minlength="7"/>

            <label for="txtConfirmPassword"></label><input type="password" name="secondPassword" placeholder="Повторите пароль..." required autocomplete="off" pattern="[@?!,.a-zA-Z0-9\s]+$" id="txtConfirmPassword" minlength="7"/>
            <div id="divCheckPassword"></div>

            <div class = "registration-block"></div>
                <label class="checkbox-google">
                    <input type="checkbox" required id="info">
                    <span class="checkbox-google-switch"></span>
                </label>
                Согласие на обработку персональных данных
            <script src="https://www.google.com/recaptcha/api.js"></script>
            <script>
                function onSubmit(token) {
                    document.getElementById("registration-form").submit();
                }
            </script>
            <button name="submit" id="button" data-sitekey="reCAPTCHA_site_key"
                    data-callback='onSubmit'
                    data-action='submit' class="button button-block">Зарегистрироваться</button>
            </form>
        <ul id="regUL">

        </ul>
        </div>

    <main>
        <div class="content" id="content">
            <?php include "PHPscripts/loadPage.php";?>
        </div>
        <button class="load_button" onclick="advertLoad(findLastId());" id="load_button">Загрузить ёщё</button>

    </main>

    <footer>
        <div>Выполнил студент Глеб Поленников</div>
    </footer>

</body>
</html>


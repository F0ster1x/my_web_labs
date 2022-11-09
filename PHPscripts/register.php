<?php
session_start();
if (empty($_SESSION['email'])) {
    header('Location: index.php');
}
header('Content-Type: application/json');

$errors = [];

function sanitize ($string) {
    return filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
}

$email = sanitize($_POST['email']);
$name = sanitize($_POST['name']);
$phone = sanitize($_POST['tel']);
$password = sanitize($_POST['firstPassword']);
$hash = password_hash($password, PASSWORD_DEFAULT);

function checkPregMatch($errors, $pattern, $string, $message) {
    if (preg_match($pattern, $string) === 0) {
        $errors[] = $message;
    }
}

checkPregMatch($errors, "/[А-ЯЁРХЭЮЬЧа-яёрьхъюэч]+$/", $_POST['name'], "Имя должно содержать только кириллицу.");
checkPregMatch($errors, "/[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/", $_POST['email'], "Неверно введена электронная почта.");
checkPregMatch($errors, "/[\+]\d{11}/", $_POST['tel'], "Неверный формат телефона.");
checkPregMatch($errors, "/[@?!,.a-zA-Z0-9\s]+$/", $_POST['firstPassword'],
    "Неверный формат пароля (Допустимы только английские буквы, цифры, символы ' @ ? ! , . ' .");


if (strlen($_POST['firstPassword']) < 7) {
    $errors[] = "Слишком короткий пароль.";
}

if ($_POST['firstPassword'] != $_POST['secondPassword']) {
    $errors[] = "Пароли не одинаковы!";
}


if (!empty($errors)) {
    echo json_encode(['errors' => $errors]);
    die();
}

include 'connect.php';

$sql = "SELECT * FROM siteUser WHERE email = :email OR phone = :phone limit 1";
$result = $pdo->prepare($sql);
$result->bindParam(':email', $_POST['email']);
$result->bindParam(':phone', $_POST['tel']);
$params = [
    'phone' => $_POST['tel'],
    'email' => $_POST['email']
];
$result->execute($params);
if ($result->rowCount() != 0) {
    $errors[] = 'Аккаунт с таким номером телефона или электронной почтой уже существует!';
}

if (!empty($errors)) {
    echo json_encode(['errors' => $errors]);
    die();
}

$sql = "INSERT INTO siteUser(phone, email, 'name', password) VALUES (:phone, :email, 'name', :hash)";
$result = $pdo->prepare($sql);
$params = [
    'hash' => $hash,
    'name' => $name,
    'phone' => $phone,
    'email' => $email
];
$result->execute($params);

$_SESSION['email'] = $email;
$_SESSION['name'] = $name;
$_SESSION['phone'] = $phone;

echo json_encode(['success' => true]);

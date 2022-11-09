<?php
session_start();
header('Content-Type: application/json');

$errors = [];

function sanitize ($string) {
    return filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
}

$email = sanitize($_POST['email']);
$password = sanitize($_POST['password']);

function checkPregMatch($errors, $pattern, $string, $message) {
    if (preg_match($pattern, $string) === 0) {
        $errors[] = $message;
    }
}

checkPregMatch($errors, "/[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/", $_POST['email'], "Неверно введена электронная почта.");

include 'connect.php';

$sql = "SELECT * FROM siteUser WHERE email = :email";
$result = $pdo->prepare($sql);
$result->bindParam(':email', $_POST['email']);
$result->execute();
if ($result->rowCount() == 0) {
    $errors[] = 'Такого аккаунта не существует!';
}
$row = ($result->fetch(PDO::FETCH_ASSOC));

if (!password_verify($password, $row['password'])) {
    $errors[] = 'Неверный пароль!';
}

if (!empty($errors)) {
    echo json_encode(['errors' => $errors]);
    die();
}

$_SESSION['email'] = $email;
$_SESSION['name'] = $row['name'];
$_SESSION['phone'] = $row['phone'];

echo json_encode(['success' => true]);

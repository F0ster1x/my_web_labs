<?php
if (empty($_SESSION['email'])) {
    header('Location: index.php');
}

session_start();
header('Content-Type: application/json');

$errors = [];

function sanitize ($string) {
    return filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
}

$name = sanitize($_POST['name']);
if (!empty($_POST['description'])) {
    $description = sanitize($_POST['description']);
} else {
    $description = 'Описания нет.';
}
$price = sanitize($_POST['price']);

if (!empty($_FILES['photo'])) {
    $file = $_FILES['photo'];
} else {
    $errors [] = 'Файл не загружен!';
    $_SESSION['formErrors'] = $errors;
    header('Location: form.php');
    die();
}


$input = array();
$input['name'] = $name;
$input['price'] = $price;
$input['photo'] = $_FILES['photo']['tmp_name'];

if (!empty($errors)) {
    $_SESSION['formErrors'] = $errors;
    header('Location: form.php');
    die();
}

$pathInfo = pathinfo($_FILES['photo']['name']);
$ext = $pathInfo['extension'] ?? "";
$newPath = 'images' . "/" . uniqid() . "." . $ext;

if (move_uploaded_file($_FILES['photo']['tmp_name'], $newPath)) {
    include 'connect.php';

    $sql = "INSERT INTO advert(phone, photo, description, price, name)
VALUES (:phone, :photo, :description, :price, :name)
RETURNING id";
    $result = $pdo->prepare($sql);
    $params = [
        'price' => $price,
        'photo' => $newPath,
        'description' => $description,
        'phone' => $_SESSION['phone'],
        'name' => $name
    ];
    $result->execute($params);
    $row = ($result->fetch(PDO::FETCH_ASSOC));
    header('Location: advert.php?id=' . $row['id']);
} else {
    $errors[] = "Возможная файловая атака!";
    $_SESSION['formErrors'] = $errors;
    header('Location: form.php');
    die();
}

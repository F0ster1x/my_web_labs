<?php
include "connect.php";
$sql = "SELECT * FROM advert WHERE is_closed = false AND id >= :id limit 1";
$result = $pdo->prepare($sql);
$result->bindParam(':id', $id, PDO::PARAM_INT);
$result->execute();
echo $result->rowCount();

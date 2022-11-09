<?php
include "connect.php";
$sql = "SELECT id FROM advert WHERE is_closed = false ORDER BY id LIMIT 1";
$result = $pdo->prepare($sql);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
$id = $row['id'];
$sql = "SELECT id, photo, name, price FROM advert WHERE is_closed = false AND id >= :id limit 10";
$result = $pdo->prepare($sql);
$result->bindParam(':id', $id, PDO::PARAM_INT);
$result->execute();
$adverts = [];
$rows = $result->fetchAll(PDO::FETCH_ASSOC);
?>
<?php foreach ($rows as $row): ?>
    <div class="item" id="<?= $row['id'] ?>">
        <img src="<?= $row['photo'] ?>" class="item_photo">
        <div class="item_text">
            <a href="/advert.php?id=<?= $row['id'] ?>" style="color: #f58142"><div><?= $row['name'] ?></div></a>
            <div><?= $row['price'] ?> рублей</div>
        </div>
    </div>
<?php endforeach;?>


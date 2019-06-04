<?php
$connection = connect();

$sql  = "SELECT * FROM posts ORDER BY timestamp DESC";
$stmt = $connection->prepare($sql);
$stmt->execute();
$posts      = $stmt->fetchAll();
$connection = null;

?>

<section class="posts">
    <?php foreach ($posts as $post) { ?>
    <?php require "./partials/post.php"; ?>


    <?php }
; ?>
</section>

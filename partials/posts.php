<?php
$connection = connect();

$sql  = "SELECT * FROM posts ORDER BY timestamp DESC";
$stmt = $connection->prepare($sql);
$stmt->execute();
$posts      = $stmt->fetchAll();
$connection = null;

?>

<section class="posts">
    <?php if (count($posts) == 0) { ?>
    <?php echo ("<p>no posts</p>");} ?>
    <?php foreach ($posts as $post) { ?>
    <?php require "./partials/post.php"; ?>


    <?php }
; ?>
</section>

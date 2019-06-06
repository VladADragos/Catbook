<section class="comments">

<form class="comment-form" action="./process.php" method="POST" >

<textarea class="text-area text-area--comment" name="comment" id=""  rows="4" onkeyup="handleCounting(event)"></textarea>
<input type="hidden" value="<?php echo ($_SESSION["userId"]); ?>" name="commenterId">
<input type="hidden" value="<?php echo ($post->id); ?>" name="postId">
<div class="comment-form__bottom">

    <p class="comment-form__letter-counter"> <span class="comment__counter">0</span>/80</p>
    <button class="button button--primary button--comment" name="comment-button">comment</button>
</div>

</form>

<?php
$connection = connect();

$sql  = "SELECT * FROM comments WHERE postId=:postId  ORDER BY timestamp DESC";
$stmt = $connection->prepare($sql);
$stmt->execute(['postId' => $post->id]);
$comments   = $stmt->fetchAll();
$connection = null;

?>


<?php foreach ($comments as $comment) { ?>
    <?php require "./partials/comment.php"; ?>
    <?php }
; ?>

</section>

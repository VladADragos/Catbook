<?php
try {
    $connection = connect();
    $sql        = "SELECT username,id,profilePicture FROM users WHERE id=:id";

    $stmt = $connection->prepare($sql);
    $id   = $comment->commenterId;
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch();

} catch (PDOException $e) {
    echo "<br>" . $e->getMessage();
}
?>

<div class="comment">
        <div class="comment-user">
            <img class="user-image--comment" src="./images/defaultProfilePictures/<?php echo ($user->profilePicture); ?>" alt="">
            <a href="user.php?user=<?php echo ($comment->commenterId); ?>" class="comment-user__name"><?php echo ($user->username); ?></a>
        </div>
        <p class="comment__text"><?php echo ($comment->comment); ?>


        <?php if ($_SESSION["userId"] === $comment->commenterId) { ?>
            <div class="more">
            <button class="button--clear more-toggler" onclick="toggle(event)">
                    <!-- <i class="far fa-user button--friend-more__icon"></i> -->
                    <i class="fas fa-ellipsis-v "></i>
                </button>

                <div class="more-panel more-panel--small">

                    <form  id="delete-comment-form" action="process.php" method="POST" >
                        <input type="hidden" name="commentId" value="<?php echo ($comment->id); ?>">
                        <button class="button--clear more-option" name="delete-comment-button">
                        <i class="far fa-trash-alt more-option__icon"></i> Delete
                        </button>


                </form>
            </div>
            </div>




        <?php } ?>
    </p>

    </div>
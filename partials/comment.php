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
            <h4 class="comment-user__name"><?php echo ($user->username); ?></h4>
        </div>
        <p class="comment__text"><?php echo ($comment->comment); ?></p>
    </div>
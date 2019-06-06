<?php
$connection = connect();

// if (isset($friend->userId)) {
//     $id = $friend->userId;
// } else {
//     $id = $friend->friendId;
// }

$id  = $friend->userId ?? $friend->friendId;
$sql = "SELECT id, username, profilePicture FROM users WHERE id=:id";

$stmt = $connection->prepare($sql);
$stmt->execute(['id' => $id]);

$Friend = $stmt->fetch();

$connection = null;

$friend->friendId             = $id;
$friend->friendName           = $Friend->username;
$friend->friendProfilePicture = $Friend->profilePicture;

?>

<section class="friend">
    <img class="friend__image" src="./images/defaultProfilePictures/<?php echo ($friend->friendProfilePicture); ?>" alt="">
    <h5 class="friend__header"><?php echo ($friend->friendId); ?></h5>
    <h5 class="friend__header"><?php echo ($friend->friendName); ?></h5>
    <h5 class="friend__header"><?php echo ($friend->friendProfilePicture); ?></h5>
    <img class="friend__more-button" src="./images/more.svg" alt="friend more button">
</section>
<hr>

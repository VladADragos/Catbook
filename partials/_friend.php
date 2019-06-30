<?php
$connection = connect();

// if (isset($friend->userId)) {
//     $id = $friend->userId;
// } else {
//     $id = $friend->friendId;
// }

$id  = $_SESSION["userId"] == $friend->userId ? $friend->friendId : $friend->userId;
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
    <a href="./user.php?user=<?php echo ($friend->friendId); ?>"   class="friend__header"><?php echo ($friend->friendName); ?>


</a>


    <div class="more">

        <button class="button--clear more-toggler" name="friend" onclick="toggle(event)">
        <i class="fas fa-ellipsis-v"></i>
        </button>
        <section class="more-panel" id="friend-panel">
            <a class="button--clear more-option" href="./user.php?user=<?php echo ($friend->friendId); ?>">
                <i class="far fa-user more-option__icon"></i>View
            </a>
        <form action="./process.php" method="POST" name="unfriend-form" >
        <input type="hidden" value="<?php echo ($friend->id) ?>" name="id">
            <button class="button--clear more-option" name="unfriend-button">
                <i class="far fa-trash-alt more-option__icon"></i> Remove
            </button>
        </form>
        </section>
    </div>
</section>


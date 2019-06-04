<aside class="user-profile">
    <section class="user">
        <h2 class="user__header"><?php echo $name; ?></h2>
        <a href="./edit.php?user=<?php echo ($_SESSION["userId"]); ?>">edit</a>
        <img class="user__image" src="./images/defaultProfilePictures/<?php echo ($_SESSION["profilePicture"]); ?>" alt="Profile picture">
    </section>
    <section class="friends">
        <h3 class="friends__header">Friends</h3>
        <?php foreach ($friends as $friend) { ?>

        <?php require "./partials/_friend.php"; ?>
        <?php }
; ?>
        <?php if (count($friends) === 0) {echo ("<p>No friends found<p>");} ?>




    </section>

</aside>

<aside class="user-profile">
    <section class="user">
        <img class="user__image" src="./images/defaultProfilePictures/<?php echo ($_SESSION["profilePicture"]); ?>" alt="Profile picture">
        <h2 class="user__header"><?php echo $name; ?> </h2>


        <div class="more">

            <button class="button--clear more-toggler" onclick="toggle(event)">
                    <i class="material-icons more-toggler__icon">settings </i>
                </button>
                        <section class="more-panel">

                            <a class="more-option" href="./edit.php"><i class="material-icons more-option__icon">edit</i> edit</a>
                            <form action="./process.php" method="POST">
                            <input type="hidden" name="userId" value="<?php echo ($_SESSION['userId']); ?>" >
                            <button name="delete-user-button" class="button--clear more-option"><i class="material-icons more-option__icon">delete_outline</i>   delete</button>
                        </form>
                        </section>
        </div>
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




<main class="login-main">
    <img src="./images/map.png" alt="" />
    <form action="./process.php" method="POST" class="register-form" name="register-form" autocomplete="off"
        id="register-form" onsubmit="validateRegistrationForm(event)">
        <h2 class="register-form__header">Become a social cat <i class="fas fa-cat"></i></h2>
        <div class="input-container margin--top">
            <label for="username" class="form-label register-form__label">
                Username
            </label>

            <input autocomplete="off" type="text" name="username" class="form-input register-form__input"
                form="register-form" onchange="validate(event.target)" />

                <?php if (isset($_SESSION['errors']['username']) && $_SESSION['errors']['username'] == true) { ?>
                    <p class="error"> <?php echo ($_SESSION['errors']['username']); ?> </p>
                <?php } ?>
        </div>

        <div class="input-container margin--top">
            <label for="password" class="form-label register-form__label">
                Password
            </label>
            <input autocomplete="off" type="password" name="password" class="form-input register-form__input"
                form="register-form" onchange="validate(event.target)" />
                <?php if (isset($_SESSION['errors']['password']) && $_SESSION['errors']['password']) { ?>
                    <p class="error"> <?php echo ($_SESSION['errors']['password']); ?> </p>
                <?php } ?>
        </div>
        <div class="input-container margin--top">



            <button class="button--clear button--select" onclick="handleModal(event)">Profile Picture   <i class="fas fa-camera"></i></button>


                <img id="display-img" class="register-form__display-img" src="./images/defaultProfilePictures/1.jpg" alt="">
            </div>

            <input type="hidden" name="profile-picture" class="profile-picture" value="1.jpg">
        <button type="submit" name="register-button" class="button button--primary button--register">
            Register
        </button>
        <div class="picture-modal">



            <?php
$dir              = "./images/defaultProfilePictures/";
$numberOfPictures = 13;
$extension        = ".jpg";

?>
            <?php for ($i = 1; $i < $numberOfPictures + 1; $i++) { ?>
            <img class="picture-modal__picture" name="<?php echo ($i . $extension); ?>" src="<?php echo ($dir . $i . $extension); ?>"
                onclick="selectImage(event)" alt="">

            <?php } ?>



        </div>
        <?php if (isset($_SESSION['errors']['userExists']) && $_SESSION['errors']['userExists']) { ?>
        <p class="error">User already exists</p>
        <?php } ?>
        </form>


</main>
<script src="./javascript/selectProfilePicture.js"></script>

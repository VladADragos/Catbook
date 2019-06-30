<div class="navbar">
    <a href="./" class="header__link">
        <header class="header">
            <img src="./images/catbook.svg" alt="" class="header__logo" />
            <h1 class="header__text">Catbook</h1>
        </header>
    </a>
    <?php if (!isset($_SESSION["isLoggedIn"])) { ?>
    <form action="./process.php" method="POST" class="login-form" name="login-form" autocomplete="off" id="login-form" onsubmit="validateLoginForm(event)">



        <div class="input-container  margin--right ">
            <label for="username" class="form-label login-form__label">
                Username
            </label>

            <input autocomplete="false" type="text" placeholder="example@email.com" name="username"
                class="form-input login-form__input" form="login-form" onkeyup="validate(event.target)" />
                <?php if (isset($_SESSION['errors']['loginUsername']) && $_SESSION['errors']['loginUsername'] == true) { ?>

                    <p class="error">
                        <?php echo ($_SESSION['errors']['loginUsername']); ?>
                    </p>

                <?php } ?>

        </div>

        <div class="input-container  margin--right ">
            <label for="password" class="form-label login-form__label">
                Password
            </label>
            <input autocomplete="false" type="password" placeholder="*******" name="password"
                class="form-input login-form__input" form="login-form" onkeyup="validate(event.target)" />
                <?php if (isset($_SESSION['errors']['loginPassword']) && $_SESSION['errors']['loginPassword'] == true) { ?>

<p class="error">
    <?php echo ($_SESSION['errors']['loginPassword']); ?>
</p>

<?php } ?>
        </div>
        <button form="login-form" type="submit" name="login-button" class="button button--secondary button--login" >
            Login
        </button>
    </form>
    <?php } else { ?>

    <form action="./search.php" method="POST" id="search-form" class="search-form"
        <?php if (isset($_SESSION["isSearching"])) { ?> <?php //echo 'onkeyup="searchfunc(event)"'; ?> <?php } ?>>
        <input autocomplete="false" type="text" name="search-input" class="form-input search-form__input"
            form="search-form" />
        <button form="search-form" type="submit" name="search-button" class="button button--secondary button--search">
        <i class="material-icons">search</i> Search
        </button>
    </form>

    <?php //require "./images/menu.svg"; ?>

    <form action="./process.php" method="POST" id="logout-form">
        <button form="logout-form" type="submit" name="logout-button" class="button button--logout">
        <i class="material-icons">exit_to_app</i>Logout
        </button>
    </form>

    <?php } ?>
</div>

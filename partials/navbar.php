<div class="navbar">
    <a href="./" class="header__link">
        <header class="header">
            <img src="./images/catbook.svg" alt="" class="header__logo" />
            <h1 class="header__text">Catbook</h1>
        </header>
    </a>
    <?php if (!isset($_SESSION["isLoggedIn"])) { ?>
    <form action="./process.php" method="POST" class="login-form" name="login-form" autocomplete="off" id="login-form">



        <div class="input-container  margin--right ">
            <label for="username" class="form-label login-form__label">
                Username <?php if (isset($_SESSION["errors"])) {

    echo $_SESSION["errors"];
} ?>
            </label>

            <input autocomplete="false" type="text" placeholder="example@email.com" name="username"
                class="form-input login-form__input" form="login-form" onchange="validate(event)" />
        </div>

        <div class="input-container  margin--right ">
            <label for="password" class="form-label login-form__label">
                Password
            </label>
            <input autocomplete="false" type="password" placeholder="*******" name="password"
                class="form-input login-form__input" form="login-form" onchange="validate(event)" />
        </div>
        <button form="login-form" type="submit" name="login-button" class="button button--secondary button--login">
            Login
        </button>
    </form>
    <?php } else { ?>

    <form action="./search.php" method="POST" id="search-form" class="search-form"
        <?php if (isset($_SESSION["isSearching"])) { ?> <?php //echo 'onkeyup="searchfunc(event)"'; ?> <?php } ?>>
        <input autocomplete="false" type="text" name="search-input" class="form-input search-form__input"
            form="search-form" />
        <button form="search-form" type="submit" name="search-button" class="button button--secondary button--search">
            Search
        </button>
    </form>

    <?php //require "./images/menu.svg"; ?>

    <form action="./process.php" method="POST" id="logout-form">
        <button form="logout-form" type="submit" name="logout-button" class="button button--logout">
            Logout
        </button>
    </form>

    <?php } ?>
</div>

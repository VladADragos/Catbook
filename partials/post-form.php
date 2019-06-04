<section class="post-area">
    <h3 class="post-area__header">Write new post</h3>
    <form class="post-form" id="post-form" action="process.php" method="POST" enctype="multipart/form-data">
        <textarea class="text-area text-area--post" name="text" id="" cols="15" rows="4"
            onkeyup="handleCounting(event)">...</textarea>
        <div class="post-form__bottom">
            <div class="input-group">
                <input type="hidden" value="<?php echo ($_SESSION["userId"]) ?>" name="id">
                <input name="image" type="file" id="post-form__image-input" class="post-form__image-input"
                    onchange="logger(event)">
                <label for="post-form__image-input" class="image-input__icon">
                    <i class="fas fa-camera"></i>
                </label>
                <button class="button button--primary button--post" name="post-button">
                    Post
                </button>
            </div>
            <p class="post-form__letter-counter">
                <span class="text__counter">0</span>/150
            </p>
        </div>

    </form>

</section>

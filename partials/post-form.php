<section class="post-area">
<h3 class="post-area__header">Write new post</h3>
<form class="post-form" id="post-form" action="process.php" method="POST">
    <textarea class="text-area text-area--post" name="text-area--post" id="" cols="30" rows="4" onkeyup="handleCounting(event)">...</textarea>
    <div class="post-form__bottom">
        <div class="input-group">
            <button class="button button--primary button--post">
                Post
            </button>
            <input type="file" id="post-form__image-input" class="post-form__image-input">
            <label for="post-form__image-input" class="image-input__icon">
            <i class="fas fa-camera"></i>
            </label>
        </div>
        <p class="post-form__letter-counter">
            <span class="text-area--post__counter">0</span>/100
        </p>
    </div>

</form>

</section>

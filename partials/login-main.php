<main class="login-main">
  <img src="./images/map.png" alt="" />
  <form
    action="./process.php"
    method="POST"
    class="register-form"
    name="register-form"
    autocomplete="off"
    id="register-form"
  >
    <h2 class="register-form__header">Become a social cat <i class="fas fa-cat"></i></h2>
    <div class="input-container margin--top">
      <label for="username" class="form-label register-form__label">
        Username
      </label>

      <input
        autocomplete="off"
        type="text"
        name="username"
        class="form-input register-form__input"
        form="register-form"
        onchange="validate(event)"
      />
    </div>

    <div class="input-container margin--top">
      <label for="password" class="form-label register-form__label">
        Password
      </label>
      <input
        autocomplete="off"
        type="password"
        name="password"
        class="form-input register-form__input"
        form="register-form"
        onchange="validate(event)"
      />
    </div>
    <div class="input-container margin--top">
      <label for="password" class="form-label register-form__label">
        Email
      </label>
      <input
      autocomplete="off"
      type="text"
      placeholder="email@example.com"
      name="email"
      class="form-input register-form__input"
      form="register-form"
      />
    </div>
                              <div class="input-container margin--top">
                                <label for="password" class="form-label register-form__label">
                                  Phone number
                                </label>
                                <input
                                  autocomplete="off"
                                  type="text"
                                  name="phoneNumber"
                                  class="form-input register-form__input"
                                  form="register-form"
                                />
                              </div>
                              <div class="input-container margin--top">
                                <label for="password" class="form-label register-form__label">
                                  Admin
                                </label>
                                <input
                                  autocomplete="off"
                                  type="checkbox"
                                  name="phoneNumber"
                                  class="form-input register-form__input"
                                  form="register-form"
                                />
                              </div>
    <button
      type="submit"
      name="register-button"
      class="button button--primary button--register"
    >
      Register
    </button>
  </form>
</main>

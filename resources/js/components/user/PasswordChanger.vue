<template>
  <div class="password-changer">
    <form class="password-changer__form" @submit.prevent="this.sendData">
      <label for="old_password" class="password-changer__label">Введіть старий пароль:</label>
      <form-input-field id="old_password"
                        class="password-changer__input"
                        name-of-input="old_password"
                        type-of-input="password"
                        placeholder-of-input="Введіть старий пароль"
                        :is-required="true"
                        min-length-of-input="6"
                        max-length-of-input="100"
                        @data="this.setOldPassword"/>
      <label for="new_password" class="password-changer__label">Введіть новий пароль:</label>
      <form-input-field id="new_password"
                        class="password-changer__input"
                        name-of-input="new_password"
                        type-of-input="password"
                        placeholder-of-input="Введіть новий пароль"
                        :is-required="true"
                        min-length-of-input="6"
                        max-length-of-input="100"
                        @data="this.setNewPassword"/>
      <label for="confirm_password" class="password-changer__label">Повторіть новий пароль:</label>
      <form-input-field id="confirm_password"
                        class="password-changer__input"
                        name-of-input="confirm_password"
                        type-of-input="password"
                        placeholder-of-input="Повторіть новий пароль"
                        :is-required="true"
                        min-length-of-input="6"
                        max-length-of-input="100"
                        @data="this.setConfirmPassword"/>
      <input type="hidden" name="_token" :value="this.csrf">
      <form-button class="password-changer__btn-change">Змінити пароль</form-button>
    </form>
    <success-or-fail-modal-window
        class="password-changer__result-window result-window"
        v-if="this.result.isVisible"
        @close-modal-window="closeResultWindow"
        :text="this.result.text"
        :type="this.result.type">
      <div class="result-window__errors" v-if="Object.keys(this.result.errors).length">
        <ul class="result-window__list-of-errors">
          <li class="result-window__error" v-for="(error, key) in this.result.errors" :key="key">
            {{ error }}
          </li>
        </ul>
      </div>
    </success-or-fail-modal-window>
  </div>
</template>

<script>

export default {
  name: "password-changer",

  data() {
    return {
      oldPassword: '',
      newPassword: '',
      confirmPassword: '',
      _token: this.csrf,
      result: {
        errors: {},
        isVisible: false,
        text: "",
        type: ''
      },
    }
  },
  props: {
    link: {
      type: String,
      required: true,
    },
    id: {
      type: Number,
      required: true,
    }
  },
  methods: {
    setOldPassword(value) {
      this.oldPassword = value;
    },
    setNewPassword(value) {
      this.newPassword = value;
    },
    setConfirmPassword(value) {
      this.confirmPassword = value;
    },
    sendData() {
      this.result.errors = {};
      const formData = new FormData();
      formData.append('id', this.id);
      formData.append('old_password', this.oldPassword);
      formData.append('new_password', this.newPassword);
      formData.append('confirm_password', this.confirmPassword);
      formData.append('_token', this.csrf);

      axios.post(this.link, formData)
          .then(response => {
            this.result.text = "Пароль успішно змінено";
            this.result.type = "success";
            this.result.isVisible = true;
          })
          .catch(error => {
            if (error.response && error.response.data && error.response.data.errors) {
              this.result.errors = error.response.data.errors;
              this.result.text = "Не вдалося змінити пароль";
              this.result.type = "fail";
              this.result.isVisible = true;
            }
          });
    },
    closeResultWindow() {
      this.result.isVisible = false;
    }
  },
  computed: {
    csrf() {
      return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    },
  }
}
</script>

<style scoped lang="scss">
.password-changer {

  // .password-changer__form

  &__form {
    display: flex;
    flex-direction: column;
    justify-content: center;
    flex-wrap: wrap;
    width: 100%;
  }

  &__result-window {

  }

  // .password-changer__label

  &__label {
    color: #1b2f57;
    font-weight: 600;
    font-size: 1.2em;
  }

  // .password-changer__input

  &__input {
  }

  // .password-changer__btn-change

  &__btn-change {
    margin-top: 20px;
  }
}

.result-window {

  &__errors {

  }

  &__list-of-errors {

  }

  &__error {
    color: red;
    font-weight: 600;
  }
}
</style>
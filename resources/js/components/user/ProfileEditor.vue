<template>
  <div class="profile-editor">
    <form class="profile-editor__form" @submit.prevent="this.sendData">
      <label for="email" class="profile-editor__label">Введіть email:</label>
      <form-input-field id="email"
                        class="profile-editor__input"
                        name-of-input="email"
                        type-of-input="email"
                        placeholder-of-input="Введіть email"
                        :is-required="true"
                        min-length-of-input="3"
                        max-length-of-input="320"
                        :value-of-input="this.userData.email"
                        @data="this.setEmail"/>

      <label for="login" class="profile-editor__label">Введіть login:</label>
      <form-input-field id="login"
                        class="profile-editor__input"
                        name-of-input="login"
                        type-of-input="text"
                        placeholder-of-input="Введіть login"
                        :is-required="true"
                        min-length-of-input="3"
                        max-length-of-input="50"
                        :value-of-input="this.userData.login"
                        @data="this.setLogin"/>

      <label for="name" class="profile-editor__label">Введіть ім'я:</label>
      <form-input-field id="name"
                        class="profile-editor__input"
                        name-of-input="name"
                        type-of-input="text"
                        placeholder-of-input="Введіть ім'я"
                        :is-required="false"
                        max-length-of-input="200"
                        :value-of-input="this.userData.name"
                        @data="this.setName"/>

      <label class="profile-editor__label" for="date-of-birthday-field">Дата народження:</label>
      <input id="date-of-birthday-field"
             class="profile-editor__input profile-editor__input-date"
             type="date"
             name="date_of_birthday"
             min="1900-01-01"
             :max="this.maxDate"
             v-model="this.userData.date_of_birthday">

      <label class="profile-editor__label" for="avatar-field">Аватар:</label>
      <input id="avatar-field"
             class="profile-editor__input profile-editor__input-file"
             ref="imageData"
             type="file"
             name="avatar"
             accept="image/*"
             @change="this.setAvatar">

      <label class="profile-editor__label" for="about-me-field">Інформація про вас:</label>
      <textarea id="about-me-field"
                class="profile-editor__input profile-editor__input-textarea"
                name="about_me"
                maxlength="2000"
                placeholder="Напишіть інформацію про себе"
                v-model="this.userData.about_me"></textarea>

      <input type="hidden" name="_token" :value="csrf">
      <form-button class="profile-editor__btn-change">Редагувати</form-button>
    </form>
    <success-or-fail-modal-window
        class="profile-editor__result-window result-window"
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
  name: "ProfileEditor",

  data() {
    return {
      userData: {},
      avatar: '',
      maxDate: '',
      oldEmail: '',
      oldLogin: '',
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
    user: {
      type: String,
      required: true,
    }
  },
  methods: {
    setData() {
      this.userData = JSON.parse(this.user);
      this.oldEmail = this.userData.email;
      this.oldLogin = this.userData.login;
      this.userData.name = (this.userData.name !== null) ? this.userData.name : '';
      this.userData.about_me = (this.userData.about_me !== null) ? this.userData.about_me : '';
      this.userData.date_of_birthday = (this.userData.date_of_birthday !== null) ? this.userData.date_of_birthday : '';

      let today = new Date();
      let dd = today.getDate();
      let mm = today.getMonth() + 1;
      let yyyy = today.getFullYear();

      if (dd < 10) {
        dd = '0' + dd;
      }
      if (mm < 10) {
        mm = '0' + mm;
      }
      this.maxDate = yyyy + '-' + mm + '-' + dd;
    },
    setAvatar(event) {
      this.avatar = event.target.files[0];
    },
    setEmail(value) {
      this.userData.email = value;
    },
    setLogin(value) {
      this.userData.login = value;
    },
    setName(value) {
      this.userData.name = value;
    },
    sendData() {
      this.result.errors = {};
      const formData = new FormData();

      if (this.userData.email.trim() !== this.oldEmail) {
        formData.append('email', this.userData.email.trim());
      }
      if (this.userData.login.trim() !== this.oldLogin) {
        formData.append('login', this.userData.login.trim());
      }

      formData.append('id', this.userData.id);
      formData.append('name', this.userData.name.trim());
      formData.append('date_of_birthday', this.userData.date_of_birthday);
      formData.append('avatar', this.avatar);
      formData.append('about_me', this.userData.about_me.trim());
      formData.append('_token', this.csrf);

      axios.post(this.link, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
          .then(response => {
            this.result.text = "Профіль успішно відредаговано";
            this.result.type = "success";
            this.result.isVisible = true;
          })
          .catch(error => {
            if (error.response && error.response.data && error.response.data.errors) {
              this.result.errors = error.response.data.errors;
              this.result.text = "Не вдалося відредагувати профіль";
              this.result.type = "fail";
              this.result.isVisible = true;
            }
          });
    },
    closeResultWindow() {
      this.result.isVisible = false;
    }
  },
  mounted() {
    this.setData();
  },
  computed: {
    csrf() {
      return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    },
  }
}
</script>

<style scoped lang="scss">
.profile-editor {
  overflow-x: hidden;
  overflow-y: auto;
  max-height: 100%;

  &__form {
    display: flex;
    flex-direction: column;
    justify-content: center;
    flex-wrap: wrap;
    width: 100%;
    max-height: 100%;
  }

  &__result-window {

  }

  &__label {
    color: #1b2f57;
    font-weight: 600;
    font-size: 1.2em;
  }

  &__input {

    &-date {

    }

    &-file {

    }

    &-textarea {

    }
  }

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

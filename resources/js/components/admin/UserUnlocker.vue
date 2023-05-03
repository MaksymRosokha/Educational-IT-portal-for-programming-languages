<template>
  <div class="user-unlocker">
    <form class="user-unlocker__form" @submit.prevent="this.sendData">
      <p class="user-unlocker__label">
        Ви впевнені, що бажаєте розблокувати користувача?
      </p>

      <input type="hidden" name="_token" :value="csrf">
      <form-button class="user-unlocker__btn-submit">Розблокувати</form-button>
    </form>

    <success-or-fail-modal-window
        class="user-unlocker__result-window result-window"
        v-if="result.isVisible"
        @close-modal-window="closeResultWindow"
        :text="this.result.text"
        :type="this.result.type">
      <div class="result-window__errors" v-if="Object.keys(result.errors).length">
        <ul class="result-window__list-of-errors">
          <li class="result-window__error" v-for="(error, key) in result.errors" :key="key">
            {{ error }}
          </li>
        </ul>
      </div>
    </success-or-fail-modal-window>
  </div>
</template>

<script>
export default {
  name: "UserUnlocker",
  data() {
    return {
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
    sendData() {
      this.result.errors = {};
      const formData = new FormData();
      formData.append('id', this.id);
      formData.append('_token', this.csrf);

      axios.post(this.link, formData)
          .then(response => {
            this.result.text = 'Користувач успішно розблокований';
            this.result.type = "success";
            this.result.isVisible = true;
          })
          .catch(error => {
            if (error.response && error.response.data && error.response.data.errors) {
              this.result.errors = error.response.data.errors;
              this.result.text = 'Не вдалося розблокувати користувача';
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

.user-unlocker {

  &__form {
    display: flex;
    flex-direction: column;
  }

  &__label {
    margin-top: 5px;
    color: red;
    font-weight: 700;
    font-size: 1.3em;
  }

  &__btn-submit {
    margin-top: 20px;
  }

  &__result-window {
  }
}

.result-window {

  &__errors {
  }

  &__list-of-errors {
  }

  &__error {
  }
}
</style>
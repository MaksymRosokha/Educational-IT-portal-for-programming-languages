<template>
  <div class="answer-updater">
    <form class="answer-updater__form" @submit.prevent="sendData">
      <textarea name="text"
                id="text"
                placeholder="Напишіть відповідья"
                maxlength="5000"
                class="answer-updater__input"
                @keyup="this.autoScroll"
                v-model="answerData.text"></textarea>
      <input type="hidden" name="_token" :value="csrf">
      <form-button class="answer-updater__btn-submit">Редагувати</form-button>
    </form>

    <success-or-fail-modal-window
        class="answer-updater__result-window result-window"
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
  name: "AnswerUpdater",
  data() {
    return {
      answerData: {},
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
    answer: {
      type: Object,
      required: true,
    }
  },
  methods: {
    setData() {
      this.answerData = JSON.parse(this.answer);
    },
    autoScroll(e) {
      const description = document.getElementById('text');
      description.style.height = '100px';
      let scHeight = e.target.scrollHeight;
      description.style.height = scHeight + 'px';
    },
    sendData() {
      this.result.errors = {};
      const formData = new FormData();
      formData.append('id', this.answerData.id);
      formData.append('text', this.answerData.text);
      formData.append('_token', this.csrf);

      axios.post(this.link, formData)
          .then(response => {
            this.result.text = 'Відповідь успішно відредаговано';
            this.result.type = "success";
            this.result.isVisible = true;
          })
          .catch(error => {
            if (error.response && error.response.data && error.response.data.errors) {
              this.result.errors = error.response.data.errors;
              this.result.text = 'Не вдалося відредагувати відповідь';
              this.result.type = "fail";
              this.result.isVisible = true;
            }
          });
    },
    closeResultWindow() {
      this.result.isVisible = false;
    }
  },
  beforeMount() {
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

.answer-updater {
  width: 80vw;

  &__form {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  &__input {
    height: 100px;
    max-height: 330px;
    width: 100%;
    padding: 15px;
    outline: none;
    resize: none;
    font-size: 1.1em;
    margin-top: 20px;
    border-radius: 5px;
    border-color: #bfbfbf;

    &::-webkit-scrollbar {
      width: 0;
    }
  }

  &__btn-submit {
    margin-top: 20px;
    max-width: 400px;
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
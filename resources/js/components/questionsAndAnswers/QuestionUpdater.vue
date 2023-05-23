<template>
  <div class="question-updater">
    <form class="question-updater__form" @submit.prevent="sendData">
      <input type="text"
             name="title"
             id="title"
             class="question-updater__input"
             required
             maxlength="200"
             placeholder="Заголовок питання"
             v-model="questionData.title">
      <textarea name="description"
                id="description"
                placeholder="Опис питання"
                maxlength="5000"
                class="question-updater__input question-updater__input--description"
                @keyup="this.autoScroll"
                v-model="questionData.description"></textarea>
      <input type="hidden" name="_token" :value="csrf">
      <form-button class="question-updater__btn-submit">Редагувати</form-button>
    </form>

    <success-or-fail-modal-window
        class="question-updater__result-window result-window"
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
  name: "QuestionUpdater",
  data() {
    return {
      questionData: {},
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
    question: {
      type: Object,
      required: true,
    }
  },
  methods: {
    setData() {
      this.questionData = JSON.parse(this.question);
    },
    autoScroll(e){
      const description = document.getElementById('description');
      description.style.height = '100px';
      let scHeight = e.target. scrollHeight;
      description.style.height = scHeight + 'px';
    },
    sendData() {
      this.result.errors = {};
      const formData = new FormData();
      formData.append('id', this.questionData.id);
      formData.append('title', this.questionData.title);
      formData.append('description', this.questionData.description);
      formData.append('_token', this.csrf);

      axios.post(this.link, formData)
          .then(response => {
            this.result.text = 'Питання успішно відредаговано';
            this.result.type = "success";
            this.result.isVisible = true;
          })
          .catch(error => {
            if (error.response && error.response.data && error.response.data.errors) {
              this.result.errors = error.response.data.errors;
              this.result.text = 'Не вдалося відредагувати питання';
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

.question-updater {
  width: 80vw;

  &__form {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  &__input {
    height: 40px;
    width: 100%;
    padding: 15px;
    outline: none;
    resize: none;
    font-size: 1.1em;
    margin-top: 20px;
    border-radius: 5px;
    border-color: #bfbfbf;

    &--description {
      height: 100px;
      max-height: 330px;

      &::-webkit-scrollbar {
        width: 0;
      }
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
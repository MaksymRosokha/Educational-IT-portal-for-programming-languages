<template>
  <form class="test-updater" :action="this.link" method="post">
    <div v-for="(question, questionIndex) in this.questions" class="test-updater__question question">
      <input class="question__input-text"
             :name="'question_text-' + questionIndex"
             type="text"
             placeholder="Введіть запитання"
             required
             v-model="question.title"/>
      <div class="question__answers answers">
        <div v-for="(answer, answerIndex) in question.answers" :key="answerIndex" class="answers__answer answer">
          <input type="radio"
                 class="answer__input-radio"
                 :name="'answer_checked-' + questionIndex"
                 :value="answerIndex"
                 :checked="answer.isCorrect"
                 required>
          <input type="text"
                 class="answer__input-text"
                 placeholder="Введіть варіант відповіді"
                 required
                 :name="'answer-' + questionIndex + '-' + answerIndex"
                 v-model="answer.text">
        </div>

        <button @click="addAnswerOption(questionIndex)"
                type="button"
                class="test-updater__button test-updater__button--add-answer-option">
          Додати варіант відповіді
        </button>
      </div>
    </div>

    <button @click="addQuestion"
            type="button"
            class="test-updater__button test-updater__button--add-question">
      Додати запитання
    </button>
    <button @click="deleteQuestion"
            type="button"
            class="test-updater__button test-updater__button--delete-question">
      Видалити запитання
    </button>

    <input type="hidden" name="_token" :value="this.csrf">
    <input type="hidden" name="test_id" :value="this.testData.id">

    <form-button class="test-updater__btn-submit">Редагувати</form-button>
  </form>
</template>

<script>
export default {
  name: "TestUpdater",
  data() {
    return {
      testData: [],
      questions: [],
    }
  },
  props: {
    link: {
      type: String,
      required: true,
    },
    test: {
      type: Object,
      required: true,
    }
  },
  methods: {
    setData() {
      this.testData = JSON.parse(this.test);
      this.testData.questions.forEach((question) => {
        this.questions.push({
          title: question.text,
          answers: [],
        });

        question.answer_options.forEach((answer) => {
          this.questions[this.questions.length - 1].answers.push({
            text: answer.text,
            isCorrect: answer.is_correct,
          });

        });
      });
    },
    addQuestion() {
      this.questions.push({
        title: '',
        answers: [],
      });
      this.addAnswerOption(this.questions.length - 1);
      this.addAnswerOption(this.questions.length - 1);
    },
    deleteQuestion() {
      if (this.questions.length > 1) {
        this.questions.pop();
      }
    },
    addAnswerOption(questionIndex) {
      this.questions[questionIndex].answers.push({
        text: '',
      });
    },
  },
  computed: {
    csrf() {
      return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    },
  },
  beforeMount() {
    this.setData();
  },
}
</script>

<style scoped lang="scss">

.test-updater {
  display: flex;
  flex-direction: column;
  width: 700px;
  overflow-x: hidden;
  overflow-y: auto;
  max-height: 100%;

  @media(max-width: 800px) {
    width: 500px;
  }

  @media(max-width: 570px) {
    width: 290px;
  }

  &__question {
  }

  &__button {
    align-self: flex-end;
    border-radius: 10px;
    width: fit-content;
    height: fit-content;
    padding: 5px;
    background-color: rgb(0, 46, 89);
    color: #ffffff;
    margin-top: 10px;
    transition: background-color .6s,
    border .4s,
    font-weight .1s,
    padding .4s,
    border-radius .6s;

    &:hover {
      background-color: #40c240;
      border-radius: 25px;
      border: solid 1px #316b00;
      font-weight: bold;
      font-size: 1.1em;
      padding: 10px;
    }

    &--add-answer-option {
    }

    &--add-question {
    }

    &--delete-question {

      &:hover {
        background-color: #ff0000;
        border-radius: 25px;
        border: solid 1px #6b0000;
        font-weight: bold;
        font-size: 1.1em;
        padding: 10px;
      }
    }
  }

  &__btn-submit {
    margin-top: 20px;
  }
}

.question {
  &__input-text {
    width: 100%;
    height: 40px;
    padding: 15px;
    outline: none;
    resize: none;
    font-size: 1.2em;
    margin-top: 20px;
    border-radius: 5px;
    border-color: #bfbfbf;
  }

  &__answers {
    margin-top: 20px;
  }
}

.answers {
  &__answer {
  }
}

.answer {
  display: flex;
  align-items: center;

  &__input-radio {
    width: 5%;
    height: 20px;
  }

  &__input-text {
    width: 95%;
    height: 40px;
    padding: 15px;
    outline: none;
    resize: none;
    font-size: 1em;
    border-radius: 5px;
    border-color: #bfbfbf;
  }
}
</style>
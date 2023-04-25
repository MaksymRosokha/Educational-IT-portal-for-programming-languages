<template>
  <div class="lesson-creator">
    <form class="lesson-creator__form" @submit.prevent="this.sendData">
      <label for="title" class="lesson-creator__label">Введіть назву:</label>
      <form-input-field id="title"
                        class="lesson-creator__input"
                        name-of-input="title"
                        type-of-input="text"
                        placeholder-of-input="Введіть назву"
                        :is-required="true"
                        max-length-of-input="300"
                        :value-of-input="this.title"
                        @data="this.setTitle"/>
      <label for="editor" class="lesson-creator__label">Заповніть вміст:</label>
      <editor
          id="editor"
          class="lesson-creator__editor"
          api-key="5sy00rkq4ju0ge2hwggvivhvpqh0vc78l3fd7vvcxuxj026e"
          :init="{
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tableofcontents footnotes mergetags autocorrect typography inlinecss code',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
          }"
          v-model="this.content"
      />

      <input type="hidden" name="_token" :value="csrf">
      <form-button class="lesson-creator__btn-submit">Створити</form-button>
    </form>

    <success-or-fail-modal-window
        class="lesson-creator__result-window result-window"
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
  name: "LessonCreator",
  data() {
    return {
      title: "",
      content: "",
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
    programId: {
      type: Number,
      required: true,
    }
  },
  methods: {
    setTitle(value) {
      this.title = value;
    },
    clearData() {
      this.title = '';
      this.content = '';
    },
    sendData() {
      this.result.errors = {};
      const formData = new FormData();
      formData.append('programID', this.programId);
      formData.append('title', this.title);
      formData.append('content', this.content);
      formData.append('_token', this.csrf);

      axios.post(this.link, formData)
          .then(response => {
            this.result.text = 'Урок успішно створено';
            this.result.type = "success";
            this.result.isVisible = true;
            this.clearData();
          })
          .catch(error => {
            if (error.response && error.response.data && error.response.data.errors) {
              this.result.errors = error.response.data.errors;
              this.result.text = 'Не вдалося cтворити урок';
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

.lesson-creator {
  overflow-x: hidden;
  overflow-y: auto;
  max-height: 100%;

  &__form {
    display: flex;
    flex-direction: column;
  }

  &__label {
    margin-top: 5px;
  }

  &__input {
  }

  &__editor {
  }

  &__btn-submit {
    margin-top: 20px;
  }

  &__result-window {
  }
}

.result-window {

  // .result-window__errors

  &__errors {
  }

  // .result-window__list-of-errors

  &__list-of-errors {
  }

  // .result-window__error

  &__error {
  }
}
</style>
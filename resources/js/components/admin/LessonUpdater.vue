<template>
  <div class="lesson-updater">
    <form class="lesson-updater__form" @submit.prevent="this.sendData">
      <label for="title" class="lesson-updater__label">Введіть назву:</label>
      <form-input-field id="title"
                        class="lesson-updater__input"
                        name-of-input="title"
                        type-of-input="text"
                        placeholder-of-input="Введіть назву"
                        :is-required="true"
                        max-length-of-input="300"
                        :value-of-input="this.lessonData.title"
                        @data="this.setTitle"/>
      <label for="editor" class="lesson-updater__label">Заповніть вміст:</label>
      <editor
          id="editor"
          class="lesson-updater__editor"
          api-key="5sy00rkq4ju0ge2hwggvivhvpqh0vc78l3fd7vvcxuxj026e"
          :init="{
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tableofcontents footnotes mergetags autocorrect typography inlinecss code',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
          }"
          v-model="this.lessonData.content"
      />

      <input type="hidden" name="_token" :value="this.csrf">
      <form-button class="lesson-updater__btn-submit">Редагувати</form-button>
    </form>

    <success-or-fail-modal-window
        class="lesson-updater__result-window result-window"
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
  name: "LessonUpdater",
  data() {
    return {
      _token: this.csrf,
      lessonData: {},
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
    lesson: {
      type: Object,
      required: true,
    }
  },
  methods: {
    setTitle(value) {
      this.lessonData.title = value;
    },
    setData() {
      this.lessonData = JSON.parse(this.lesson);
    },
    sendData() {
      this.result.errors = {};
      const formData = new FormData();
      formData.append('id', this.lessonData.id);
      formData.append('title', this.lessonData.title);
      formData.append('content', this.lessonData.content);
      formData.append('_token', this.csrf);

      axios.post(this.link, formData)
          .then(response => {
            this.result.text = 'Укрок відредаговано';
            this.result.type = "success";
            this.result.isVisible = true;
          })
          .catch(error => {
            if (error.response && error.response.data && error.response.data.errors) {
              this.result.errors = error.response.data.errors;
              this.result.text = 'Не вдалося відредагувати урок';
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

.lesson-updater {
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

  &__errors {
  }

  &__list-of-errors {
  }

  &__error {
  }
}
</style>
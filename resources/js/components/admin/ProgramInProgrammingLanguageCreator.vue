<template>
  <div class="program-in-programming-language-creator">
    <form class="program-in-programming-language-creator__form" @submit.prevent="sendData">
      <label for="name" class="program-in-programming-language-creator__label">Введіть назву:</label>
      <form-input-field id="name"
                        class="program-in-programming-language-creator__input"
                        name-of-input="name"
                        type-of-input="text"
                        placeholder-of-input="Введіть назву"
                        :is-required="true"
                        max-length-of-input="100"
                        :value-of-input="name"
                        @data="setName"/>
      <label for="image" class="program-in-programming-language-creator__label">Виберіть зображення:</label>
      <input id="image"
             ref="imageInput"
             class="program-in-programming-language-creator__input program-in-programming-language-creator__input--file"
             type="file"
             name="image"
             accept="image/*"
             @change="setImage">
      <label for="editor" class="program-in-programming-language-creator__label">Напишіть опис:</label>
      <editor
          id="editor"
          class="program-in-programming-language-creator__editor"
          api-key="5sy00rkq4ju0ge2hwggvivhvpqh0vc78l3fd7vvcxuxj026e"
          :init="{
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tableofcontents footnotes mergetags autocorrect typography inlinecss code',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
          }"
          v-model="description"
      />

      <input type="hidden" name="_token" :value="csrf">
      <form-button class="program-in-programming-language-creator__btn-submit">Створити</form-button>
    </form>

    <success-or-fail-modal-window
        class="program-in-programming-language-creator__result-window result-window"
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
  name: "ProgramInProgrammingLanguageCreator",
  data() {
    return {
      name: "",
      image: '',
      description: "",
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
    programmingLanguageId: {
      type: Number,
      required: true,
    }
  },
  methods: {
    setImage(event) {
      this.image = event.target.files[0];
    },
    setName(value) {
      this.name = value;
    },
    clearData() {
      this.name = '';
      this.$refs.imageInput.value = null;
      this.description = '';
    },
    sendData() {
      this.result.errors = {};
      const formData = new FormData();
      formData.append('programmingLanguageID', this.programmingLanguageId);
      formData.append('name', this.name);
      formData.append('logo', this.image);
      formData.append('description', this.description);
      formData.append('_token', this.csrf);

      axios.post(this.link, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
          .then(response => {
            this.result.text = 'Програму для мови програмування успішно створено';
            this.result.type = "success";
            this.result.isVisible = true;
            this.clearData();
          })
          .catch(error => {
            if (error.response && error.response.data && error.response.data.errors) {
              this.result.errors = error.response.data.errors;
              this.result.text = 'Не вдалося cтворити програму для мови програмування';
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

.program-in-programming-language-creator {
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

  &__input--file {
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
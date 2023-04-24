<template>
  <div class="programming-language-updater">
    <form class="programming-language-updater__form" @submit.prevent="sendData">
      <label for="name" class="programming-language-updater__label">Введіть назву:</label>
      <form-input-field id="name"
                        class="programming-language-updater__input"
                        name-of-input="name"
                        type-of-input="text"
                        placeholder-of-input="Введіть назву"
                        :is-required="true"
                        max-length-of-input="100"
                        :value-of-input="programmingLanguageData.name"
                        @data="setName"/>
      <label for="logo" class="programming-language-updater__label">Виберіть зображення:</label>
      <input id="logo"
             ref="imageInput"
             class="programming-language-updater__input programming-language-updater__input--file"
             type="file"
             name="logo"
             accept="image/*"
             @change="setImage">
      <label for="editor" class="programming-language-updater__label">Напишіть опис:</label>
      <editor
          id="editor"
          class="programming-language-updater__editor"
          api-key="5sy00rkq4ju0ge2hwggvivhvpqh0vc78l3fd7vvcxuxj026e"
          :init="{
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tableofcontents footnotes mergetags autocorrect typography inlinecss code',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
          }"
          v-model="programmingLanguageData.description"
      />

      <input type="hidden" name="_token" :value="csrf">
      <form-button class="programming-language-updater__btn-change">Створити</form-button>
    </form>

    <success-or-fail-modal-window
        class="programming-language-updater__result-window result-window"
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
  name: "ProgrammingLanguageUpdater",
  data() {
    return {
      logo: '',
      _token: this.csrf,
      programmingLanguageData: {},
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
    programmingLanguage: {
      type: Object,
      required: true,
    }
  },
  methods: {
    setImage(event) {
      this.logo = event.target.files[0];
    },
    setName(value) {
      this.programmingLanguageData.name = value;
    },
    setData(){
      this.programmingLanguageData = JSON.parse(this.programmingLanguage);
    },
    sendData() {
      this.result.errors = {};
      const formData = new FormData();
      formData.append('id', this.programmingLanguageData.id);
      formData.append('name', this.programmingLanguageData.name);
      formData.append('logo', this.logo);
      formData.append('description', this.programmingLanguageData.description);
      formData.append('_token', this.csrf);

      axios.post(this.link, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
          .then(response => {
            this.result.text = 'Мову програмування успішно відредаговано';
            this.result.type = "success";
            this.result.isVisible = true;
            this.clearData();
          })
          .catch(error => {
            if (error.response && error.response.data && error.response.data.errors) {
              this.result.errors = error.response.data.errors;
              this.result.text = 'Не вдалося відредагувати мову програмування';
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

.programming-language-updater {
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

  &__btn-change {
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
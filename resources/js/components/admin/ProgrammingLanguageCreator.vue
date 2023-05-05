<template>
  <div class="programming-language-creator">
    <form class="programming-language-creator__form" @submit.prevent="sendData">
      <label for="name" class="programming-language-creator__label">Введіть назву:</label>
      <form-input-field id="name"
                        class="programming-language-creator__input"
                        name-of-input="name"
                        type-of-input="text"
                        placeholder-of-input="Введіть назву"
                        :is-required="true"
                        max-length-of-input="100"
                        :value-of-input="name"
                        @data="setName"/>
      <label for="logo" class="programming-language-creator__label">Виберіть зображення:</label>
      <input id="logo"
             ref="imageInput"
             class="programming-language-creator__input programming-language-creator__input--file"
             type="file"
             name="logo"
             accept="image/*"
             @change="setImage">
      <label for="editor" class="programming-language-creator__label">Напишіть опис:</label>
      <editor
          id="editor"
          class="programming-language-creator__editor"
          api-key="5sy00rkq4ju0ge2hwggvivhvpqh0vc78l3fd7vvcxuxj026e"
          :init="{
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker tinymcespellchecker permanentpen advcode codesample',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | codesample | removeformat',
            menubar: 'insert',
            images_upload_handler: this.uploadImage,
          }"
          v-model="description"
      />

      <input type="hidden" name="_token" :value="csrf">
      <form-button class="programming-language-creator__btn-submit">Створити</form-button>
    </form>

    <success-or-fail-modal-window
        class="programming-language-creator__result-window result-window"
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
  name: "ProgrammingLanguageCreator",
  data() {
    return {
      name: "",
      logo: '',
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
    }
  },
  methods: {
    setImage(event) {
      this.logo = event.target.files[0];
    },
    setName(value) {
      this.name = value;
    },
    clearData() {
      this.name = '';
      this.$refs.imageInput.value = null;
      this.description = '';
    },
    uploadImage(blobInfo, success, failure, progress) {
      let xhr, formData;
      const PATH_TO_IMAGES = 'storage/images/programmingLanguages/';

      xhr = new XMLHttpRequest();
      xhr.withCredentials = false;
      xhr.open('POST', '/admin/upload_content_image');

      xhr.upload.onprogress = function (e) {
        progress(e.loaded / e.total * 100);
      };

      xhr.onload = function () {
        let json;

        if (xhr.status === 403) {
          failure('HTTP Error: ' + xhr.status, {remove: true});
          return;
        }

        if (xhr.status < 200 || xhr.status >= 300) {
          failure('HTTP Error: ' + xhr.status);
          return;
        }

        json = JSON.parse(xhr.responseText);

        if (!json || typeof json.location != 'string') {
          failure('Invalid JSON: ' + xhr.responseText);
          return;
        }

        success(json.location);
      };

      xhr.onerror = function () {
        failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
      };

      formData = new FormData();
      formData.append('image', blobInfo.blob(), blobInfo.filename());
      formData.append('pathToImages', PATH_TO_IMAGES);
      formData.append('_token', this.csrf);

      xhr.send(formData);
    },
    sendData() {
      this.result.errors = {};
      const formData = new FormData();
      formData.append('name', this.name);
      formData.append('logo', this.logo);
      formData.append('description', this.description);
      formData.append('_token', this.csrf);

      axios.post(this.link, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
          .then(response => {
            this.result.text = 'Мову програмування успішно створено';
            this.result.type = "success";
            this.result.isVisible = true;
            this.clearData();
          })
          .catch(error => {
            if (error.response && error.response.data && error.response.data.errors) {
              this.result.errors = error.response.data.errors;
              this.result.text = 'Не вдалося cтворити мову програмування';
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

.programming-language-creator {
  overflow-x: hidden;
  overflow-y: auto;
  max-height: 100%;

  // .programming-language-creator__form

  &__form {
    display: flex;
    flex-direction: column;
  }

  // .programming-language-creator__label

  &__label {
    margin-top: 5px;
  }

  // .programming-language-creator__input

  &__input {
  }

  // .programming-language-creator__input--file

  &__input--file {
  }

  // .programming-language-creator__editor

  &__editor {
  }

  // .programming-language-creator__btn-change

  &__btn-submit {
    margin-top: 20px;
  }

  // .programming-language-creator__result-window

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
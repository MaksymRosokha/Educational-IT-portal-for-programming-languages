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
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker tinymcespellchecker permanentpen advcode codesample',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | codesample | removeformat',
            menubar: 'insert',
            images_upload_handler: this.uploadImage,
          }"
          v-model="programmingLanguageData.description"
      />

      <input type="hidden" name="_token" :value="csrf">
      <form-button class="programming-language-updater__btn-submit">Редагувати</form-button>
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
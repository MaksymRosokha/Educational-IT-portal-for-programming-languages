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
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount codesample',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | codesample | removeformat',
            menubar: 'insert',
            images_upload_handler: this.uploadImage,
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
    uploadImage(blobInfo, success, failure, progress) {
      let xhr, formData;
      const PATH_TO_IMAGES = 'storage/images/lessons/';

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
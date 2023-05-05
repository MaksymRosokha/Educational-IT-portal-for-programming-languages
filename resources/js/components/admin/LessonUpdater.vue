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
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker tinymcespellchecker permanentpen advcode codesample',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | codesample | removeformat',
            menubar: 'insert',
            images_upload_handler: this.uploadImage,
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
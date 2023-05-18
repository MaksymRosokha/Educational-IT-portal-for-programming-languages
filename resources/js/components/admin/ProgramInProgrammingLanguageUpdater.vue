<template>
  <div class="program-in-programming-language-updater">
    <form class="program-in-programming-language-updater__form" @submit.prevent="sendData">
      <label for="name" class="program-in-programming-language-updater__label">Введіть назву:</label>
      <form-input-field id="name"
                        class="program-in-programming-language-updater__input"
                        name-of-input="name"
                        type-of-input="text"
                        placeholder-of-input="Введіть назву"
                        :is-required="true"
                        max-length-of-input="100"
                        :value-of-input="programData.name"
                        @data="setName"/>
      <label for="image" class="program-in-programming-language-updater__label">Виберіть зображення:</label>
      <input id="image"
             ref="imageInput"
             class="program-in-programming-language-updater__input programming-language-updater__input--file"
             type="file"
             name="image"
             accept="image/*"
             @change="setImage">
      <label for="editor" class="program-in-programming-language-updater__label">Напишіть опис:</label>
      <editor
          id="editor"
          class="program-in-programming-language-updater__editor"
          api-key="5sy00rkq4ju0ge2hwggvivhvpqh0vc78l3fd7vvcxuxj026e"
          :init="{
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount codesample',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | codesample | removeformat',
            images_upload_handler: this.uploadImage,
          }"
          v-model="programData.description"
      />

      <input type="hidden" name="_token" :value="csrf">
      <form-button class="program-in-programming-language-updater__btn-submit">Редагувати</form-button>
    </form>

    <success-or-fail-modal-window
        class="program-in-programming-language-updater__result-window result-window"
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
  name: "ProgramInProgrammingLanguageUpdater",
  data() {
    return {
      image: '',
      _token: this.csrf,
      programData: {},
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
    program: {
      type: Object,
      required: true,
    }
  },
  methods: {
    setImage(event) {
      this.image = event.target.files[0];
    },
    setName(value) {
      this.programData.name = value;
    },
    setData(){
      this.programData = JSON.parse(this.program);
    },
    uploadImage(blobInfo, success, failure, progress) {
      let xhr, formData;
      const PATH_TO_IMAGES = 'storage/images/programsInProgrammingLanguages/';

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
      formData.append('id', this.programData.id);
      formData.append('name', this.programData.name);
      formData.append('image', this.image);
      formData.append('description', this.programData.description);
      formData.append('_token', this.csrf);

      axios.post(this.link, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
          .then(response => {
            this.result.text = 'Програму успішно відредаговано';
            this.result.type = "success";
            this.result.isVisible = true;
          })
          .catch(error => {
            if (error.response && error.response.data && error.response.data.errors) {
              this.result.errors = error.response.data.errors;
              this.result.text = 'Не вдалося відредагувати програму';
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

.program-in-programming-language-updater {
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